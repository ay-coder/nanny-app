<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Repositories\Frontend\Access\User\UserRepository;
use Illuminate\Http\Request;
use App\Repositories\Babies\EloquentBabiesRepository;

/**
 * Class ProfileController.
 */
class ProfileController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * ProfileController constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @param UpdateProfileRequest $request
     *
     * @return mixed
     */
    public function update(UpdateProfileRequest $request)
    {
        $output = $this->user->updateProfile(access()->id(), $request->all());

        // E-mail address was updated, user has to reconfirm
        if (is_array($output) && $output['email_changed']) {
            access()->logout();

            return redirect()->route('frontend.auth.login')->withFlashInfo(trans('strings.frontend.user.email_changed_notice'));
        }

        return redirect()->route('frontend.user.account')->withFlashSuccess(trans('strings.frontend.user.profile_updated'));
    }

    /**
     * Update Parent
     * @param  Request $request
     * @return [type]
     */
    public function updateParent(UpdateProfileRequest $request)
    {
        $output = $this->user->updateParent(access()->id(), $request);

        return redirect()->route('frontend.user.parent.account')->withFlashSuccess(trans('strings.frontend.user.profile_updated'));
    }

    /**
     * Update Babies
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateBabies(Request $request)
    {
        $babyRepository = new EloquentBabiesRepository();
        $output = $babyRepository->updateBabies($request);
        return redirect()->route('frontend.user.parent.account')->withFlashSuccess('Babies Successfully updated.');
    }

    /**
     * Add Babies
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addBabies(Request $request)
    {
        $babyRepository = new EloquentBabiesRepository();
        $input = $request->all();
        $input      = array_merge($input, ['image' => 'default.png', 'parent_id' => access()->user()->id]);

        if($request->file('image'))
        {
            $imageName  = rand(11111, 99999) . '_baby.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(base_path() . '/public/uploads/babies/', $imageName);
            $input = array_merge($input, ['image' => $imageName]);
        }

        $output = $babyRepository->create($input);

        return redirect()->route('frontend.user.parent.account')->withFlashSuccess('Babies Successfully added.');
    }

    /**
     * Delete
     *
     * @param Request $request
     * @return string
     */
    public function deleteBaby($id)
    {
        if($id)
        {
            $babyRepository = new EloquentBabiesRepository();
            $userInfo   = access()->user();
            $babyCount  = $babyRepository->model->where([
                'id'        => $id,
                'parent_id' => $userInfo->id
                ])->count();

            if($babyCount > 0)
            {
                $status     = $babyRepository->destroy($id);

                if($status)
                {
                    return redirect()->route('frontend.user.parent.account')->withFlashSuccess('Baby Successfully deleted.');
                }
            }
        }
        return redirect()->route('frontend.user.parent.account')->withFlashDanger('Baby Not Found or Baby Already Deleted !');
    }


    /**
     * Update Sitter
     * @param  Request $request
     * @return [type]
     */
    public function updateSitter(UpdateProfileRequest $request)
    {
        $output = $this->user->updateSitter(access()->id(), $request);

        return redirect()->route('frontend.user.sitter.account')->withFlashSuccess(trans('strings.frontend.user.profile_updated'));
    }
}
