<?php
namespace App\Http\Transformers;

use App\Http\Transformers;
use URL;

class NotificationsTransformer extends Transformer
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

        $item->user     = (object)$item->user;
        $item->sitter   = (object)$item->sitter;
        $item->booking  = (object)$item->booking;
        $bookingInfo    = (object) [];


        if(isset($item->booking) && isset($item->booking->id))
        {
            $bookingInfo = [
                "booking_id"        => (int) $item->booking->id,
                "user_id"           => (int) $item->booking->user_id,
                "sitter_id"         => (int) $item->booking->sitter_id,
                "booking_status"    =>  $item->booking->booking_status, 
                'payment_status'    => (int) access()->getPaymentStatus($item->booking->id)
            ];
        }

        return [
            "notification_id"       => (int) $item->id,
            "user_id"               =>  $item->user_id, 
            "user_name"             =>  $item->user->name,
            "sitter_id"             =>  $item->sitter_id, 
            "sitter_name"           =>  isset($item->sitter) && isset($item->sitter->name) ? $item->sitter->name : '',
            "icon"                  =>  URL::to('/').'/uploads/notifications/' .$item->icon, 
            "ntype"                 =>  $this->nulltoBlank($item->ntype),
            "description"           =>  $this->nulltoBlank($item->description),
            "is_read"               =>  $item->is_read,
            "read_time"             =>  $this->nulltoBlank($item->read_time),
            "created_at"            =>  date('m-d-Y H:i A', strtotime($item->created_at)),
            "booking_info"          => $bookingInfo
        ];
    }
}