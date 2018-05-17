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
            "reviewsId" => (int) $item->id, "reviewsUserId" =>  $item->user_id, "reviewsSitterId" =>  $item->sitter_id, "reviewsRating" =>  $item->rating, "reviewsDescription" =>  $item->description, "reviewsCreatedAt" =>  $item->created_at, "reviewsUpdatedAt" =>  $item->updated_at, 
        ];
    }
}