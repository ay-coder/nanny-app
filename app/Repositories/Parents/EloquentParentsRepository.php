<?php namespace App\Repositories\Parents;

/**
 * Class EloquentParentsRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\Parents\Parents;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;
use App\Models\Babies\Babies;

class EloquentParentsRepository extends DbRepository
{
    /**
     * Parents Model
     *
     * @var Object
     */
    public $model;

    /**
     * Parents Title
     *
     * @var string
     */
    public $moduleTitle = 'Parents';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'            => 'Id',
        'name'          => 'Name',
        'email'         => 'Email',
        'mobile'        => 'Mobile',
        'gender'        => 'Gender',
        'baby_count'    => 'Baby Count',
        'birthdate'     => 'Birthdate',
        'address'       => 'Address',
        'city'          => 'City',
        'created_at'    => 'Created At',
        "actions"       => "Actions"
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
		'name' =>   [
                'data'          => 'name',
                'name'          => 'name',
                'searchable'    => true,
                'sortable'      => true
            ],
		'email' =>   [
                'data'          => 'email',
                'name'          => 'email',
                'searchable'    => true,
                'sortable'      => true
            ],
	    'mobile' =>   [
                'data'          => 'mobile',
                'name'          => 'mobile',
                'searchable'    => true,
                'sortable'      => true
            ],
		'gender' =>   [
                'data'          => 'gender',
                'name'          => 'gender',
                'searchable'    => true,
                'sortable'      => true
            ],
        'baby_count' =>   [
                'data'          => 'baby_count',
                'name'          => 'baby_count',
                'searchable'    => true,
                'sortable'      => true
            ],
		'birthdate' =>   [
                'data'          => 'birthdate',
                'name'          => 'birthdate',
                'searchable'    => true,
                'sortable'      => true
            ],
		'address' =>   [
                'data'          => 'address',
                'name'          => 'address',
                'searchable'    => true,
                'sortable'      => true
            ],
		'city' =>   [
                'data'          => 'city',
                'name'          => 'city',
                'searchable'    => true,
                'sortable'      => true
            ],
		'state' =>   [
                'data'          => 'state',
                'name'          => 'state',
                'searchable'    => true,
                'sortable'      => true
            ],
		'zip' =>   [
                'data'          => 'zip',
                'name'          => 'zip',
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
        'listRoute'     => 'parents.index',
        'createRoute'   => 'parents.create',
        'storeRoute'    => 'parents.store',
        'editRoute'     => 'parents.edit',
        'viewRoute'     => 'parents.show',
        'updateRoute'   => 'parents.update',
        'deleteRoute'   => 'parents.destroy',
        'dataRoute'     => 'parents.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'parents.index',
        'createView'    => 'parents.create',
        'editView'      => 'parents.edit',
        'deleteView'    => 'parents.destroy',
        'showView'      => 'parents.show',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model = new Parents;
    }

    /**
     * Create Parents
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
     * Update Parents
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
     * Destroy Parents
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
    public function getAll($orderBy = 'id', $sort = 'asc')
    {
        return $this->model->orderBy($orderBy, $sort)->get();
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
        return $this->model->where('user_type', '1')->select($this->getTableFields())->get();
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