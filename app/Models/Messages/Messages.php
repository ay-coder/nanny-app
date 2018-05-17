<?php namespace App\Models\Messages;

/**
 * Class Messages
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Messages\Traits\Attribute\Attribute;
use App\Models\Messages\Traits\Relationship\Relationship;

class Messages extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_messags";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "from_user_id", "to_user_id", "image", "message", "is_image", "is_read", "created_at", "updated_at", 
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