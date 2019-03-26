<?php namespace App\Models\SitterEarning;

/**
 * Class SitterEarning
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\SitterEarning\Traits\Attribute\Attribute;
use App\Models\SitterEarning\Traits\Relationship\Relationship;

class SitterEarning extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_bookings";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "user_id", "sitter_id", "cancel_by_parent", "cancel_by_sitter", "baby_id", "baby_ids", "is_multiple", "booking_type", "is_pet", "pet_description", "parking_fees", "booking_date", "start_time", "end_time", "booking_start_time", "booking_end_time", "booking_status", "status", "created_at", "updated_at", 
    ];

    /**
     * Timestamp flag
     *
     */
    public $timestamps = true;

    /**
     * Guarded ID Column
     *
     */
    protected $guarded = ["id"];
}