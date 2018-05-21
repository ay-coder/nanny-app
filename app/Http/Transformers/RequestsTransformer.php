<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class RequestsTransformer extends Transformer
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
            "request_id"        => (int) $item->id,
            "user_id"           =>  $item->user_id,
            "user_request"      =>  $item->user_request
        ];
    }
}