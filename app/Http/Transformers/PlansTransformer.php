<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class PlansTransformer extends Transformer
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
            "plan_id"       => (int) $item->id,
            "title"         =>  $item->title, 
            "sub_title"     =>  $item->sub_title, 
            "amount"        =>  $item->amount,
            "description"   =>  $item->description,
            "plan_type"     =>  $item->plan_type
        ];
    }
}