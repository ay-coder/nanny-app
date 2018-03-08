<?php  namespace App\Models;

/**
 * Class UpdateLogger
 *
 * @author Justin Bevan justin@smokerschoiceusa.com
 */

use DB, Sentry, DateTime, DateTimeZone;
use App\Models\Access\User\User;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class UpdateLogger extends BaseModel
{
    /**
     * Accounts
     *
     * @var array
     */
    protected $table = "application_logs";

    /**
     * Timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Additional Time Conversions
     *
     * @var array
     */
    public $additionalTimeConversions = [
        'action_time'
    ];

	/**
	 * Dates
	 *
	 * @var array
	 */
	protected $dates = ['action_time'];

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        "user_id",
        "section",
        "action",
        "item",
        "action_time"
    ];

    /**
     * Relationship Mapping for User
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        $attributes['action_time'] = new DateTime;
        return parent::query()->create($attributes);
    }

    /**
     * Get Action Time
     *
     * @param bool $model
     * @return string
     */
    public function getActionTime($model = false)
    {
        $model = ($model ? $model : $this);

        $time = new DateTime('now', new DateTimeZone('America/New_York'));

        $time->setTimestamp(strtotime($model->action_time));

        return $time->format('M j, Y, g:i a');
    }

    /**
     * Get Action Logs
     *
     * @param $model
     * @param mixed $item
     * @param int $limit
     * @return mixed
     */
    public function getActionLogs($model = false, $item = false, $limit = 10)
    {
        if(!$model || !isset($model->id))
        {
            return [];
        }

        $modelClass = (new \ReflectionClass($model))->getShortName();

            $actions = parent::where('item', '=', $model->getOriginal('id'))
                ->where('section', '=', $modelClass)
                ->orderBy('action_time', 'desc');

        if($item)
        {
            $actions->where('item', '=', $item);
        }

        return $actions->take($limit)->get();
    }
}