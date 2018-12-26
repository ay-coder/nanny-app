<?php namespace App\Models\Booking;

/**
 * Class Booking
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Booking\Traits\Attribute\Attribute;
use App\Models\Booking\Traits\Relationship\Relationship;

class Booking extends BaseModel
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
        "id", "user_id", "is_pet", "pet_description", "cancel_by_parent", "cancel_by_sitter", "sitter_id", "baby_id", "baby_ids", "is_multiple", "parking_fees", "booking_date", "start_time", "end_time", "booking_start_time", "booking_end_time", "booking_status", "status", "created_at", "updated_at",
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