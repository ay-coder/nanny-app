<?php
namespace App\Http\Transformers;

use App\Http\Transformers;
use URL;
use App\Models\Babies\Babies;

class SittersTransformer extends Transformer
{
    /**
     * Transform
     *
     * @param array $data
     * @return array
     */
    public function transform($item)
    {
        if(is_array($item))
        {
            $item = (object)$item;
        }

        $item->user = (object) $item->user;

        $avgRating = 0.0;

        if(isset($item->reviews) && count($item->reviews))
        {
            $reviews    = collect($item->reviews);
            $avgRating  = $reviews->sum('rating') / count($reviews);
        }
        
        $response =  [
            "sitter_id"             => (int) $item->user_id, 
            "user_id"               => $item->user_id, 
            "category"              => $item->category, 
            "about_me"              => $item->about_me, 
            "description"           => $item->description, 
            'email'                 => $this->nulltoBlank($item->user->email),
            'name'                  => $this->nulltoBlank($item->user->name),
            'mobile'                => $this->nulltoBlank($item->user->mobile),
            'profile_pic'           => URL::to('/').'/uploads/user/' . $item->user->profile_pic, 
            'address'               => $this->nulltoBlank($item->user->address),
            'city'                  => $this->nulltoBlank($item->user->city),
            'state'                 => $this->nulltoBlank($item->user->state),
            'zip'                   => $this->nulltoBlank($item->user->zip),
            'gender'                => $this->nulltoBlank($item->user->gender),
            'birthday'              => $this->nulltoBlank($item->user->birthdate),
            'avg_rating'            => $avgRating,
            'per_hour'              => (float) access()->getSitterPerHour($item->user_id),
            'reviews'               => []
        ];

        if(count($item->reviews))
        {
            $reviewData = [];

            foreach($item->reviews as $review)   
            {
                $review = (object)$review;
                $review->user = (object) $review->user;

                $reviewData[] = [
                    'review_by_id'      => $review->user->id,
                    'review_by'         => $this->nulltoBlank($review->user->name),
                    'rating'            => (float) isset($review->rating) ? $review->rating : 0.00,
                    'description'       => $this->nulltoBlank($review->description),
                    'review_by_image'   =>  URL::to('/').'/uploads/user/' . $review->user->profile_pic,
                ];
            }

            $response['reviews'] = $reviewData;
        }

        return $response;
    }
    
