<?php namespace App\Models\Subscription;

/**
 * Class Subscription
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Subscription\Traits\Attribute\Attribute;
use App\Models\Subscription\Traits\Relationship\Relationship;

class Subscription extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_user_active_plans";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "user_id", "plan_id", "allowed_bookings", "status", "activated_at", "created_at", "updated_at", "payment_status", "payment_via", "payment_details", 
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