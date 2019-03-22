<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class ParentsTransformer extends Transformer
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
            "parentsId" => (int) $item->id, "parentsName" =>  $item->name, "parentsEmail" =>  $item->email, "parentsPassword" =>  $item->password, "parentsStatus" =>  $item->status, "parentsMobile" =>  $item->mobile, "parentsConfirmationCode" =>  $item->confirmation_code, "parentsConfirmed" =>  $item->confirmed, "parentsRememberToken" =>  $item->remember_token, "parentsProfilePic" =>  $item->profile_pic, "parentsDeviceToken" =>  $item->device_token, "parentsDeviceType" =>  $item->device_type, "parentsUserType" =>  $item->user_type, "parentsGender" =>  $item->gender, "parentsBirthdate" =>  $item->birthdate, "parentsDataBabies" =>  $item->data_babies, "parentsAddress" =>  $item->address, "parentsCity" =>  $item->city, "parentsState" =>  $item->state, "parentsZip" =>  $item->zip, "parentsLat" =>  $item->lat, "parentsLong" =>  $item->long, "parentsSocialProvider" =>  $item->social_provider, "parentsSocialToken" =>  $item->social_token, "parentsCreatedAt" =>  $item->created_at, "parentsUpdatedAt" =>  $item->updated_at, "parentsDeletedAt" =>  $item->deleted_at, 
        ];
    }
}