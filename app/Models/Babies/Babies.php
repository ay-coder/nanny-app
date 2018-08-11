<?php namespace App\Models\Babies;

/**
 * Class Babies
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Babies\Traits\Attribute\Attribute;
use App\Models\Babies\Traits\Relationship\Relationship;
use Illuminate\Database\Eloquent\SoftDeletes;

class Babies extends BaseModel
{
    use Attribute, Relationship, SoftDeletes;

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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}