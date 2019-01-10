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
            'is_sender'         => ($item->from_user_id == 1 ) ? 0 : 1,
            "message_time"      => date('d-m-Y H:i A', strtotime($item->created_at))
        ];
    }

    /**
     * My Message Transform
     *
     * @param object $items
     * @return array
     */
    public function myMessageTransform($items)
    {
        $response = [];

        if(isset($items) && count($items))
        {
            foreach($items as $item)
            {
                $item->from_user    = (object) $item->from_user;
                $item->to_user      = (object) $item->to_user;

                $lastBooking        = access()->getLastBooking($item->from_user_id, $item->to_user_id);

                if(!$lastBooking)
                {
                    $lastBooking = [];
                }
                else
                {
                    $lastBooking  = [
                        'last_booking_id'   => (int) $lastBooking->id,
                        'parent_id'         => (int) $lastBooking->user_id,
                        'sitter_id'         => (int) $lastBooking->sitter_id,
                        'booking_status'    => $lastBooking->booking_status,
                        'booking_end_time' => $lastBooking->booking_start_time,
                        'booking_start_time' => $lastBooking->booking_end_time
                    ];
                }

                $response[] = [    
                    "message_id"        => (int) $item->id, 
                    "from_user_id"      =>  $item->from_user_id, 
                    "from_user_name"    =>  $item->from_user->name, 
                    "to_user_id"        =>  $item->to_user_id, 
                    "to_user_name"      =>  $item->to_user->name, 
                    "image"             =>  isset($item->image) ? URL::to('/').'/uploads/messages/'.$item->image : '', 
                    "message"           =>  isset($item->message) ? $item->message : '',
                    "is_image"          => (int) $item->is_image, 
                    "is_read"           => (int) $item->is_read, 
                    "lastBooking"       => (object)$lastBooking,
                    'is_sender'         => ($item->from_user_id == access()->user()->id ) ? 1 : 0,
                    "message_time"      => date('d-m-Y H:i A', strtotime($item->created_at))
                ];
            }
        }
        
        return $response;
    }
}