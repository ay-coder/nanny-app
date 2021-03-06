<?php namespace App\Repositories\Notifications;

/**
 * Class EloquentNotificationsRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\Notifications\Notifications;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;

class EloquentNotificationsRepository extends DbRepository
{
    /**
     * Notifications Model
     *
     * @var Object
     */
    public $model;

    /**
     * Notifications Title
     *
     * @var string
     */
    public $moduleTitle = 'Notifications';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'        => 'Id',
'user_id'        => 'User_id',
'sitter_id'        => 'Sitter_id',
'icon'        => 'Icon',
'description'        => 'Description',
'status'        => 'Status',
'is_read'        => 'Is_read',
'read_time'        => 'Read_time',
'created_at'        => 'Created_at',
'updated_at'        => 'Updated_at',
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
		'user_id' =>   [
                'data'          => 'user_id',
                'name'          => 'user_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'sitter_id' =>   [
                'data'          => 'sitter_id',
                'name'          => 'sitter_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'icon' =>   [
                'data'          => 'icon',
                'name'          => 'icon',
                'searchable'    => true,
                'sortable'      => true
            ],
		'description' =>   [
                'data'          => 'description',
                'name'          => 'description',
                'searchable'    => true,
                'sortable'      => true
            ],
		'status' =>   [
                'data'          => 'status',
                'name'          => 'status',
                'searchable'    => true,
                'sortable'      => true
            ],
		'is_read' =>   [
                'data'          => 'is_read',
                'name'          => 'is_read',
                'searchable'    => true,
                'sortable'      => true
            ],
		'read_time' =>   [
                'data'          => 'read_time',
                'name'          => 'read_time',
                'searchable'    => true,
                'sortable'      => true
            ],
		'created_at' =>   [
                'data'          => 'created_at',
                'name'          => 'created_at',
                'searchable'    => true,
                'sortable'      => true
            ],
		'updated_at' =>   [
                'data'          => 'updated_at',
                'name'          => 'updated_at',
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
        'listRoute'     => 'notifications.index',
        'createRoute'   => 'notifications.create',
        'storeRoute'    => 'notifications.store',
        'editRoute'     => 'notifications.edit',
        'updateRoute'   => 'notifications.update',
        'deleteRoute'   => 'notifications.destroy',
        'dataRoute'     => 'notifications.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'notifications.index',
        'createView'    => 'notifications.create',
        'editView'      => 'notifications.edit',
        'deleteView'    => 'notifications.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model = new Notifications;
    }

    /**
     * Create Notifications
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
     * Update Notifications
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
     * Destroy Notifications
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
     * @param string $userId
     * @param string $orderBy
     * @param string $sort
     * @return mixed
     */
    public function getAll($userId = null, $orderBy = 'id', $sort = 'asc')
    {
        return $this->model->with(['user', 'sitter', 'booking', 'booking.payment'])
            ->where('to_user_id' ,$userId)
            ->orderBy($orderBy, $sort)->get();
    }

    /**
     * Get All
     *
     * @param string $userId
     * @param string $orderBy
     * @param string $sort
     * @return mixed
     */
    public function getAllSitter($userId = null, $orderBy = 'id', $sort = 'asc')
    {
        return $this->model->with(['user', 'sitter', 'booking', 'booking.payment'])
        ->where('to_user_id' ,$userId)
        ->orderBy($orderBy, $sort)->get();
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
            $this->model->getTable().'.*'
        ];
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->model->select($this->getTableFields())->get();
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

    /**
     * Mark Read All
     *
     * @param int $userId
     * @return bool
     */
    public function markReadAll($userId = null)
    {
        if($userId)
        {
            return $this->model->where('user_id', $userId)->update([
                'is_read'   => 1,
                'read_time' => date('Y-m-d H:i:s')
                ]);
        }

        return false;
    }
}