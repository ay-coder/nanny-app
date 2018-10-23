<?php

/**
 * Global helpers file with misc functions.
 */
if (! function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (! function_exists('access')) {
    /**
     * Access (lol) the Access:: facade as a simple function.
     */
    function access()
    {
        return app('access');
    }
}

if (! function_exists('hasher')) {
    /**
     * Hasher Function
     */
    function hasher()
    {
        return app('hasher');
    }
}


if (! function_exists('history')) {
    /**
     * Access the history facade anywhere.
     */
    function history()
    {
        return app('history');
    }
}

if (! function_exists('gravatar')) {
    /**
     * Access the gravatar helper.
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (! function_exists('includeRouteFiles')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function includeRouteFiles($folder)
    {
        $directory = $folder;
        $handle = opendir($directory);
        $directory_list = [$directory];

        while (false !== ($filename = readdir($handle))) {
            if ($filename != '.' && $filename != '..' && is_dir($directory.$filename)) {
                array_push($directory_list, $directory.$filename.'/');
            }
        }

        foreach ($directory_list as $directory) {
            foreach (glob($directory.'*.php') as $filename) {
                require $filename;
            }
        }
    }
}

if (! function_exists('getRtlCss')) {

    /**
     * The path being passed is generated by Laravel Mix manifest file
     * The webpack plugin takes the css filenames and appends rtl before the .css extension
     * So we take the original and place that in and send back the path.
     *
     * @param $path
     *
     * @return string
     */
    function getRtlCss($path)
    {
        $path = explode('/', $path);
        $filename = end($path);
        array_pop($path);
        $filename = rtrim($filename, '.css');

        return implode('/', $path).'/'.$filename.'.rtl.css';
    }
}

if (! function_exists('profileCompletion')) {

    /**
     * User Profile complition percentage
     *
     * @param $path
     *
     * @return string
     */
    function profileCompletion($userInfo)
    {
        $count  = 0;
        $mobile = $gender = $address = $birthdate = $name   = false;

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

        return (int) $count;
    }
}

if (! function_exists('AvgRating')) {

    /**
     * User Avg Rating
     *
     * @param $path
     *
     * @return string
     */
    function AvgRating($userId = null, $sitterId = null, $bookingId = null)
    {
        $rating = new App\Models\Reviews\Reviews();

        if(!is_null($bookingId)) {
            $rating = $rating->where('booking_id', $bookingId)->select('rating')->first();

            if(is_null($rating))
            {
                $rating = 0;
            }

            return isset($rating->rating) ? $rating->rating : 0;
        }

        if(!is_null($userId)) {
            $rating = $rating->where('user_id', $userId);
        }

        if(!is_null($sitterId)) {
            $rating = $rating->where('sitter_id', $sitterId);
        }

        $rating = $rating->avg('rating');

        if(is_null($rating))
        {
            $rating = 0;
        }

        return $rating;
    }
}

if (! function_exists('totalEarning')) {

    /**
     * User Avg Rating
     *
     * @param $path
     *
     * @return string
     */
    function totalEarning($userId = null)
    {
        $total = 0;
        if(is_null($userId)) {
            $userInfo = App\Models\Access\User\User::where('user_id', access()->user()->id)->first();
        } else {
            $userInfo = access()->user();
        }
        $sitter         = App\Models\Sitters\Sitters::where('user_id', $userInfo->id)->first();
        $bookingRepo    = new App\Repositories\Booking\EloquentBookingRepository();
        $sitterBookings = $bookingRepo->getSitterCompletedBookings($userInfo->id);

        if(isset($sitterBookings) && count($sitterBookings))
        {
            foreach ($sitterBookings as $item) {
                $payment       = (object) $item->payment;
                if(isset($payment) && isset($payment->id))
                {
                    $total      = $total + $payment->total;
                }
            }

            return $total;
        }

        return $total;

    }
}