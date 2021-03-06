<?php namespace App\Models\Sitters;

/**
 * Class Sitters
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Sitters\Traits\Attribute\Attribute;
use App\Models\Sitters\Traits\Relationship\Relationship;

class Sitters extends BaseModel
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
        "id", "user_id", "vacation_mode", "category", "about_me", "description", 
        "sitter_start_time", "sitter_end_time",
        "created_at", "updated_at", 
        "hourly_rate", 
        "account_holder_name",
        "account_number",
        "aba_number",
        "bank_name",
        "bank_address",
        'stripe_id',
        'age_start_range',
        'age_end_range',

        'stripe_details'
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