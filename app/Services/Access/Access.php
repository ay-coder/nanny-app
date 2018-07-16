<?php

namespace App\Services\Access;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Notifications\Notifications;
use App\Models\Reviews\Reviews;
use App\Models\Babies\Babies;
use App\Models\Sitters\Sitters;

/**
 * Class Access.
 */
class Access
{
    /**
     * Get the currently authenticated user or null.
     */
    public function user()
    {
        return auth()->user();
    }

    /**
     * Return if the current session user is a guest or not.
     *
     * @return mixed
     */
    public function guest()
    {
        return auth()->guest();
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        return auth()->logout();
    }

    /**
     * Get the currently authenticated user's id.
     *
     * @return mixed
     */
    public function id()
    {
        return auth()->id();
    }

    /**
     * @param Authenticatable $user
     * @param bool            $remember
     */
    public function login(Authenticatable $user, $remember = false)
    {
        return auth()->login($user, $remember);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function loginUsingId($id)
    {
        return auth()->loginUsingId($id);
    }

    /**
     * Checks if the current user has a Role by its name or id.
     *
     * @param string $role Role name.
     *
     * @return bool
     */
    public function hasRole($role)
    {
        if ($user = $this->user()) {
            return $user->hasRole($role);
        }

        return false;
    }

    /**
     * Checks if the user has either one or more, or all of an array of roles.
     *
     * @param  $roles
     * @param bool $needsAll
     *
     * @return bool
     */
    public function hasRoles($roles, $needsAll = false)
    {
        if ($user = $this->user()) {
            return $user->hasRoles($roles, $needsAll);
        }

        return false;
    }

    /**
     * Check if the current user has a permission by its name or id.
     *
     * @param string $permission Permission name or id.
     *
     * @return bool
     */
    public function allow($permission)
    {
        if ($user = $this->user()) {
            return $user->allow($permission);
        }

        return false;
    }

    /**
     * Check an array of permissions and whether or not all are required to continue.
     *
     * @param  $permissions
     * @param  $needsAll
     *
     * @return bool
     */
    public function allowMultiple($permissions, $needsAll = false)
    {
        if ($user = $this->user()) {
            return $user->allowMultiple($permissions, $needsAll);
        }

        return false;
    }

    /**
     * @param  $permission
     *
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->allow($permission);
    }

    /**
     * @param  $permissions
     * @param  $needsAll
     *
     * @return bool
     */
    public function hasPermissions($permissions, $needsAll = false)
    {
        return $this->allowMultiple($permissions, $needsAll);
    }

    /**
     * Get Notification Count
     * 
     * @param int $userId
     * @return int
     */
    public function getUserUnreadNotificationCount($userId = null)
    {
        if($userId)
        {
            return Notifications::where(['user_id' => $userId, 'is_read' => 0])->count();
        }

        return 0;
    }

    /**
     * Get Average Rating
     * 
     * @param int $sitterId
     * @return int
     */
    public function getAverageRating($sitterId = null)
    {
        $reviews = Reviews::select('id', 'rating')->where('sitter_id', $sitterId)->get();

        if(isset($reviews) && count($reviews))
        {
            return number_format($reviews->sum('rating') / count($reviews), 2);
        }

        return 0;
    }

    public function userProfileCompletion($userInfo)
    {
        $count  = 0;
        $mobile = $gender = $address = $birthdate = $name   = false;

        if(isset($userInfo) && isset($userInfo->id))
        {
            if(isset($userInfo->name)  && strlen($userInfo->name) > 2)
            {
                $count  = $count + 20;
                $name   = true;
            }

            if(isset($userInfo->gender) && strlen($userInfo->gender) > 2)
            {
                $count      = $count + 20;
                $gender     = true;
            }

            
            if(isset($userInfo->mobile) && strlen($userInfo->mobile) > 2)
            {
                $count      = $count + 20;
                $mobile     = true;
            }

            if(isset($userInfo->address) && strlen($userInfo->address) > 2)
            {
                $count      = $count + 20;
                $address    = true;
            }

            if(isset($userInfo->birthdate) && strlen($userInfo->birthdate) > 2)
            {
                $count      = $count + 20;
                $birthdate  = true;
            }

            return [
                'name'                          => $name,
                'gender'                        => $gender,
                'mobile'                        => $mobile,
                'address'                       => $address,
                'birthdate'                     => $birthdate,
                'profile_completion_count'      => (int) $count
            ];
        }

        return [
            'name'                          => $name,
            'gender'                        => $gender,
            'mobile'                        => $mobile,
            'address'                       => $address,
            'birthdate'                     => $birthdate,
            'profile_completion_count'      => (int) $count
        ];
    }

    /**
     * Get User BabyCount
     * 
     * @param int $userId
     * @return int
     */
    public function getUserBabyCount($userId = null)
    {
        if($userId)
        {
            $baby = new Babies;

            return $baby->where('parent_id', $userId)->count();
        }

        return 0;
    }

    /**
     * Sitter Mode
     * 
     * @param int $sitterId
     * @return int
     */
    public function sitterMode($sitterId = null)
    {
        if($sitterId)
        {
            $sitter = Sitters::where('user_id', $sitterId)->first();

            if($sitter)
            {
                return $sitter->vacation_mode;
            }
        }

        return 0;
    }
}
