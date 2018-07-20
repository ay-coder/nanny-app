<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class PaymentTransformer extends Transformer
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
        ];
    }

    public function paymentInfo($item)
    {

    }
}