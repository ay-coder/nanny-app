<?php namespace App\Repositories\Sitters;

/**
 * Class EloquentSittersRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\Sitters\Sitters;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;
use App\Models\Access\User\User;

class EloquentSittersRepository extends DbRepository
{
    /**
     * Sitters Model
     *
     * @var Object
     */
    public $model;

    /**
     * Sitters Title
     *
     * @var string
     */
    public $moduleTitle = 'Sitters';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'            => 'Id',
        'category'      => 'Category',
        'username'      => 'User Name',
        'vacation_mode' => 'Vacation Mode',
        'mobile'        => 'Contact Number',
        'about_me'      => 'About',
        'sitter_start_time'      => 'Start Time',
        'sitter_end_time'      => 'End Time',
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
        'category' =>   [
                'data'          => 'category',
                'name'          => 'category',
                'searchable'    => true,
                'sortable'      => true
            ],
		'username' =>   [
                'data'          => 'username',
                'name'          => 'username',
                'searchable'    => true,
                'sortable'      => true
            ],
        'vacation_mode' =>   [
                'data'          => 'vacation_mode',
                'name'          => 'vacation_mode',
                'searchable'    => true,
                'sortable'      => true
            ],
		'mobile' =>   [
                'data'          => 'mobile',
                'name'          => 'mobile',
                'searchable'    => true,
                'sortable'      => true
            ],
		'about_me' =>   [
                'data'          => 'about_me',
                'name'          => 'about_me',
                'searchable'    => true,
                'sortable'      => true
            ],
		'sitter_start_time' =>   [
                'data'          => 'sitter_start_time',
                'name'          => 'sitter_start_time',
                'searchable'    => true,
                'sortable'      => true
            ],
        'sitter_end_time' =>   [
                'data'          => 'sitter_end_time',
                'name'          => 'sitter_end_time',
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
        'listRoute'     => 'sitters.index',
        'createRoute'   => 'sitters.create',
        'storeRoute'    => 'sitters.store',
        'editRoute'     => 'sitters.edit',
        'updateRoute'   => 'sitters.update',
        'deleteRoute'   => 'sitters.destroy',
        'dataRoute'     => 'sitters.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'sitters.index',
        'createView'    => 'sitters.create',
        'editView'      => 'sitters.edit',
        'deleteView'    => 'sitters.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model        = new Sitters;
        $this->userModel    = new User;
    }

    /**
     * Create Sitters
     *
     * @param array $input
     * @return mixed
     */
    public function create($input)
    {
        $userData = [
            'name'      => $input['name'],
            'email'     => $input['email'],
            'password'  => bcrypt($input['password']),
            'mobile'    => $input['mobile'],
            'user_type' => 2
        ];

        $user = User::create($userData);
        
        $input['user_id']  = $user->id;
        $model  = $this->model->create($input);

        if($model)
        {
            return $model;
        }

        return false;
    }

    /**
     * Update Sitters
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
            $updateUser = false;

            if(isset($input['mobile']))
            {
                $model->user->mobile = $input['mobile'];
                $updateUser = true;
            }
            if(isset($input['name']))
            {
                $model->user->name = $input['name'];                    
                $updateUser = true;
            }

            if($updateUser)
            {
                $model->user->save();
            }

            return $model->update($input);
        }

        return false;
    }

    /**
     * Destroy Sitters
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
        return $this->model->where('vacation_mode', 0)->with(['user', 'reviews', 'reviews.user'])->orderBy($orderBy, $sort)->get();
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
             return $this->model->with(['user', 'reviews', 'reviews.user'])
             ->where('user_id', $id)
             ->first();
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
            $this->userModel->getTable().'.name as username',
            $this->userModel->getTable().'.mobile'

        ];
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        //return $this->model->select($this->getTableFields())->get();
        return  $this->model->select($this->getTableFields())
                ->leftjoin($this->userModel->getTable(), $this->userModel->getTable().'.id', '=', $this->model->getTable().'.user_id')->get();
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