    public function calendarTransform($items)
    {
        $response = [];

        $sr = 0;
        foreach($items as $item)   
        {
            $user           = (object) $item->user;
            $sitter         = (object) $item->sitter;
            $baby           = (object) $item->baby;
            $payment        = (object) $item->payment;
            $babyData       = [];
            $paymentData    = (object) [];
            $originalBaby   = false;

            if(isset($payment) && isset($payment->id))
            {
                $paymentData = [
                    'payment_id'    => (int) $payment->id,
                    'per_hour'      => (float) $payment->per_hour,
                    'total_hour'    => (float) $payment->total_hour,
                    'sub_total'     => (float) $payment->sub_total,
                    'tax'           => (float) $payment->tax,
                    'other_charges' => (float) $payment->other_charges,
                    'parking_fees'  => (float) $payment->parking_fees,
                    'total'         => (float) $payment->total,
                    'tip'           => (float) $payment->tip,
                    'description'   => $payment->description,
                     'payment_status'=> (int) isset($payment->payment_status) ? $this->nulltoBlank($payment->payment_status) : 0,
                    'payment_via'=> $this->nulltoBlank($payment->payment_via),
                    'payment_details'=> $this->nulltoBlank($payment->payment_details)
                ];
            }

            if(isset($baby) && isset($baby->id))
            {
                $originalBaby = $baby->id; 
                $babyData[] = [
                    'baby_id'       => (int) $baby->id,
                    "title"         =>  isset($baby->title) ? $baby->title : '',
                    "birthdate"     =>  isset($baby->birthdate) ? $baby->birthdate : '',
                    "age"           => (int) isset($baby->age) ? (int) $baby->age : 0,
                    "description"   =>  isset($baby->description) ? $baby->description : '', 
                    "image"         =>  URL::to('/').'/uploads/babies/'.$baby->image
                ];
            }
            
            if($item->is_multiple == 1 && isset($item->baby_ids))
            {
                $babyIds    = array_values(explode(',', $item->baby_ids));
                $babies     = Babies::whereIn('id', $babyIds)->get();
                $allBaby    = [];

                if(isset($babies) && count($babies))
                {
                    foreach($babies as $baby)
                    {
                        if($originalBaby == $baby->id)
                        {
                            continue;
                        }

                        $allBaby[] = [
                            'baby_id'       => (int) $baby->id,
                            "title"         =>  isset($baby->title) ? $baby->title : '',
                            "birthdate"     =>  isset($baby->birthdate) ? $baby->birthdate : '',
                            "age"           => (int) isset($baby->age) ? (int) $baby->age : 0,
                            "description"   =>  isset($baby->description) ? $baby->description : '', 
                            "image"         =>  URL::to('/').'/uploads/babies/'.$baby->image
                        ];
                    }
                }
            }

            $response[$sr] = [
                "booking_id"        => (int) $item->id,
                "user_id"           => (int) $item->user_id,
                "sitter_id"         => (int) $item->sitter_id,
                "user_name"         =>  $user->name,
                'sitter_name'       =>  $sitter->name,
                'sitter_contact'    =>  isset($sitter->mobile) ? $sitter->mobile : '',
                'sitter_rating'     =>  access()->getAverageRating($item->sitter_id),
                'profile_pic'       =>  URL::to('/').'/uploads/user/' . $sitter->profile_pic, 
                'user_profile_pic'  =>  URL::to('/').'/uploads/user/' . $user->profile_pic, 
                "baby_id"           =>  $item->baby_id, 
                "is_multiple"       =>  (int) isset($item->is_multiple) ? $item->is_multiple : 0,
                "booking_date"      =>  $item->booking_date, 
                "start_time"        =>  $item->start_time, 
                "end_time"          =>  $item->end_time, 
                "booking_startime"  =>  $this->nulltoBlank($item->booking_start_time), 
                "booking_endtime"   =>  $this->nulltoBlank($item->booking_end_time), 
                "booking_status"    =>  $item->booking_status, 
                'address'           => $this->nulltoBlank($user->address),
                'city'              => $this->nulltoBlank($user->city),
                'state'             => $this->nulltoBlank($user->state),
                'zip'               => $this->nulltoBlank($user->zip),
                "babies"            => [],
                "payment"           => $paymentData,
                'babies'            => isset($allBaby) && count($allBaby) ? array_merge($babyData, $allBaby) : $babyData,
                'payment_status'    => (int) isset($payment->payment_status) ? $this->nulltoBlank($payment->payment_status) : 0,
            ];
            $sr++;

            reset($babyData);
        }

        return $response;
    }

