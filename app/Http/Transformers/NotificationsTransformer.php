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

        return [
            "notification_id"       => (int) $item->id,
            "user_id"               =>  $item->user_id, 
            "user_name"             =>  $item->user->name,
            "sitter_id"             =>  $item->sitter_id, 
            "sitter_name"           =>  $item->sitter->name,
            "icon"                  =>  URL::to('/').'/uploads/notifications/' .$item->icon, 
            "description"           =>  $this->nulltoBlank($item->description),
            "is_read"               =>  $item->is_read,
            "read_time"             =>  $this->nulltoBlank($item->read_time),
            "created_at"            =>  date('m-d-Y H:i A', strtotime($item->created_at))
        ];
    }
}