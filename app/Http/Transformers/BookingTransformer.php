<?php
namespace App\Http\Transformers;

use App\Http\Transformers;
use App\Models\Babies\Babies;
use URL;

class BookingTransformer extends Transformer
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

        $user           = (object) $item->user;
        $sitter         = (object) $item->sitter;
        $baby           = (object) $item->baby;
        $payment        = (object) $item->payment;
        $paymentData    = (object) [];

        if(isset($payment) && isset($payment->id))
        {
            $paymentData = [
                'payment_id'    => (int) $payment->id,
                'per_hour'      => (float) $payment->per_hour,
                'total_hour'    => (float) $payment->total_hour,
                'sub_total'     => (float) $payment->sub_total,
                'tax'           => (float) $payment->tax,
                'other_charges' => (float) $payment->other_charges,
                'parking_fees'  => (float) $payment->parking_fees,
                'total'         => (float) $payment->total,
                'tip'           => (float) $payment->tip,
                'description'   => $payment->description,
                'payment_status'=> isset($payment->payment_status) ? $this->nulltoBlank($payment->payment_status) : 0,
                'payment_via'=> $this->nulltoBlank($payment->payment_via),
                'payment_details'=> $this->nulltoBlank($payment->payment_details)
            ];
        }

        $response = [
            "booking_id"        => (int) $item->id,
            "user_id"           => (int) $item->user_id,
            "sitter_id"         => (int) $item->sitter_id,
            'sitter_name'       =>  $sitter->name,
            'sitter_contact'    =>  isset($sitter->mobile) ? $sitter->mobile : '',
            'sitter_rating'     =>  access()->getAverageRating($item->sitter_id),
            'profile_pic'       =>  URL::to('/').'/uploads/user/' . $sitter->profile_pic, 
            "baby_id"           =>  $item->baby_id, 
            "is_multiple"       =>  (int) isset($item->is_multiple) ? $item->is_multiple : 0,
            "booking_date"      =>  $item->booking_date, 
            "start_time"        =>  $item->start_time, 
            "end_time"          =>  $item->end_time, 
            "booking_startime"  =>  $this->nulltoBlank($item->booking_start_time), 
            "booking_endtime"   =>  $this->nulltoBlank($item->booking_end_time), 
            "booking_status"    =>  $item->booking_status, 
            "babies"            => [],
            'payment_status'    => isset($payment->payment_status) ? $this->nulltoBlank($payment->payment_status) : 0,
            "payment"           => $paymentData
        ];

        $babyData[] = [
            'baby_id'       => (int) $baby->id,
            "title"         =>  isset($baby->title) ? $baby->title : '',
            "birthdate"     =>  isset($baby->birthdate) ? $baby->birthdate : '',
            "age"           => (int) isset($baby->age) ? (int) $baby->age : 0,
            "description"   =>  isset($baby->description) ? $baby->description : '', 
            "image"         =>  URL::to('/').'/uploads/babies/'.$baby->image
        ];

        if($item->is_multiple == 1 && isset($item->baby_ids))
        {
            $babyIds    = array_values(explode(',', $item->baby_ids));
            $babies     = Babies::whereIn('id', $babyIds)->get();

            if(isset($babies) && count($babies))
            {
                foreach($babies as $baby)
                {
                    $babyData[] = [
                        'baby_id'       => (int) $baby->id,
                        "title"         =>  isset($baby->title) ? $baby->title : '',
                        "birthdate"     =>  isset($baby->birthdate) ? $baby->birthdate : '',
                        "age"           => (int) isset($baby->age) ? (int) $baby->age : 0,
                        "description"   =>  isset($baby->description) ? $baby->description : '', 
                        "image"         =>  URL::to('/').'/uploads/babies/'.$baby->image
                    ];
                }
            }
        }

        $response['babies'] = $babyData;

        return $response;
    } 

    /**
     * Past Booking Transform
     *
     * @param array $data
     * @return array
     */
    public function pastBookingTransform($items)
    {
        $response   = [];
        $sr         = 0;

        foreach($items as $item)
        {
            $user           = (object) $item->user;
            $sitter         = (object) $item->sitter;
            $baby           = (object) $item->baby;
            $payment        = (object) $item->payment;
            $paymentData    = [];

            if(isset($payment) && isset($payment->id))
            {
                $paymentData = [
                    'payment_id'    => (int) $payment->id,
                    'per_hour'      => (float) $payment->per_hour,
                    'total_hour'    => (float) $payment->total_hour,
                    'sub_total'     => (float) $payment->sub_total,
                    'tax'           => (float) $payment->tax,
                    'other_charges' => (float) $payment->other_charges,
                    'parking_fees'  => (float) $payment->parking_fees,
                    'total'         => (float) $payment->total,
                    'tip'           => (float) $payment->tip,
                    'description'   => $payment->description,
                    'payment_status'=> isset($payment->payment_status) ? $this->nulltoBlank($payment->payment_status) : 0,
                    'payment_via'=> $this->nulltoBlank($payment->payment_via),
                    'payment_details'=> $this->nulltoBlank($payment->payment_details)
                ];
            }

            $response[$sr] = [
                "booking_id"        => (int) $item->id,
                "user_id"           => (int) $item->user_id,
                "sitter_id"         => (int) $item->sitter_id,
                'sitter_name'       =>  $sitter->name,
                'sitter_contact'    =>  isset($sitter->mobile) ? $sitter->mobile : '',
                'sitter_rating'     =>  access()->getAverageRating($item->sitter_id),
                'profile_pic'       =>  URL::to('/').'/uploads/user/' . $sitter->profile_pic, 
                "baby_id"           =>  $item->baby_id, 
                "is_multiple"       =>  (int) isset($item->is_multiple) ? $item->is_multiple : 0,
                "booking_date"      =>  $item->booking_date, 
                "start_time"        =>  $item->start_time, 
                "end_time"          =>  $item->end_time, 
                "booking_startime"  =>  $this->nulltoBlank($item->booking_start_time), 
                "booking_endtime"   =>  $this->nulltoBlank($item->booking_end_time), 
                "booking_status"    =>  $item->booking_status, 
                "babies"            => [],
                "payment"           => $paymentData,
                'payment_status'    => isset($payment->payment_status) ? $this->nulltoBlank($payment->payment_status) : 0,
            ];

            $babyData[] = [
                'baby_id'       => (int) $baby->id,
                "title"         =>  isset($baby->title) ? $baby->title : '',
                "birthdate"     =>  isset($baby->birthdate) ? $baby->birthdate : '',
                "age"           => (int) isset($baby->age) ? (int) $baby->age : 0,
                "description"   =>  isset($baby->description) ? $baby->description : '', 
                "image"         =>  URL::to('/').'/uploads/babies/'.$baby->image
            ];

            if($item->is_multiple == 1 && isset($item->baby_ids))
            {
                $babyIds    = array_values(explode(',', $item->baby_ids));
                $babies     = Babies::whereIn('id', $babyIds)->get();

                if(isset($babies) && count($babies))
                {
                    foreach($babies as $baby)
                    {
                        $babyData[] = [
                            'baby_id'       => (int) $baby->id,
                            "title"         =>  isset($baby->title) ? $baby->title : '',
                            "birthdate"     =>  isset($baby->birthdate) ? $baby->birthdate : '',
                            "age"           => (int) isset($baby->age) ? (int) $baby->age : 0,
                            "description"   =>  isset($baby->description) ? $baby->description : '', 
                            "image"         =>  URL::to('/').'/uploads/babies/'.$baby->image
                        ];
                    }
                }
            }

            $response[$sr]['babies'] = $babyData;
            $sr++;
        }
        return $response;
    }   
}