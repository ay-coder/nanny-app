<?php namespace App\Repositories\Activation;

/**
 * Class EloquentActivationRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\Activation\Activation;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;
use App\Models\Plans\Plans;

class EloquentActivationRepository extends DbRepository
{
    /**
     * Activation Model
     *
     * @var Object
     */
    public $model;

    /**
     * Activation Title
     *
     * @var string
     */
    public $moduleTitle = 'Activation';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'        => 'Id',
'user_id'        => 'User_id',
'plan_id'        => 'Plan_id',
'allowed_bookings'        => 'Allowed_bookings',
'status'        => 'Status',
'activated_at'        => 'Activated_at',
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
		'plan_id' =>   [
                'data'          => 'plan_id',
                'name'          => 'plan_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'allowed_bookings' =>   [
                'data'          => 'allowed_bookings',
                'name'          => 'allowed_bookings',
                'searchable'    => true,
                'sortable'      => true
            ],
		'status' =>   [
                'data'          => 'status',
                'name'          => 'status',
                'searchable'    => true,
                'sortable'      => true
            ],
		'activated_at' =>   [
                'data'          => 'activated_at',
                'name'          => 'activated_at',
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
        'listRoute'     => 'activation.index',
        'createRoute'   => 'activation.create',
        'storeRoute'    => 'activation.store',
        'editRoute'     => 'activation.edit',
        'updateRoute'   => 'activation.update',
        'deleteRoute'   => 'activation.destroy',
        'dataRoute'     => 'activation.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'activation.index',
        'createView'    => 'activation.create',
        'editView'      => 'activation.edit',
        'deleteView'    => 'activation.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model = new Activation;
    }

    /**
     * Create Activation
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
     * Update Activation
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
     * Destroy Activation
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
     * Add Payment
     * 
     * @param int $planId
     * @param string $token
     * @param float $tip
     */
    public function addPayment($planId = null, $token = null, $tip = 0)
    {
        if($planId && $token)
        {
            $plan = Plans::where('id', $planId)->first();

            if(isset($plan->id))
            {
                $total = (float) $plan->amount;
                
                if(isset($plan) && $total > 0)
                {
                    $stripe = new Stripe('sk_test_autrVFuGHApy11JWvn3hWpPY');
                    $charge = $stripe->charges()->create([
                        'amount'            => $total,
                        'currency'          => 'usd',
                        'description'       => 'Plan Purchase by Parent',
                        'source'            => $token,
                        'statement_descriptor' =>'Test Payment'
                    ]);

                    if($plan->plan_type == 'A')
                    {
                        $totalBookings = 1;
                    }

                    if($plan->plan_type == 'B')
                    {
                        $totalBookings = 10;
                    }

                    if($plan->plan_type == 'C')
                    {
                        $totalBookings = 10;
                    }

                    
                    return $this->model->create([
                        'user_id'           => access()->user()->id,
                        'plan_id'           => $planId,
                        'allowed_bookings'  => $totalBookings,
                        'status'            => 1,
                        'activated_at'      => date('Y-m-d H:i:s'),
                        'payment_status'    => 1,
                        'payment_via'       => "STRIPE - " . $charge['id'],
                        'payment_details'   => $charge['statement_descriptor']
                    ]);
                }
            }

        }

        return false;
    }
}