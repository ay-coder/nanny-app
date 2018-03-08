<?php namespace App\Models\Sample;

/**
 * Class Sample
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Sample\Traits\Attribute\Attribute;
use App\Models\Sample\Traits\Relationship\Relationship;

class Sample extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_sample";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        'id',
    ];

    /**
     * Timestamp flag
     *
     */
    public $timestamps = false;

    /**
     * Guarded ID Column
     *
     */
    protected $guarded = ["id"];
}