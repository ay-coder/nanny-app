<?php namespace App\Repositories\SitterEarning;

/**
 * Class EloquentSitterEarningRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\SitterEarning\SitterEarning;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;
use Carbon\Carbon;


class EloquentSitterEarningRepository extends DbRepository
{
    /**
     * SitterEarning Model
     *
     * @var Object
     */
    public $model;

    /**
     * SitterEarning Title
     *
     * @var string
     */
    public $moduleTitle = 'SitterEarning';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'                => 'Id',
        'sitter_id'         => 'Sitter',
        'user_id'           => 'Parent',
        'booking_date'      => 'Date',
        'start_time'        => 'In Time',
        'end_time'          => 'Out Time',
        "amount"            => "amount"
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
		'sitter_id' =>   [
                'data'          => 'sitter_id',
                'name'          => 'sitter_id',
                'searchable'    => true,
                'sortable'      => true
            ],
        'user_id' =>   [
                'data'          => 'user_id',
                'name'          => 'user_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'booking_date' =>   [
                'data'          => 'booking_date',
                'name'          => 'booking_date',
                'searchable'    => true,
                'sortable'      => true
            ],
		'start_time' =>   [
                'data'          => 'start_time',
                'name'          => 'start_time',
                'searchable'    => true,
                'sortable'      => true
            ],
		'end_time' =>   [
                'data'          => 'end_time',
                'name'          => 'end_time',
                'searchable'    => true,
                'sortable'      => true
            ],
		'amount' => [
            'data'          => 'amount',
            'name'          => 'amount',
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
        'listRoute'     => 'sitterearning.index',
        'createRoute'   => 'sitterearning.create',
        'storeRoute'    => 'sitterearning.store',
        'editRoute'     => 'sitterearning.edit',
        'updateRoute'   => 'sitterearning.update',
        'deleteRoute'   => 'sitterearning.destroy',
        'dataRoute'     => 'sitterearning.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'sitterearning.index',
        'createView'    => 'sitterearning.create',
        'editView'      => 'sitterearning.edit',
        'deleteView'    => 'sitterearning.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model = new SitterEarning;
    }

    /**
     * Create SitterEarning
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
     * Update SitterEarning
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
     * Destroy SitterEarning
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
        if(session('sitterEarningFilter'))
        {
            $startDate  = Carbon::parse(session('startDate'))->startOfDay();
            $endDate    = Carbon::parse(session('endDate'))->endOfDay();

            return $this->model->with(['payment', 'user', 'sitter'])
                ->select($this->getTableFields())
                ->where('sitter_id', session('sitterEarningFilter'))
                ->where($this->model->getTable().'.created_at', '>=', $startDate)
                ->where($this->model->getTable().'.created_at', '<=', $endDate)
                ->where('booking_status', 'COMPLETED')
                ->get();
        }

        return $this->model->with(['payment', 'user', 'sitter'])->select($this->getTableFields())
            ->where('booking_status', 'COMPLETED')->get();
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