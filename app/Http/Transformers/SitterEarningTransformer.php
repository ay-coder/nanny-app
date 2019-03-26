<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class SitterEarningTransformer extends Transformer
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
            "sitterearningId" => (int) $item->id, "sitterearningUserId" =>  $item->user_id, "sitterearningSitterId" =>  $item->sitter_id, "sitterearningCancelByParent" =>  $item->cancel_by_parent, "sitterearningCancelBySitter" =>  $item->cancel_by_sitter, "sitterearningBabyId" =>  $item->baby_id, "sitterearningBabyIds" =>  $item->baby_ids, "sitterearningIsMultiple" =>  $item->is_multiple, "sitterearningBookingType" =>  $item->booking_type, "sitterearningIsPet" =>  $item->is_pet, "sitterearningPetDescription" =>  $item->pet_description, "sitterearningParkingFees" =>  $item->parking_fees, "sitterearningBookingDate" =>  $item->booking_date, "sitterearningStartTime" =>  $item->start_time, "sitterearningEndTime" =>  $item->end_time, "sitterearningBookingStartTime" =>  $item->booking_start_time, "sitterearningBookingEndTime" =>  $item->booking_end_time, "sitterearningBookingStatus" =>  $item->booking_status, "sitterearningStatus" =>  $item->status, "sitterearningCreatedAt" =>  $item->created_at, "sitterearningUpdatedAt" =>  $item->updated_at, 
        ];
    }
}