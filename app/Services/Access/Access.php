<?php

namespace App\Services\Access;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Notifications\Notifications;
use App\Models\Reviews\Reviews;
use App\Models\Babies\Babies;
use App\Models\Sitters\Sitters;
use App\Library\Push\PushNotification;
use App\Models\Activation\Activation;
use App\Models\Booking\Booking;
use App\Models\General\General;


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
     * Add Notification
     *
     * @param array $data
     */
    public function addNotification($data = array())
    {
        if(isset($data) && count($data))
        {
            return Notifications::create($data);
        }

        return false;
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

    public function getSitterPerHour($sitterId = null)
    {
        $value =  General::where('data_key', 'sitter_hourly_rate')->select('data_value')->first();

        return $value->data_value;
    }

    /**
     * Get Sitter PerHourBy Booking
     * 
     * @param string|ing $bookingType
     * @return float
     */
    public function getSitterPerHourByBooking($bookingType = null)
    {
        if($bookingType == 1)
        {
            $value =  General::where('data_key', 'booking_touriest_rate')->select('data_value')->first();
        }
        else
        {
            $value =  General::where('data_key', 'booking_local_rate')->select('data_value')->first();

        }

        if($value)
        {
            return $value->data_value;
        }

        return 10;
    }

    /**
     * Sent Push Notification
     * 
     * @param object $user
     * @param array $payload
     * @return bool
     */
    public function sentPushNotification($user = null, $payload = null)
    {
        if($user && $payload)
        {
            if(isset($user->device_token) && strlen($user->device_token) > 4 && $user->device_type == 1)
            {
                PushNotification::iOS($payload, $user->device_token);
            }
            else
            {
                if(isset($user->device_token) && strlen($user->device_token) > 4)
                {
                    PushNotification::android($payload, $user->device_token);
                }
            }
        }

        return true;
    }

    /**
     * Is ActiveBooking Available
     *
     * @param int
     * @return boolean|object
     */
    public function isActiveBookingAvailable($userId = null)
    {
        if($userId)
        {
            return Activation::where('user_id', $userId)->where('allowed_bookings', '>', 0)->first();
        }

        return false;
    }

    public function getBookingMultipleBabies($bookingId = null)
    {
        if($bookingId)
        {
            $bookingInfo = Booking::where('id', $bookingId)->first();

            if($bookingInfo->is_multiple == 1 && isset($bookingInfo->baby_ids))
            {
                $babyIds    = array_values(explode(',', $bookingInfo->baby_ids));
                return Babies::where('id', '!=', $bookingInfo->id)->whereIn('id', $babyIds)->get();
            }
        }

        return false;
    }

    public function restoreSingleBooking($userId = null)
    {
        if($userId)
        {
            $activation = Activation::where('user_id', $userId)->orderBy('id', 'desc')->first();

            if(isset($activation))        
            {
                $activation->allowed_bookings = $activation->allowed_bookings + 1;
                $activation->save();
            }
        }
        return true;
    }

    /**
     * Get My Availabe Booknigs
     * 
     * @param int $userId
     * @return int
     */
    public function getMyAvailabeBooknigs($userId = null)
    {
        $activation = Activation::where('user_id', $userId)->orderBy('id', 'desc')->get();

        return $activation->sum('allowed_bookings');
    }

    /**
     * Get Config Value
     * 
     * @param string $key
     * @return mixed
     */
    public function getConfigValue($key = null)
    {
        if($key)
        {
            $value =  General::where('data_key', $key)->select('data_value')->first();

            return $value->data_value;

        }
        return '';
    }

    /**
     * Get Booking Total
     * 
     * @param int $bookingId
     * @return float
     */
    public function getBookingTotal($bookingId = null)
    {
        if($bookingId)
        {
            $bookingInfo    = Booking::where('id', $bookingId)->first();
            $tax            = $this->getBookingTax($bookingId);
            $babiesCount    = isset($bookingInfo->baby_ids) ? count(explode(',', $bookingInfo->baby_ids)) : 0;
            $sitterRate     = $this->getSitterPerHourByBooking($bookingInfo->booking_type);
            $subTotal       = $bookingInfo->parking_fees + ($sitterRate) * (round((strtotime($bookingInfo->booking_end_time) - strtotime($bookingInfo->booking_start_time))/3600, 1));

            if($babiesCount > 0)
            {
                $subTotal = $subTotal + $babiesCount;
            }

            return $subTotal + $tax;
        }

        return 0;
    }

    /**
     * Get Booking Tax
     * 
     * @param int $bookingId
     * @return float
     */
    public function getBookingTax($bookingId = null)
    {
        if($bookingId)
        {
            $bookingInfo    = Booking::where('id', $bookingId)->first();
            $tax            = $this->getConfigValue('booking_tax_rate');
            $babiesCount    = isset($bookingInfo->baby_ids) ? count(explode(',', $bookingInfo->baby_ids)) : 0;
            $sitterRate     = $this->getSitterPerHourByBooking($bookingInfo->booking_type);
            $subTotal       = $bookingInfo->parking_fees + ($sitterRate) * (round((strtotime($bookingInfo->booking_end_time) - strtotime($bookingInfo->booking_start_time))/3600, 1));

            if($babiesCount > 0)
            {
                $subTotal = $subTotal + $babiesCount;
            }

            $taxAmount = 0;
            if(isset($tax) && $tax > 0)
            {
                $taxAmount = ( $subTotal * $tax ) / 100;
            }
            
            return $taxAmount;
        }

        return 0;
    }

    /**
     * Get Last Booking
     *
     * @param int $toUserId
     * @param int $fromUserId
     * @return object
     */
    public function getLastBooking($toUserId, $fromUserId)
    {
        $booking = Booking::where([
            'user_id'   => $toUserId,
            'sitter_id' => $fromUserId
        ])->orWhere([
            'user_id'   => $fromUserId,
            'sitter_id' => $toUserId
        ])->orderBy('id', 'DESC')->first();


        if(isset($booking))
        {
            return $booking;
        }

        return false;
    }
}
