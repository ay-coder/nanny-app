<?php namespace App\Models\Parents;

/**
 * Class Parents
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Parents\Traits\Attribute\Attribute;
use App\Models\Parents\Traits\Relationship\Relationship;

class Parents extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "users";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "name", "email", "password", "status", "mobile", "confirmation_code", "confirmed", "remember_token", "profile_pic", "device_token", "device_type", "user_type", "gender", "birthdate", "data_babies", "address", "city", "state", "zip", "lat", "long", "social_provider", "social_token", "created_at", "updated_at", "deleted_at", 
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