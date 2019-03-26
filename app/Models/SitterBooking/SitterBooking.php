<?php namespace App\Models\SitterBooking;

/**
 * Class SitterBooking
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\SitterBooking\Traits\Attribute\Attribute;
use App\Models\SitterBooking\Traits\Relationship\Relationship;

class SitterBooking extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_sitter_details";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "user_id", "vacation_mode", "hourly_rate", "age_start_range", "age_end_range", "category", "about_me", "description", "stripe_id", "stripe_details", "account_holder_name", "account_number", "aba_number", "bank_name", "bank_address", "sitter_start_time", "sitter_end_time", "created_at", "updated_at", 
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