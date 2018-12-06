<?php namespace App\Repositories\Payment;

/**
 * Class EloquentPaymentRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\Payment\Payment;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;
use Cartalyst\Stripe\Stripe;

class EloquentPaymentRepository extends DbRepository
{
    /**
     * Payment Model
     *
     * @var Object
     */
    public $model;

    /**
     * Payment Title
     *
     * @var string
     */
    public $moduleTitle = 'Payment';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'        => 'Id',
'booking_id'        => 'Booking_id',
'sitter_id'        => 'Sitter_id',
'per_hour'        => 'Per_hour',
'total_hour'        => 'Total_hour',
'sub_total'        => 'Sub_total',
'tax'        => 'Tax',
'other_charges'        => 'Other_charges',
'parking_fees'        => 'Parking_fees',
'total'        => 'Total',
'description'        => 'Description',
'payment_status'        => 'Payment_status',
'payment_via'        => 'Payment_via',
'payment_details'        => 'Payment_details',
'status'        => 'Status',
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
		'booking_id' =>   [
                'data'          => 'booking_id',
                'name'          => 'booking_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'sitter_id' =>   [
                'data'          => 'sitter_id',
                'name'          => 'sitter_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'per_hour' =>   [
                'data'          => 'per_hour',
                'name'          => 'per_hour',
                'searchable'    => true,
                'sortable'      => true
            ],
		'total_hour' =>   [
                'data'          => 'total_hour',
                'name'          => 'total_hour',
                'searchable'    => true,
                'sortable'      => true
            ],
		'sub_total' =>   [
                'data'          => 'sub_total',
                'name'          => 'sub_total',
                'searchable'    => true,
                'sortable'      => true
            ],
		'tax' =>   [
                'data'          => 'tax',
                'name'          => 'tax',
                'searchable'    => true,
                'sortable'      => true
            ],
		'other_charges' =>   [
                'data'          => 'other_charges',
                'name'          => 'other_charges',
                'searchable'    => true,
                'sortable'      => true
            ],
		'parking_fees' =>   [
                'data'          => 'parking_fees',
                'name'          => 'parking_fees',
                'searchable'    => true,
                'sortable'      => true
            ],
		'total' =>   [
                'data'          => 'total',
                'name'          => 'total',
                'searchable'    => true,
                'sortable'      => true
            ],
		'description' =>   [
                'data'          => 'description',
                'name'          => 'description',
                'searchable'    => true,
                'sortable'      => true
            ],
		'payment_status' =>   [
                'data'          => 'payment_status',
                'name'          => 'payment_status',
                'searchable'    => true,
                'sortable'      => true
            ],
		'payment_via' =>   [
                'data'          => 'payment_via',
                'name'          => 'payment_via',
                'searchable'    => true,
                'sortable'      => true
            ],
		'payment_details' =>   [
                'data'          => 'payment_details',
                'name'          => 'payment_details',
                'searchable'    => true,
                'sortable'      => true
            ],
		'status' =>   [
                'data'          => 'status',
                'name'          => 'status',
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
        'listRoute'     => 'payment.index',
        'createRoute'   => 'payment.create',
        'storeRoute'    => 'payment.store',
        'editRoute'     => 'payment.edit',
        'updateRoute'   => 'payment.update',
        'deleteRoute'   => 'payment.destroy',
        'dataRoute'     => 'payment.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'payment.index',
        'createView'    => 'payment.create',
        'editView'      => 'payment.edit',
        'deleteView'    => 'payment.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model = new Payment;
    }

    /**
     * Create Payment
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
     * Update Payment
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
     * Destroy Payment
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
     * @param int $paymentId
     * @param string $token
     * @param float $tip
     */
    public function addPayment($paymentId = null, $token = null, $tip = 0)
    {
        if($paymentId && $token)
        {
            $payment    = $this->model->where('id', $paymentId)->first();
            $total      = (float) $payment->total + $tip;

            if(isset($payment) && $total > 0)
            {
                $stripe = new Stripe('sk_test_bm8U8YSh3YQIhyQRKvhWFvcY');
                $charge = $stripe->charges()->create([
                    'amount'            => $total,
                    'currency'          => 'usd',
                    'description'       => 'Paid By Sitter',
                    'source'            => $token,
                    'statement_descriptor' =>'Test Payment'
                ]);

                $payment->payment_status    = 1;
                $payment->payment_via       = "STRIPE - " . $charge['id'];
                $payment->payment_details   = $charge['statement_descriptor'];
                $payment->tip               = $tip;

                return $payment->save();
            }
        }

        return false;
    }
}