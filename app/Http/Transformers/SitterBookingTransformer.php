<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class SitterBookingTransformer extends Transformer
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
            "sitterbookingId" => (int) $item->id, "sitterbookingUserId" =>  $item->user_id, "sitterbookingVacationMode" =>  $item->vacation_mode, "sitterbookingHourlyRate" =>  $item->hourly_rate, "sitterbookingAgeStartRange" =>  $item->age_start_range, "sitterbookingAgeEndRange" =>  $item->age_end_range, "sitterbookingCategory" =>  $item->category, "sitterbookingAboutMe" =>  $item->about_me, "sitterbookingDescription" =>  $item->description, "sitterbookingStripeId" =>  $item->stripe_id, "sitterbookingStripeDetails" =>  $item->stripe_details, "sitterbookingAccountHolderName" =>  $item->account_holder_name, "sitterbookingAccountNumber" =>  $item->account_number, "sitterbookingAbaNumber" =>  $item->aba_number, "sitterbookingBankName" =>  $item->bank_name, "sitterbookingBankAddress" =>  $item->bank_address, "sitterbookingSitterStartTime" =>  $item->sitter_start_time, "sitterbookingSitterEndTime" =>  $item->sitter_end_time, "sitterbookingCreatedAt" =>  $item->created_at, "sitterbookingUpdatedAt" =>  $item->updated_at, 
        ];
    }
}