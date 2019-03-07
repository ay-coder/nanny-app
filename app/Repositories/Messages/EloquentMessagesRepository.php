<?php namespace App\Repositories\Messages;

/**
 * Class EloquentMessagesRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\Messages\Messages;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;
use App\Models\Access\User\User;

class EloquentMessagesRepository extends DbRepository
{
    /**
     * Messages Model
     *
     * @var Object
     */
    public $model;

    /**
     * Messages Title
     *
     * @var string
     */
    public $moduleTitle = 'Messages';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'                => 'Id',
        'from_user_id'      => 'From',
        'to_user_id'        => 'To',
        'image'             => 'Image',
        'message'           => 'Message',
        'created_at'        => 'Created_at',
        "actions"         => "Actions"
    ];

    /**
     * Table Columns
     *
     * @var array
     */
    public $tableColumns = [
        'id' =>   [
                'data'          => 'id',
                'name'          => 'id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'from_user_id' =>   [
                'data'          => 'from_user_id',
                'name'          => 'from_user_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'to_user_id' =>   [
                'data'          => 'to_user_id',
                'name'          => 'to_user_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'image' =>   [
                'data'          => 'image',
                'name'          => 'image',
                'searchable'    => true,
                'sortable'      => true
            ],
		'message' =>   [
                'data'          => 'message',
                'name'          => 'message',
                'searchable'    => true,
                'sortable'      => true
            ],
		'created_at' =>   [
                'data'          => 'created_at',
                'name'          => 'created_at',
                'searchable'    => true,
                'sortable'      => true
            ],
		'actions' => [
            'data'          => 'actions',
            'name'          => 'actions',
            'searchable'    => false,
            'sortable'      => false
        ]
    ];

    /**
     * Is Admin
     *
     * @var boolean
     */
    protected $isAdmin = false;

    /**
     * Admin Route Prefix
     *
     * @var string
     */
    public $adminRoutePrefix = 'admin';

    /**
     * Client Route Prefix
     *
     * @var string
     */
    public $clientRoutePrefix = 'frontend';

    /**
     * Admin View Prefix
     *
     * @var string
     */
    public $adminViewPrefix = 'backend';

    /**
     * Client View Prefix
     *
     * @var string
     */
    public $clientViewPrefix = 'frontend';

    /**
     * Module Routes
     *
     * @var array
     */
    public $moduleRoutes = [
        'listRoute'     => 'messages.index',
        'createRoute'   => 'messages.create',
        'storeRoute'    => 'messages.store',
        'editRoute'     => 'messages.edit',
        'updateRoute'   => 'messages.update',
        'deleteRoute'   => 'messages.destroy',
        'dataRoute'     => 'messages.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'messages.index',
        'createView'    => 'messages.create',
        'editView'      => 'messages.edit',
        'deleteView'    => 'messages.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model        = new Messages;
        $this->userModel    = new User;
    }

    /**
     * Create Messages
     *
     * @param array $input
     * @return mixed
     */
    public function create($input)
    {
        $input = $this->prepareInputData($input, true);
        $model = $this->model->create($input);

        if($model)
        {
            return $model;
        }

        return false;
    }

    /**
     * Update Messages
     *
     * @param int $id
     * @param array $input
     * @return bool|int|mixed
     */
    public function update($id, $input)
    {
        $model = $this->model->find($id);

        if($model)
        {
            $input = $this->prepareInputData($input);

            return $model->update($input);
        }

        return false;
    }

    /**
     * Destroy Messages
     *
     * @param int $id
     * @return mixed
     * @throws GeneralException
     */
    public function destroy($id)
    {
        $model = $this->model->find($id);

        if($model)
        {
            return $model->delete();
        }

        return  false;
    }

    /**
     * Get All
     *
     * @param string $orderBy
     * @param string $sort
     * @return mixed
     */
    public function getAll($orderBy = 'id', $sort = 'asc', $userId = null)
    {
        if($userId)
        {
            return $this->model->with(['from_user', 'to_user'])->where('from_user_id', $userId)->orWhere('to_user_id', $userId)->with(['from_user', 'to_user'])->orderBy($orderBy, $sort)->get();    
        }
        return $this->model->with(['from_user', 'to_user'])->orderBy($orderBy, $sort)->get();
    }

    /**
     * Get All User Messages
     * 
     * @var int
     */
    public function getAllUserMessages($userId = null)
    {
        if($userId)
        {
            $messages = $this->model
            ->with([
                'from_user',
                'to_user',
                'booking'
            ])
            ->where('from_user_id', '!=', 1)
            ->where('to_user_id', '!=', 1)
            ->where(function($q) use($userId)
            {
                $q->where('from_user_id', $userId)
                ->orWhere('to_user_id', $userId);
            })
            ->orderBy('id', 'desc')
            ->get();

            $response   = [];
            $userIds    = [];
            $inPair     = [];
            $outPair    = [];
            $messageIds = [];

            foreach($messages as $message)
            {
                $checkInPair = $message->from_user_id . ','. $message->to_user_id;
                $checkOutPair = $message->to_user_id . ','. $message->from_user_id;

                if(!in_array($checkInPair, $inPair) && !in_array($checkOutPair, $outPair) && !in_array($checkOutPair, $inPair) && !in_array($checkInPair, $outPair) )
                {
                    $messageIds[]   = $message->id;
                    $response[]     = $message;
                    $inPair[]       = $checkInPair;
                    $outPair[]      = $checkOutPair;
                }
            }
            
            return $response;
        }
        
        return false;
    }

    /**
     * Get All
     *
     * @param string $orderBy
     * @param string $sort
     * @return mixed
     */
    public function getAllChat($userId = null, $otherUserId = null, $bookingId = null)
    {
        if($userId && $otherUserId)
        {
            $condition = [
                'booking_id' => $bookingId
            ];
            
            return $this->model->with([
                'from_user',
                'to_user',
                'booking'
            ])
            ->where($condition)
            ->get();

            /*return $this->model->where([
                'from_user_id'      => $userId,
                'to_user_id'        => $otherUserId
            ])->orWhere([
                'to_user_id'        => $userId,
                'from_user_id'      => $otherUserId
            ])
            ->with([
                'from_user',
                'to_user',
                'booking'
            ])
            ->get();*/
        }

        return false;
    }

    /**
     * Get by Id
     *
     * @param int $id
     * @return mixed
     */
    public function getById($id = null)
    {
        if($id)
        {
            return $this->model->find($id);
        }

        return false;
    }

    /**
     * Get Table Fields
     *
     * @return array
     */
    public function getTableFields()
    {
        return [
            $this->model->getTable().'.*',
            $this->userModel->getTable().'.name as username'
        ];
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->model->orderBy('id', 'desc')->get();
        $collection = $this->model
            ->leftjoin($this->userModel->getTable(), $this->userModel->getTable().'.id', '=', $this->model->getTable().'.from_user_id')
            ->leftjoin($this->userModel->getTable(), $this->userModel->getTable().'.id', '=', $this->model->getTable().'.to_user_id')
            ->orderBy('id', 'desc')->get();
        $output     = [];
        $fromId     = [];

        foreach($collection as $message)
        {
            $checkUserId = $message->from_user_id == 1 ? $message->to_user_id : $message->from_user_id ;
            
            if(! in_array($checkUserId, $fromId) && !in_array($checkUserId, $fromId))
            {
                $output[] = $message;
                $fromId[] = $message->from_user_id;
                $fromId[] = $message->to_user_id;
            }
            
        }

        return collect($output);
    }

    /**
     * Set Admin
     *
     * @param boolean $isAdmin [description]
     */
    public function setAdmin($isAdmin = false)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Prepare Input Data
     *
     * @param array $input
     * @param bool $isCreate
     * @return array
     */
    public function prepareInputData($input = array(), $isCreate = false)
    {
        if($isCreate)
        {
            $input = array_merge($input, ['user_id' => access()->user()->id]);
        }

        return $input;
    }

    /**
     * Get Table Headers
     *
     * @return string
     */
    public function getTableHeaders()
    {
        if($this->isAdmin)
        {
            return json_encode($this->setTableStructure($this->tableHeaders));
        }

        $clientHeaders = $this->tableHeaders;

        unset($clientHeaders['username']);

        return json_encode($this->setTableStructure($clientHeaders));
    }

    /**
     * Get Table Columns
     *
     * @return string
     */
    public function getTableColumns()
    {
        if($this->isAdmin)
        {
            return json_encode($this->setTableStructure($this->tableColumns));
        }

        $clientColumns = $this->tableColumns;

        unset($clientColumns['username']);

        return json_encode($this->setTableStructure($clientColumns));
    }
}