<?php namespace App\Repositories\Subscription;

/**
 * Class EloquentSubscriptionRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\Subscription\Subscription;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;
use App\Models\Plans\Plans;
use Cartalyst\Stripe\Stripe;
use App\Models\Access\User\User;
use Carbon\Carbon;

class EloquentSubscriptionRepository extends DbRepository
{
    /**
     * Subscription Model
     *
     * @var Object
     */
    public $model;

    /**
     * Subscription Title
     *
     * @var string
     */
    public $moduleTitle = 'Subscription';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'                => 'Id',
        'username'          => 'Parent Name',
        'plan_title'        => 'Subscription Plan',
        'allowed_bookings'  => 'Allowed Bookings',
        'amount'            => 'Amount',
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
        'username' =>   [
                'data'          => 'username',
                'name'          => 'username',
                'searchable'    => true,
                'sortable'      => true
            ],
        'plan_title' =>   [
                'data'          => 'plan_title',
                'name'          => 'plan_title',
                'searchable'    => true,
                'sortable'      => true
            ],
        'allowed_bookings' =>   [
                'data'          => 'allowed_bookings',
                'name'          => 'allowed_bookings',
                'searchable'    => true,
                'sortable'      => true
            ],
        'amount' =>   [
                'data'          => 'amount',
                'name'          => 'amount',
                'searchable'    => true,
                'sortable'      => true
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
        'listRoute'     => 'subscription.index',
        'createRoute'   => 'subscription.create',
        'storeRoute'    => 'subscription.store',
        'editRoute'     => 'subscription.edit',
        'updateRoute'   => 'subscription.update',
        'deleteRoute'   => 'subscription.destroy',
        'dataRoute'     => 'subscription.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'subscription.index',
        'createView'    => 'subscription.create',
        'editView'      => 'subscription.edit',
        'deleteView'    => 'subscription.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model        = new Subscription;
        $this->userModel    = new User;
        $this->planModel    = new Plans;
    }

    /**
     * Create Subscription
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
     * Update Subscription
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
     * Destroy Subscription
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
            $this->model->getTable().'.*',
            $this->userModel->getTable().'.name as username',
            $this->planModel->getTable().'.title as plan_title'

        ];
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        if(session('subscriptionFilter'))
        {
            $startDate  = Carbon::parse(session('startDate'))->startOfDay();
            $endDate    = Carbon::parse(session('endDate'))->endOfDay();

            return  $this->model->select($this->getTableFields())
                    ->leftjoin($this->userModel->getTable(), $this->userModel->getTable().'.id', '=', $this->model->getTable().'.user_id')
                    ->leftjoin($this->planModel->getTable(), $this->planModel->getTable().'.id', '=', $this->model->getTable().'.plan_id')
                    ->where('user_id', session('subscriptionFilter'))
                    ->where($this->userModel->getTable().'.created_at', '>=', $startDate)
                    ->where($this->userModel->getTable().'.created_at', '<=', $endDate)
                    ->get();
        }
        
        return  $this->model->select($this->getTableFields())
                ->leftjoin($this->userModel->getTable(), $this->userModel->getTable().'.id', '=', $this->model->getTable().'.user_id')
                ->leftjoin($this->planModel->getTable(), $this->planModel->getTable().'.id', '=', $this->model->getTable().'.plan_id')
                ->get();
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