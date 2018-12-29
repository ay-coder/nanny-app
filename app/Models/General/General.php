<?php namespace App\Models\General;

/**
 * Class General
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\General\Traits\Attribute\Attribute;
use App\Models\General\Traits\Relationship\Relationship;

class General extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_configs";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "data_key", "data_value", "status", "created_at", "updated_at", 
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