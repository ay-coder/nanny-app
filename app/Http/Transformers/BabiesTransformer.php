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
            "babiesId"          =>  (int) $item->id,
            "babiesParentId"    =>  (int) $item->parent_id,
            "babiesTitle"       =>  isset($item->title) ? $item->title : '',
            "babiesBirthdate"   =>  isset($item->birthdate) ? $item->birthdate : '',
            "babiesAge"         =>  isset($item->age) ? (int) $item->age : 0,
            "babiesDescription" =>  isset($item->description) ? $item->description : '', 
            "babiesImage"       =>  URL::to('/').'/uploads/babies/'.$item->image
        ];
    }
}