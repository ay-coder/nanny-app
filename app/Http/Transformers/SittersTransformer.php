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
            "sitter_id"             => (int) $item->id, 
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
            $user   = (object) $item->user;
            $sitter = (object) $item->sitter;
            $baby   = (object) $item->baby;

            $response[$sr] = [
                "booking_id"        => (int) $item->id,
                "user_id"           => (int) $item->user_id,
                "sitter_id"         => (int) $item->sitter_id,
                'sitter_name'       =>  $sitter->name,
                'sitter_contact'    =>  isset($sitter->mobile) ? $sitter->mobile : '',
                'sitter_rating'     =>  access()->getAverageRating($item->sitter_id),
                'profile_pic'       =>  URL::to('/').'/uploads/user/' . $sitter->profile_pic, 
                "baby_id"           =>  $item->baby_id, 
                "is_multiple"       =>  (int) isset($item->is_multiple) ? $item->is_multiple : 0,
                "booking_date"      =>  $item->booking_date, 
                "start_time"        =>  $item->start_time, 
                "end_time"          =>  $item->end_time, 
                "booking_startime"  =>  $item->booking_start_time, 
                "booking_endtime"   =>  $item->booking_end_time, 
                "booking_status"    =>  $item->booking_status, 
                "babies"            => []
            ];

            $babyData[$sr] = [
                'baby_id'       => (int) $baby->id,
                "title"         =>  isset($baby->title) ? $baby->title : '',
                "birthdate"     =>  isset($baby->birthdate) ? $baby->birthdate : '',
                "age"           => (int) isset($baby->age) ? (int) $baby->age : 0,
                "description"   =>  isset($baby->description) ? $baby->description : '', 
                "image"         =>  URL::to('/').'/uploads/babies/'.$baby->image
            ];

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

            $response[$sr]['babies'] = $babyData;
            $sr++;
        }

        return $response;
    }

}