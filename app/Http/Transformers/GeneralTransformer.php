<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class GeneralTransformer extends Transformer
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
            "generalId" => (int) $item->id, "generalDataKey" =>  $item->data_key, "generalDataValue" =>  $item->data_value, "generalStatus" =>  $item->status, "generalCreatedAt" =>  $item->created_at, "generalUpdatedAt" =>  $item->updated_at, 
        ];
    }
}