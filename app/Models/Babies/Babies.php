<?php namespace App\Models\Babies;

/**
 * Class Babies
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Babies\Traits\Attribute\Attribute;
use App\Models\Babies\Traits\Relationship\Relationship;

class Babies extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_babies";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "parent_id", "title", "birthdate", "age", "description", "image", "status", "created_at", "updated_at", 
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