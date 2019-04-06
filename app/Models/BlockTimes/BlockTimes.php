<?php namespace App\Models\BlockTimes;

/**
 * Class BlockTimes
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\BlockTimes\Traits\Attribute\Attribute;
use App\Models\BlockTimes\Traits\Relationship\Relationship;

class BlockTimes extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_sitter_block_times";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "sitter_id", "day_name", "start_time", "end_time", "created_by", "created_at", "updated_at", 
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