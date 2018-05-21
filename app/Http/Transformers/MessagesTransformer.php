<?php
namespace App\Http\Transformers;

use App\Http\Transformers;
use URL;

class MessagesTransformer extends Transformer
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

        $item->from_user    = (object) $item->from_user;
        $item->to_user      = (object) $item->to_user;

        return [    
            "message_id"        => (int) $item->id, 
            "from_user_id"      =>  $item->from_user_id, 
            "from_user_name"    =>  $item->from_user->name, 
            "to_user_id"        =>  $item->to_user_id, 
            "to_user_name"      =>  $item->to_user->name, 
            "image"             =>  isset($item->image) ? URL::to('/').'/uploads/messages/'.$item->image : '', 
            "message"           =>  isset($item->message) ? $item->message : '',
            "is_image"          => (int) $item->is_image, 
            "is_read"           => (int) $item->is_read, 
            "message_time"      => date('d-m-Y H:i a', strtotime($item->created_at))
        ];
    }
}