    public function pastBookingTransform($items)
    {
        $response = [];

        $sr = 0;
        foreach($items as $item)   
        {
            $user       = (object) $item->user;
            $sitter     = (object) $item->sitter;
            $baby       = (object) $item->baby;
            $payment    = (object) $item->payment;
            $paymentData = (object)[];
            $babyData   = [];

            if(isset($payment) && isset($payment->id))
            {
                $paymentData = [
                    'payment_id'    => (int) $payment->id,
                    'per_hour'      => (float) $payment->per_hour,
                    'total_hour'    => (float) $payment->total_hour,
                    'sub_total'     => (float) $payment->sub_total,
                    'tax'           => (float) $payment->tax,
                    'other_charges' => (float) $payment->other_charges,
                    'parking_fees'  => (float) $payment->parking_fees,
                    'total'         => (float) $payment->total,
                    'tip'           => (float) $payment->tip,
                    'description'   => $payment->description,
                    'payment_status'=> (int) isset($payment->payment_status) ? $this->nulltoBlank($payment->payment_status) : 0,
                    'payment_via'=> $this->nulltoBlank($payment->payment_via),
                    'payment_details'=> $this->nulltoBlank($payment->payment_details)
                ];
            }

            if(isset($baby) && isset($baby->id))
            {
                $babyData[] = [
                    'baby_id'       => (int) $baby->id,
                    "title"         =>  isset($baby->title) ? $baby->title : '',
                    "birthdate"     =>  isset($baby->birthdate) ? $baby->birthdate : '',
                    "age"           => (int) isset($baby->age) ? (int) $baby->age : 0,
                    "description"   =>  isset($baby->description) ? $baby->description : '', 
                    "image"         =>  URL::to('/').'/uploads/babies/'.$baby->image
                ];
            }
            
            if($item->is_multiple == 1 && isset($item->baby_ids))
            {
                $babyIds    = array_values(explode(',', $item->baby_ids));
                $babies     = Babies::whereIn('id', $babyIds)->get();

                if(isset($babies) && count($babies))
                {
                    foreach($babies as $baby)
                    {
                        $babyData[] = [
                            'baby_id'       => (int) $baby->id,
                            "title"         =>  isset($baby->title) ? $baby->title : '',
                            "birthdate"     =>  isset($baby->birthdate) ? $baby->birthdate : '',
                            "age"           => (int) isset($baby->age) ? (int) $baby->age : 0,
                            "description"   =>  isset($baby->description) ? $baby->description : '', 
                            "image"         =>  URL::to('/').'/uploads/babies/'.$baby->image
                        ];
                    }
                }
            }

            $response[$sr] = [
                "booking_id"        => (int) $item->id,
                "user_id"           => (int) $item->user_id,
                "sitter_id"         => (int) $item->sitter_id,
                "user_name"         =>  $user->name,
                'sitter_name'       =>  $sitter->name,
                'sitter_contact'    =>  isset($sitter->mobile) ? $sitter->mobile : '',
                'sitter_rating'     =>  access()->getAverageRating($item->sitter_id),
                'profile_pic'       =>  URL::to('/').'/uploads/user/' . $sitter->profile_pic, 
                'user_profile_pic'  =>  URL::to('/').'/uploads/user/' . $user->profile_pic, 
                "baby_id"           =>  $item->baby_id, 
                "is_multiple"       =>  (int) isset($item->is_multiple) ? $item->is_multiple : 0,
                "booking_date"      =>  $item->booking_date, 
                "start_time"        =>  $item->start_time, 
                "end_time"          =>  $item->end_time, 
                "booking_startime"  =>  $this->nulltoBlank($item->booking_start_time), 
                "booking_endtime"   =>  $this->nulltoBlank($item->booking_end_time), 
                "booking_status"    =>  $item->booking_status, 
                'address'           => $this->nulltoBlank($user->address),
                'city'              => $this->nulltoBlank($user->city),
                'state'             => $this->nulltoBlank($user->state),
                'zip'               => $this->nulltoBlank($user->zip),
                "babies"            => [],
                "payment"           => $paymentData,
                'babies'            => $babyData,
                'payment_status'    => (int) isset($payment->payment_status) ? (int) $payment->payment_status : 0,
            ];

            $sr++;
        }

        return $response;
    }

