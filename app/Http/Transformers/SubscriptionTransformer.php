<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class SubscriptionTransformer extends Transformer
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
            "subscriptionId" => (int) $item->id, "subscriptionUserId" =>  $item->user_id, "subscriptionPlanId" =>  $item->plan_id, "subscriptionAllowedBookings" =>  $item->allowed_bookings, "subscriptionStatus" =>  $item->status, "subscriptionActivatedAt" =>  $item->activated_at, "subscriptionCreatedAt" =>  $item->created_at, "subscriptionUpdatedAt" =>  $item->updated_at, "subscriptionPaymentStatus" =>  $item->payment_status, "subscriptionPaymentVia" =>  $item->payment_via, "subscriptionPaymentDetails" =>  $item->payment_details, 
        ];
    }
}