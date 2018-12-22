<?php namespace App\Repositories\Booking;

/**
 * Class EloquentBookingRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\Booking\Booking;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;
use App\Models\Payment\Payment;
use App\Models\Access\User\User;
use Auth;

class EloquentBookingRepository extends DbRepository
{
    /**
     * Booking Model
     *
     * @var Object
     */
    public $model;

    /**
     * Booking Title
     *
     * @var string
     */
    public $moduleTitle = 'Booking';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'            => 'Id',
        'username'      => 'Parent',
        'sitter_id'     => 'Sitter',
        'baby_id'       => 'Baby',
        'is_multiple'   => 'Multiple',
        'booking_date'  => 'Booking Date',
        'start_time'    => 'Start Time',
        'end_time'      => 'End Time',
        'booking_start_time' => 'Booking Start Time',
        'booking_end_time'   => 'Booking End Time',
        'booking_status'     => 'Status',
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
		'username' =>   [
                'data'          => 'username',
                'name'          => 'username',
                'searchable'    => true,
                'sortable'      => true
            ],
		'sitter_id' =>   [
                'data'          => 'sitter_id',
                'name'          => 'sitter_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'baby_id' =>   [
                'data'          => 'baby_id',
                'name'          => 'baby_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'is_multiple' =>   [
                'data'          => 'is_multiple',
                'name'          => 'is_multiple',
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
		'booking_start_time' =>   [
                'data'          => 'booking_start_time',
                'name'          => 'booking_start_time',
                'searchable'    => true,
                'sortable'      => true
            ],
		'booking_end_time' =>   [
                'data'          => 'booking_end_time',
                'name'          => 'booking_end_time',
                'searchable'    => true,
                'sortable'      => true
            ],
		'booking_status' =>   [
                'data'          => 'booking_status',
                'name'          => 'booking_status',
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
        'listRoute'     => 'booking.index',
        'createRoute'   => 'booking.create',
        'storeRoute'    => 'booking.store',
        'editRoute'     => 'booking.edit',
        'updateRoute'   => 'booking.update',
        'deleteRoute'   => 'booking.destroy',
        'dataRoute'     => 'booking.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'booking.index',
        'createView'    => 'booking.create',
        'editView'      => 'booking.edit',
        'deleteView'    => 'booking.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model        = new Booking;
        $this->userModel    = new User;
    }

    /**
     * Create Booking
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
     * Update Booking
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
     * Destroy Booking
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
        return $this->model->with(['user', 'sitter', 'baby','review'])->orderBy($orderBy, $sort)->get();
    }

    /**
     * Get All
     *
     * @param string $orderBy
     * @param string $sort
     * @return mixed
     */
    public function getAllParentActiveBookings($orderBy = 'booking_date', $sort = 'asc')
    {
        $parentId   = Auth::user()->id;
        $userInfo   = User::with('parent_bookings', 'parent_bookings.payment')->where('id', $parentId)->first();
        $skippIds   = [];

        if(isset($userInfo->parent_bookings) && count($userInfo->parent_bookings))
        {
            foreach($userInfo->parent_bookings as $booking)
            {
                if(isset($booking->payment) && $booking->payment->payment_status == 1)
                {
                    $skippIds[] = $booking->id;
                }
            }
        }
        return $this->model->with(['user', 'sitter', 'baby', 'payment', 'review'])
            /*->whereDate('booking_date', '>=', date('Y-m-d'))*/
            ->where('user_id', $parentId)
            ->whereIn('booking_status', ['ACCEPTED', 'REQUESTED', 'STARTED', 'COMPLETED'])
            ->whereNotIn('id', $skippIds)
            ->orderBy($orderBy, $sort)->get();
    }



    /**
     * Get All Past Booking
     *
     * @param string $orderBy
     * @param string $sort
     * @return mixed
     */
    public function getAllPast($orderBy = 'booking_date', $sort = 'asc')
    {
        $parentId = Auth::user()->id;


        return $this->model->whereIn('booking_status', ['COMPLETED', 'CANCELED'])
            ->with(['user', 'sitter', 'baby', 'payment', 'review'])
            ->leftjoin('data_payments', 'data_payments.booking_id', 'data_bookings.id')
            ->where('user_id', $parentId)
            ->where('data_payments.payment_status', '!=', null)->orWhere('data_bookings.booking_status', 'CANCELED')
            ->orderBy($orderBy, $sort)
            ->get();
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

    /**
     * Get Sitter Active Bookings
     *
     * @param int $sitterId
     * @return array
     */
    public function getSitterActiveBookings($sitterId = null)
    {
        if($sitterId)
        {
            $paidActiveBookingIds = [];
            $paidActiveBookingIds = Payment::where([
                'sitter_id'         => $sitterId,
                'payment_status'    => 1
            ])->pluck('booking_id')->toArray();

            return $this->model->with(['user', 'sitter', 'baby', 'payment'])
            ->where('sitter_id', $sitterId)
            /*->whereDate('booking_date', '>=', date('Y-m-d'))*/
            ->whereIn('booking_status', ['REQUESTED', 'ACCEPTED', 'STARTED', 'COMPLETED'])
            ->whereNotIn('id', $paidActiveBookingIds)
            ->orderBy('booking_date')
            ->get();
        }

        return false;
    }

    /**
     * Get Sitter Past Bookings
     *
     * @param int $sitterId
     * @return array
     */
    public function getSitterPastBookings($sitterId = null)
    {
        if($sitterId)
        {
            $completedBookings = Payment::where([
                'sitter_id'         => $sitterId,
                'payment_status'    => 1
            ])->pluck('booking_id');

            $completed =  $this->model->with(['user', 'sitter', 'baby', 'payment'])
            ->where('sitter_id', $sitterId)
            ->whereIn('id', $completedBookings)
            ->whereIn('booking_status', ['COMPLETED', 'CANCELED'])
            ->orderBy('booking_date', 'DESC')
            ->get();

            $canceled = $this->model->with(['user', 'sitter', 'baby', 'payment'])
            ->where('sitter_id', $sitterId)
            ->whereIn('booking_status', ['CANCELED'])
            ->orderBy('booking_date', 'DESC')
            ->get();

            $all = $completed->merge($canceled);

            return $all;

        }

        return false;
    }

    /**
     * Get Sitter Past Bookings
     *
     * @param int $sitterId
     * @return array
     */
    public function getSitterCompletedBookings($sitterId = null)
    {
        if($sitterId)
        {
            return $this->model->with(['user', 'sitter', 'baby', 'payment'])
            ->where([
                'sitter_id'         => $sitterId,
                'booking_status'    => 'COMPLETED'
            ])
            ->orderBy('booking_date', 'DESC')
            ->get();
        }

        return false;
    }

    /**
     * Get Sitter Past Bookings
     *
     * @param int $sitterId
     * @return array
     */
    public function getSingleBooking($bookingId = null)
    {
        if($bookingId)
        {
            return $this->model->with(['user', 'sitter', 'baby', 'payment'])
            ->where('id', $bookingId)
            ->first();
        }

        return false;
    }
}