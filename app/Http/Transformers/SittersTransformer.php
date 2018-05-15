<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

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

        return [
            "sittersId" => (int) $item->id, "sittersUserId" =>  $item->user_id, "sittersCategory" =>  $item->category, "sittersAboutMe" =>  $item->about_me, "sittersDescription" =>  $item->description, "sittersCreatedAt" =>  $item->created_at, "sittersUpdatedAt" =>  $item->updated_at, 
        ];
    }
}