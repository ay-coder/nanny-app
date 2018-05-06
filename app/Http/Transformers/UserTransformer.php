<?php

namespace App\Http\Transformers;

use App\Http\Transformers;
use URL;

class UserTransformer extends Transformer 
{
    public function transform($data) 
    {
        return [
            'userId'        => $data->id,
            'userToken'     => $data->token,
            'userType'      => isset($data->user_type) ? (int) $data->user_type : 0,
            'name'          => $this->nulltoBlank($data->name),
            'deviceToken'   => $this->nulltoBlank($data->device_token),
            'deviceType'    => isset($data->device_type) ? (int) $data->device_type : 0,
            'profilePic'    => URL::to('/').'/uploads/user/' . $data->profile_pic, 
            'address'       => $this->nulltoBlank($data->address),
            'city'          => $this->nulltoBlank($data->city),
            'state'         => $this->nulltoBlank($data->state),
            'zip'           => $this->nulltoBlank($data->zip),
            'gender'        => $this->nulltoBlank($data->gender),
            'birthday'      => $this->nulltoBlank($data->birthdate),
            'status'        => $data->status
          
        ];
    }
    
    public function getUserInfo($data) 
    {
        return [
            'userId'    => $data->id,
            'name'      => $this->nulltoBlank($data->name),
            'email'     => $this->nulltoBlank($data->email)
        ];
    }
    
    /**
     * userDetail
     * Single user detail
     * 
     * @param type $data
     * @return type
     */
    public function userDetail($data) {
        return [
            'UserId' => isset($data['id']) ? $data['id'] : "",
            'QuickBlocksId' => isset($data['quick_blocks_id']) ? $data['quick_blocks_id'] : "",
            'MobileNumber' => isset($data['mobile_number']) ? $data['mobile_number'] : "",
            'Name' => isset($data['username']) ? $data['username'] : "",
            'Specialty' => isset($data['specialty']) ? $data['specialty'] : "",
            'ProfilePhoto' => isset($data['profile_photo'])?$this->getUserImage($data['profile_photo']):""
        ];
    }

    /*
     * User Detail and it's parameters
     */
    public function singleUserDetail($data){        
        return [
            'UserId' => $data['id'],            
            'Name' => $this->nulltoBlank($data['name']),
            'Email' => $this->nulltoBlank($data['email']),
            'MobileNumber' => $this->nulltoBlank($data['mobile_number']),
        ];
    }
    
    public function transformStateCollection(array $items) {
        return array_map([$this, 'getState'], $items);
    }
}