    public function singleBookingTransform($item)
    {
        $response = [];

        if(isset($item))
        {
            $user       = (object) $item->user;
            $sitter     = (object) $item->sitter;
            $baby       = (object) $item->baby;
            $payment    = (object) $item->payment;
            $paymentData = (object)[];
            $babyData   = [];

            if(isset($payment) && isset($payment->id))
            {
                $paymentData = [
                    'payment_id'    => (int) $payment->id,
                    'per_hour'      => (float) $payment->per_hour,
                    'total_hour'    => (float) $payment->total_hour,
                    'sub_total'     => (float) $payment->sub_total,
                    'tax'           => (float) $payment->tax,
                    'other_charges' => (float) $payment->other_charges,
                    'parking_fees'  => (float) $payment->parking_fees,
                    'total'         => (float) $payment->total,
                    'tip'           => (float) $payment->tip,
                    'description'   => $payment->description,
                    'payment_status'=> (int) $this->nulltoBlank($payment->payment_status),
                    'payment_via'=> $this->nulltoBlank($payment->payment_via),
                    'payment_details'=> $this->nulltoBlank($payment->payment_details)
                ];
            }

            if(isset($baby) && isset($baby->id))
            {
                $babyData[] = [
                    'baby_id'       => (int) $baby->id,
                    "title"         =>  isset($baby->title) ? $baby->title : '',
                    "birthdate"     =>  isset($baby->birthdate) ? $baby->birthdate : '',
                    "age"           => (int) isset($baby->age) ? (int) $baby->age : 0,
                    "description"   =>  isset($baby->description) ? $baby->description : '', 
                    "image"         =>  URL::to('/').'/uploads/babies/'.$baby->image
                ];
            }
           

            if($item->is_multiple == 1 && isset($item->baby_ids))
            {
                $babyIds    = array_values(explode(',', $item->baby_ids));
                $babies     = Babies::whereIn('id', $babyIds)->get();

                if(isset($babies) && count($babies))
                {
                    foreach($babies as $baby)
                    {
                        $babyData[] = [
                            'baby_id'       => (int) $baby->id,
                            "title"         =>  isset($baby->title) ? $baby->title : '',
                            "birthdate"     =>  isset($baby->birthdate) ? $baby->birthdate : '',
                            "age"           => (int) isset($baby->age) ? (int) $baby->age : 0,
                            "description"   =>  isset($baby->description) ? $baby->description : '', 
                            "image"         =>  URL::to('/').'/uploads/babies/'.$baby->image
                        ];
                    }
                }
            }

            $response = [
                "booking_id"        => (int) $item->id,
                "user_id"           => (int) $item->user_id,
                "sitter_id"         => (int) $item->sitter_id,
                "user_name"         =>  $user->name,
                'sitter_name'       =>  $sitter->name,
                'sitter_contact'    =>  isset($sitter->mobile) ? $sitter->mobile : '',
                'sitter_rating'     =>  access()->getAverageRating($item->sitter_id),
                'profile_pic'       =>  URL::to('/').'/uploads/user/' . $sitter->profile_pic, 
                'user_profile_pic'  =>  URL::to('/').'/uploads/user/' . $user->profile_pic, 
                "baby_id"           =>  $item->baby_id, 
                "is_multiple"       =>  (int) isset($item->is_multiple) ? $item->is_multiple : 0,
                "booking_date"      =>  $item->booking_date, 
                "start_time"        =>  $item->start_time, 
                "end_time"          =>  $item->end_time, 
                "booking_startime"  =>  $this->nulltoBlank($item->booking_start_time), 
                "booking_endtime"   =>  $this->nulltoBlank($item->booking_end_time), 
                "booking_status"    =>  $item->booking_status, 
                'address'           => $this->nulltoBlank($user->address),
                'city'              => $this->nulltoBlank($user->city),
                'state'             => $this->nulltoBlank($user->state),
                'zip'               => $this->nulltoBlank($user->zip),
                "babies"            => [],
                "payment"           => $paymentData,
                'babies'            => $babyData,
                'payment_status'    => (int) isset($payment->payment_status) ? $this->nulltoBlank($payment->payment_status) : 0,
            ];

            reset($babyData);
        }

        return $response;
    }


