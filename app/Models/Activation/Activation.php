<?php namespace App\Models\Activation;

/**
 * Class Activation
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Activation\Traits\Attribute\Attribute;
use App\Models\Activation\Traits\Relationship\Relationship;

class Activation extends BaseModel
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
        "id", "user_id",
        'payment_status',
        'payment_via',
        'payment_details',
        "plan_id", "allowed_bookings", "status", "activated_at", "created_at", "updated_at", 
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