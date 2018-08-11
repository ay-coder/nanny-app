<?php namespace App\Models\Plans;

/**
 * Class Plans
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Plans\Traits\Attribute\Attribute;
use App\Models\Plans\Traits\Relationship\Relationship;

class Plans extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_plans";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "title", "amount", "description", "sub_title", "plan_type", "status", "created_at", "updated_at",
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