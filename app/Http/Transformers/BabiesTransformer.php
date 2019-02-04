<?php
namespace App\Http\Transformers;

use App\Http\Transformers;
use URL;

class BabiesTransformer extends Transformer
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

        return [
            "baby_id"       =>  (int) $item->id,
            "parent_id"     =>  (int) $item->parent_id,
            "title"         =>  isset($item->title) ? $item->title : '',
            "gender"        =>  isset($item->gender) ? $item->gender : '',
            "birthdate"     =>  isset($item->birthdate) ? $item->birthdate : '',
            "age"           =>  isset($item->age) ? (int) $item->age : 0,
            "description"   =>  isset($item->description) ? $item->description : '', 
            "baby_count"    => isset($item->user->babies) ? count($item->user->babies) : 0,
            "image"         =>  URL::to('/').'/uploads/babies/'.$item->image
        ];
    }
}