    public function sitterEarningTransform($items)
    {
        $response = [];
        $output   = [];
        $total    = 0;
        $tipTotal = 0;
        $sr       = 0;
        foreach($items as $item)
        {
            $user           = (object) $item->user;
            $sitter         = (object) $item->sitter;
            $baby           = (object) $item->baby;
            $payment       = (object) $item->payment;
            $paymentData    = (object) [];
            $babyData       = [];

            if(isset($payment) && isset($payment->id))
            {
                $total      = $total + $payment->total;
                $tipTotal   = $tipTotal + $payment->tip;
                $paymentData = [
                    'payment_id'    => (int) $payment->id,
                    'per_hour'      => (float) $payment->per_hour,
                    'total_hour'    => (float) $payment->total_hour,
                    'sub_total'     => (float) $payment->sub_total,
                    'tax'           => (float) $payment->tax,
                    'other_charges' => (float) $payment->other_charges,
                    'parking_fees'  => (float) $payment->parking_fees,
                    'total'         => (float) $payment->total,
                    'tip'           => (float) $payment->tip,
                    'description'   => $payment->description,
                     'payment_status'=> (int) isset($payment->payment_status) ? $this->nulltoBlank($payment->payment_status) : 0,
                    'payment_via'=> $this->nulltoBlank($payment->payment_via),
                    'payment_details'=> $this->nulltoBlank($payment->payment_details)
                ];
            }

            if(isset($baby) && isset($baby->id))
            {
                $babyData[] = [
                    'baby_id'       => (int) $baby->id,
                    "title"         =>  isset($baby->title) ? $baby->title : '',
                    "birthdate"     =>  isset($baby->birthdate) ? $baby->birthdate : '',
                    "age"           => (int) isset($baby->age) ? (int) $baby->age : 0,
                    "description"   =>  isset($baby->description) ? $baby->description : '', 
                    "image"         =>  URL::to('/').'/uploads/babies/'.$baby->image
                ];
            }
            
            if($item->is_multiple == 1 && isset($item->baby_ids))
            {
                $babyIds    = array_values(explode(',', $item->baby_ids));
                $babies     = Babies::whereIn('id', $babyIds)->get();

                if(isset($babies) && count($babies))
                {
                    foreach($babies as $baby)
                    {
                        $babyData[] = [
                            'baby_id'       => (int) $baby->id,
                            "title"         =>  isset($baby->title) ? $baby->title : '',
                            "birthdate"     =>  isset($baby->birthdate) ? $baby->birthdate : '',
                            "age"           => (int) isset($baby->age) ? (int) $baby->age : 0,
                            "description"   =>  isset($baby->description) ? $baby->description : '', 
                            "image"         =>  URL::to('/').'/uploads/babies/'.$baby->image
                        ];
                    }
                }
            }

            $response[$sr] = [
                "booking_id"        => (int) $item->id,
                "user_id"           => (int) $item->user_id,
                "sitter_id"         => (int) $item->sitter_id,
                "user_name"         =>  $user->name,
                'sitter_name'       =>  $sitter->name,
                'sitter_contact'    =>  isset($sitter->mobile) ? $sitter->mobile : '',
                'sitter_rating'     =>  access()->getAverageRating($item->sitter_id),
                'profile_pic'       =>  URL::to('/').'/uploads/user/' . $sitter->profile_pic, 
                'user_profile_pic'  =>  URL::to('/').'/uploads/user/' . $user->profile_pic, 
                "baby_id"           =>  $item->baby_id, 
                "is_multiple"       =>  (int) isset($item->is_multiple) ? $item->is_multiple : 0,
                "booking_date"      =>  $item->booking_date, 
                "start_time"        =>  $item->start_time, 
                "end_time"          =>  $item->end_time, 
                "booking_startime"  =>  $this->nulltoBlank($item->booking_start_time), 
                "booking_endtime"   =>  $this->nulltoBlank($item->booking_end_time), 
                "booking_status"    =>  $item->booking_status, 
                'address'           => $this->nulltoBlank($user->address),
                'city'              => $this->nulltoBlank($user->city),
                'state'             => $this->nulltoBlank($user->state),
                'zip'               => $this->nulltoBlank($user->zip),
                "babies"            => [],
                "payment"           => $paymentData,
                'babies'            => $babyData,
                'payment_status'    => (int) isset($payment->payment_status) ? $this->nulltoBlank($payment->payment_status) : 0,
            ];

            $sr++;
        }

        $output = [
            'total_tips'    => (float) $tipTotal,
            'total_earning' => (float) $total,
            'bookings'      => $response
        ];
            
        return $output;
    }
}