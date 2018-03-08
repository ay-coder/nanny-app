<?php

namespace App\Http\Transformers;

use App\Http\Transformers;

class EventTransformer extends Transformer 
{
    /**
     * Transform
     * 
     * @param array $data
     * @return array
     */
    public function transform($data) 
    {
        if(is_array($data))
        {
            $data = (object)$data;
        }
        
        return [
            'eventId'           => (int) $data->id,
            'eventName'         => $data->name,
            'eventTitle'        => $data->title,
            'eventStartDate'    => date('d-m-Y', strtotime($data->start_date)),
            'eventEndDate'      => date('d-m-Y', strtotime($data->end_date))
        ];
    }

    public function createEvent($model = null)
    {
        return [
            'eventId'           => (int) $model->id,
            'eventName'         => $model->name,
            'eventTitle'        => $model->title,
            'eventStartDate'    => date('d-m-Y', strtotime($model->start_date)),
            'eventEndDate'      => date('d-m-Y', strtotime($model->end_date))
        ];
    }
}
