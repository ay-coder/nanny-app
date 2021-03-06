<?php

namespace App\Repositories\Frontend\Access\User;

use App\Models\Access\User\User;
use App\Models\Sitters\Sitters;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\Access\User\SocialLogin;
use App\Events\Frontend\Auth\UserConfirmed;
use App\Repositories\Backend\Access\Role\RoleRepository;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use Carbon\Carbon;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = User::class;

    /**
     * @var RoleRepository
     */
    protected $role;

    /**
     * @param RoleRepository $role
     */
    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }

    /**
     * @param $email
     *
     * @return bool
     */
    public function findByEmail($email)
    {
        return $this->query()->where('email', $email)->first();
    }

    /**
     * @param $token
     *
     * @throws GeneralException
     *
     * @return mixed
     */
    public function findByToken($token)
    {
        return $this->query()->where('confirmation_code', $token)->first();
    }

    /**
     * @param $token
     *
     * @throws GeneralException
     *
     * @return mixed
     */
    public function getEmailForPasswordToken($token)
    {
        $rows = DB::table(config('auth.passwords.users.table'))->get();

        foreach ($rows as $row) {
            if (password_verify($token, $row->token)) {
                return $row->email;
            }
        }

        throw new GeneralException(trans('auth.unknown'));
    }

    /**
     * @param array $data
     * @param bool  $provider
     *
     * @return static
     */
    public function create(array $data, $provider = false)
    {
        $user = self::MODEL;
        $user = new $user();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->mobile = isset($data['mobile']) ? $data['mobile'] : null;
        $user->status = 1;
        $user->user_type = isset($data['user_type']) ? $data['user_type'] : 1; // 1 = parent , 2 = sitter
        $user->password = $provider ? null : bcrypt($data['password']);
        $user->confirmed = 1;

        DB::transaction(function () use ($user) {
            if ($user->save()) {
                /*
                 * Add the default site role to the new user
                 */
                $user->attachRole($this->role->getDefaultUserRole());
            }
        });

        /*
         * If users have to confirm their email and this is not a social account,
         * send the confirmation email
         *
         * If this is a social account they are confirmed through the social provider by default
         */
        /*if (config('access.users.confirm_email') && $provider === false) {
            $user->notify(new UserNeedsConfirmation($user->confirmation_code));
        }*/

        /*
         * Return the user object
         */
        return $user;
    }

    /**
     * @param $data
     * @param $provider
     *
     * @return UserRepository|bool
     * @throws GeneralException
     */
    public function findOrCreateSocial($data, $provider)
    {
        // User email may not provided.
        $user_email = $data->email ?: "{$data->id}@{$provider}.com";

        // Check to see if there is a user with this email first.
        $user = $this->findByEmail($user_email);

        /*
         * If the user does not exist create them
         * The true flag indicate that it is a social account
         * Which triggers the script to use some default values in the create method
         */
        if (! $user) {
            // Registration is not enabled
            if (! config('access.users.registration')) {
                throw new GeneralException(trans('exceptions.frontend.auth.registration_disabled'));
            }

            $user = $this->create([
                'name'  => $data->name,
                'email' => $user_email,
            ], true);
        }

        // See if the user has logged in with this social account before
        if (! $user->hasProvider($provider)) {
            // Gather the provider data for saving and associate it with the user
            $user->providers()->save(new SocialLogin([
                'provider'    => $provider,
                'provider_id' => $data->id,
                'token'       => $data->token,
                'avatar'      => $data->avatar,
            ]));
        } else {
            // Update the users information, token and avatar can be updated.
            $user->providers()->update([
                'token'       => $data->token,
                'avatar'      => $data->avatar,
            ]);
        }

        // Return the user object
        return $user;
    }

    /**
     * @param $token
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function confirmAccount($token)
    {
        $user = $this->findByToken($token);

        if ($user->confirmed == 1) {
            throw new GeneralException(trans('exceptions.frontend.auth.confirmation.already_confirmed'));
        }

        if ($user->confirmation_code == $token) {
            $user->confirmed = 1;

            event(new UserConfirmed($user));

            return $user->save();
        }

        throw new GeneralException(trans('exceptions.frontend.auth.confirmation.mismatch'));
    }

    /**
     * @param $id
     * @param $input
     *
     * @throws GeneralException
     *
     * @return mixed
     */
    public function updateProfile($id, $input)
    {
        $user = $this->find($id);
        $user->name = $input['name'];

        if ($user->canChangeEmail()) {
            //Address is not current address
            if ($user->email != $input['email']) {
                //Emails have to be unique
                if ($this->findByEmail($input['email'])) {
                    throw new GeneralException(trans('exceptions.frontend.auth.email_taken'));
                }

                // Force the user to re-verify his email address
                $user->confirmation_code = md5(uniqid(mt_rand(), true));
                $user->confirmed = 0;
                $user->email = $input['email'];
                $updated = $user->save();

                // Send the new confirmation e-mail
                $user->notify(new UserNeedsConfirmation($user->confirmation_code));

                return [
                    'success' => $updated,
                    'email_changed' => true,
                ];
            }
        }

        return $user->save();
    }

    public function updateParent($id, $request)
    {
        $user = $this->find($id);
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->birthdate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->birthdate)->format('d/m/Y');
        $user->address = $request->address;
        $user->gender = $request->gender;

        if($request->file('profile_pic'))
        {
            $imageName  = rand(11111, 99999) . '_user.' . $request->file('profile_pic')->getClientOriginalExtension();
            if(strlen($request->file('profile_pic')->getClientOriginalExtension()) > 0)
            {
                $request->file('profile_pic')->move(base_path() . '/public/uploads/user/', $imageName);
                $user->profile_pic = $imageName;
            }
        }

        return $user->save();

    }

    /**
     * Update Sitter
     * @param $id
     * @param $request
     * @return
     */
    public function updateSitter($id, $request)
    {
        $user = $this->find($id);
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->birthdate = Carbon::createFromFormat('d/m/Y', $request->birthdate)->format('d/m/Y');
        $user->address = $request->address;
        $user->gender = $request->gender;

        if($request->file('profile_pic'))
        {
            $imageName  = rand(11111, 99999) . '_user.' . $request->file('profile_pic')->getClientOriginalExtension();
            if(strlen($request->file('profile_pic')->getClientOriginalExtension()) > 0)
            {
                $request->file('profile_pic')->move(base_path() . '/public/uploads/user/', $imageName);
                $user->profile_pic = $imageName;
            }
        }

        if($user->save()) {

            $sitter   = Sitters::where('user_id', $id)->first();

            $sitter->sitter_start_time = Carbon::parse($request->sitter_start_time)->format('H:i:s');
            $sitter->sitter_end_time   = Carbon::parse($request->sitter_end_time)->format('H:i:s');
            $sitter->about_me          = $request->about_me;
            $sitter->description       = $request->description;

            return $sitter->save();
        }

        throw new GeneralException('There was a problem updating your profile. Please try again.');
    }

    /**
     * @param $input
     *
     * @throws GeneralException
     *
     * @return mixed
     */
    public function changePassword($input)
    {
        $user = $this->find(access()->id());

        if (Hash::check($input['old_password'], $user->password)) {
            $user->password = bcrypt($input['password']);

            return $user->save();
        }

        throw new GeneralException(trans('exceptions.frontend.auth.password.change_mismatch'));
    }
}
