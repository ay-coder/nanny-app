<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class ActivationTransformer extends Transformer
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
            "activationId" => (int) $item->id, "activationUserId" =>  $item->user_id, "activationPlanId" =>  $item->plan_id, "activationAllowedBookings" =>  $item->allowed_bookings, "activationStatus" =>  $item->status, "activationActivatedAt" =>  $item->activated_at, "activationCreatedAt" =>  $item->created_at, "activationUpdatedAt" =>  $item->updated_at, 
        ];
    }

    public function activateTransform($item)
    {
        if(isset($item))
        {
            $response = [
                'allowed_bookings'  => (int) $item->allowed_bookings,
                'plan_id'           => (int) $item->plan_id,
                'is_active'         => (int) 1,
            ];
        }

        return $response;
    }
}