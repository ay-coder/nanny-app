<?php namespace App\Models\Payment;

/**
 * Class Payment
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Payment\Traits\Attribute\Attribute;
use App\Models\Payment\Traits\Relationship\Relationship;

class Payment extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_payments";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "booking_id", "sitter_id", "per_hour", "total_hour", "sub_total", "tax", "other_charges", "parking_fees", "total", "description", "payment_status", "payment_via", "payment_details", "status", "created_at", "updated_at", 
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