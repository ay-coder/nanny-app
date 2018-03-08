<?php namespace App\Models\Event;

/**
 * Class Event
 *
 * @author Justin Bevan justin@smokerschoiceusa.com
 */

use App\Models\BaseModel;
use App\Models\Event\Traits\Attribute\Attribute;
use App\Models\Event\Traits\Relationship\Relationship;

class Event extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "events";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        'name',
        'user_id',
        'title',
        'creator_id',
        'start_date',
        'end_date'
    ];

    /**
     * Guarded ID Column
     *
     */
    protected $guarded = ["id"];
}