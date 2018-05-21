<?php namespace App\Models\Requests;

/**
 * Class Requests
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Requests\Traits\Attribute\Attribute;
use App\Models\Requests\Traits\Relationship\Relationship;

class Requests extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_user_requests";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "user_id", "user_request_status", "user_request", "status", "created_at", "updated_at", 
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