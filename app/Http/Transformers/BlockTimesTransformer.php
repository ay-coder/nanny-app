<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class BlockTimesTransformer extends Transformer
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
            "blocktimesId" => (int) $item->id, "blocktimesSitterId" =>  $item->sitter_id, "blocktimesDayName" =>  $item->day_name, "blocktimesStartTime" =>  $item->start_time, "blocktimesEndTime" =>  $item->end_time, "blocktimesCreatedBy" =>  $item->created_by, "blocktimesCreatedAt" =>  $item->created_at, "blocktimesUpdatedAt" =>  $item->updated_at, 
        ];
    }
}