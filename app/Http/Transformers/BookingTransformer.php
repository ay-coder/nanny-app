<?php
namespace App\Http\Transformers;

use App\Http\Transformers;
use App\Models\Babies\Babies;
use URL;

class BookingTransformer extends Transformer
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

        $user   = (object) $item->user;
        $sitter = (object) $item->sitter;
        $baby   = (object) $item->baby;

        $response = [
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

        $babyData[] = [
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

        $response['babies'] = $babyData;

        return $response;
    }   
}