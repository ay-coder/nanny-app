<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class ReviewsTransformer extends Transformer
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
            "review_id"         => (int) $item->id, 
            "user_id"           =>  $item->user_id, 
            "sitter_id"         =>  $item->sitter_id,
            "rating"            =>  $item->rating, 
            "description"       =>  $item->description
        ];
    }
}