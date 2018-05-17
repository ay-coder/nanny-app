<?php
namespace App\Http\Transformers;

use App\Http\Transformers;
use URL;

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
}