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

    public function myActivationTransform($items = null)
    {
        $output     = [];
        $totalBooking = 0;

        if(isset($items) && count($items))
        {
            foreach($items as $item)
            {
                $totalBooking   = $totalBooking + $item->allowed_bookings;
                $output[]       = [
                    'allowed_bookings'  => (int) $item->allowed_bookings,
                    'plan_id'           => (int) $item->plan_id,
                    'plan_title'        => isset($item->plan) ? $item->plan->title : '',
                    'payment_via'       => isset($item->payment_via) ? $item->payment_via : ''
                ];
            }
        }

        $response = [
            'total_allowed_bookings'    => $totalBooking,
            'activation'                => $output,
        ];

        return $response;
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