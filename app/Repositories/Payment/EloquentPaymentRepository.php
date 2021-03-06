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
use App\Models\Sitters\Sitters;

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
        'id'            => 'Id',
        'booking_id'    => 'Parent',
        'sitter_id'     => 'Sitter',
        'per_hour'      => 'Per Hour',
        'total_hour'    => 'Total Hour',
        'sub_total'     => 'Sub Total',
        'tax'           => 'Tax',
        'parking_fees'  => 'Parking Fees',
        'tip'           => 'Tip',
        'total'         => 'Total',
        'description'   => 'Description',
        'payment_via'   => 'Payment Ref',
        'payment_details'   => 'Payment Details',
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
		'parking_fees' =>   [
                'data'          => 'parking_fees',
                'name'          => 'parking_fees',
                'searchable'    => true,
                'sortable'      => true
            ],
        'tip' =>   [
                'data'          => 'tip',
                'name'          => 'tip',
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
    public function addPayment1($paymentId = null, $token = null, $tip = 0)
    {
        if($paymentId && $token)
        {
            $payment    = $this->model->where('id', $paymentId)->first();
            $totalAmount = access()->getBookingTotal($payment->booking_id);
            $total      = (float) $totalAmount + $tip;

            if(isset($payment) && $total > 0)
            {
                $stripe = new Stripe('sk_test_bm8U8YSh3YQIhyQRKvhWFvcY');
                //sk_test_bm8U8YSh3YQIhyQRKvhWFvcY
                //sk_test_autrVFuGHApy11JWvn3hWpPY
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
            //$paymentId  = 15;
            $payment    = $this->model->with('sitter', 'sitter.sitter')->where('id', $paymentId)->first();
            $totalAmount = access()->getBookingTotal($payment->booking_id);
            $total      = (float) $totalAmount + $tip;

            if(isset($payment) && $total > 0)
            {
                $sitter     = access()->getSitterById($payment->sitter_id);
                $publicKey  = 'pk_test_Ky5y4G4B1yGfbfF2wr7CSqqm';
                $secretKey  = 'sk_test_bm8U8YSh3YQIhyQRKvhWFvcY';
                $paidTo     = 'NannyApp';
                
                if(isset($sitter) && isset($sitter->stripe_id) && isset($sitter->stripe_details))
                {
                    if(strlen($sitter->stripe_details) > 20 && strlen($sitter->stripe_id) > 20)
                    {
                        $publicKey  = $sitter->stripe_details;
                        $secretKey  = $sitter->stripe_id;
                        $paidTo     = 'Sitter';
                    }
                }

                \Stripe\Stripe::setApiKey($secretKey);

                // Create a Charge:
                $charge = \Stripe\Charge::create([
                    "amount"            => $total * 100,
                    "currency"          => "usd",
                    "source"            => $token,
                    "transfer_group"    => "BOOKING_ID_".$payment->booking_id,
                    'description'       => 'Paid To '. $paidTo,
                    'statement_descriptor' =>'Test Payment'
                ]);

                $payment->payment_status    = 1;
                $payment->payment_via       = "STRIPE - " . $charge['id'] . ' '. $paidTo;
                $payment->payment_details   = $charge['statement_descriptor'];
                $payment->tip               = $tip;

                return $payment->save();
            }
        }

        return false;
    }
}