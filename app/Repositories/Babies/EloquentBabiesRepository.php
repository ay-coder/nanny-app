<?php namespace App\Repositories\Babies;

/**
 * Class EloquentBabiesRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\Babies\Babies;
use App\Models\Access\User\User;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;
use Carbon\Carbon;

class EloquentBabiesRepository extends DbRepository
{
    /**
     * Babies Model
     *
     * @var Object
     */
    public $model;

    /**
     * Babies Title
     *
     * @var string
     */
    public $moduleTitle = 'Babies';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'            => 'Id',
        'parent'        => 'Parent',
        'title'         => 'Title',
        'birthdate'     => 'Birthdate',
        'age'           => 'Age',
        'description'   => 'Description',
        'image'         => 'Image',
        'status'        => 'Status',
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
		'parent' =>   [
                'data'          => 'parent',
                'name'          => 'parent',
                'searchable'    => true,
                'sortable'      => true
            ],
		'title' =>   [
                'data'          => 'title',
                'name'          => 'title',
                'searchable'    => true,
                'sortable'      => true
            ],
		'birthdate' =>   [
                'data'          => 'birthdate',
                'name'          => 'birthdate',
                'searchable'    => true,
                'sortable'      => true
            ],
		'age' =>   [
                'data'          => 'age',
                'name'          => 'age',
                'searchable'    => true,
                'sortable'      => true
            ],
		'description' =>   [
                'data'          => 'description',
                'name'          => 'description',
                'searchable'    => true,
                'sortable'      => true
            ],
		'image' =>   [
                'data'          => 'image',
                'name'          => 'image',
                'searchable'    => true,
                'sortable'      => true
            ],
		'status' =>   [
                'data'          => 'status',
                'name'          => 'status',
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
        'listRoute'     => 'babies.index',
        'createRoute'   => 'babies.create',
        'storeRoute'    => 'babies.store',
        'editRoute'     => 'babies.edit',
        'updateRoute'   => 'babies.update',
        'deleteRoute'   => 'babies.destroy',
        'dataRoute'     => 'babies.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'babies.index',
        'createView'    => 'babies.create',
        'editView'      => 'babies.edit',
        'deleteView'    => 'babies.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model        = new Babies;
        $this->userModel    = new User;
    }

    /**
     * Create Babies
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
     * Update Babies
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
     * Destroy Babies
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
     * Get By Parent
     *
     * @param int $parentId
     * @param string $orderBy
     * @param string $sort
     * @return mixed
     */
    public function getByParent($parentId = null, $orderBy = 'id', $sort = 'asc')
    {
        if($parentId)
        {
            return $this->model->where('parent_id', $parentId)->orderBy($orderBy, $sort)->get();
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
            $this->userModel->getTable().'.name as parent',

        ];
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->model->select($this->getTableFields())
            ->leftjoin($this->userModel->getTable(), $this->userModel->getTable().'.id', '=', $this->model->getTable().'.parent_id')->get();
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

        $dateOfBirth    = Carbon::createFromFormat('d/m/Y', $input['birthdate'])->format('Y-m-d');
        $today          = date("Y-m-d");
        $diff           = date_diff(date_create($dateOfBirth), date_create($today));


        $input['age'] = $diff->format('%y');

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

    public function updateBabies($request)
    {
        foreach ($request->data as $key => $value) {
            $baby = $this->getById($key);
            $baby->title = $value['title'];
            $baby->gender = isset($value['gender']) ? $value['gender'] : 'N/A';
            $baby->birthdate = $value['birthdate'];
            $baby->age = Carbon::parse($value['birthdate'])->age;
            $baby->description = $value['description'];
            $baby->title = $value['title'];

            if(isset($value['image']) && ($value['image']->getClientOriginalExtension() !== ''))
            {
                $file = $value['image'];
                $imageName  = rand(11111, 99999) . '_baby.' . $file->getClientOriginalExtension();
                $file->move(base_path() . '/public/uploads/babies/', $imageName);
                $baby->image = $imageName;
            }

            $baby->save();
        }

        return true;
    }
}