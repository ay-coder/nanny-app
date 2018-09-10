<?php namespace App\Models\Reviews;

/**
 * Class Reviews
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Reviews\Traits\Attribute\Attribute;
use App\Models\Reviews\Traits\Relationship\Relationship;

class Reviews extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_sitter_reviews";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "user_id", "booking_id", "sitter_id", "rating", "description", "created_at", "updated_at",
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