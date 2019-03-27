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
use Carbon\Carbon;
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
        $userId     = isset($input['user_id']) ? $input['user_id'] : false;
        $isBooking  = access()->isActiveBookingAvailable($userId);

        if($isBooking == false)
        {
            return false;
        }


        if(isset($input['baby_ids']))
        {
            if(count($input['baby_ids']) == 1)
            {
                $input['baby_id'] = $input['baby_ids'][0];
                unset($input['baby_ids']);
            }
            else if(is_array($input['baby_ids']) && count($input['baby_ids']))
            {
                $input['baby_id'] = array_pop($input['baby_ids']);

                if(count($input['baby_ids']))
                {
                    $input['is_multiple'] = 1;
                    $input['baby_ids'] = implode(',', $input['baby_ids']);
                }
            }
        }

        if(isset($input['baby_id']))
        {
            $input['baby_id'] = $input['baby_id'];
        }


        /*$bookingEndDate     = isset($input['booking_date']) ? $input['booking_date'] : date('Y-m-d H:i:s');
        $bookingStartTime   = date('Y-m-d H:i:s', strtotime($input['booking_date'] . $input['booking_start_time']));
        $bookingEndTime     = date('Y-m-d H:i:s', strtotime($bookingEndDate . $input['booking_end_time']));*/

        $bookingDate = str_replace('/', '-', $input['booking_date']);
        $bookingDate = date('Y-m-d', strtotime($bookingDate));
        $input['booking_date']      = $bookingDate;
        $input['booking_status']    = 'REQUESTED';
        $input['start_time']        = date('H:i:s', strtotime($input['booking_start_time']));
        $input['end_time']          = date('H:i:s', strtotime($input['booking_end_time']));
        $input['booking_start_time']= $input['booking_start_time'];
        $input['booking_end_time']  = $input['booking_end_time'];

        /*$input              = array_merge($input, ['user_id' => $input['user_id'],
            'booking_date'      => date('Y-m-d', strtotime($input['booking_date'])),
            'booking_start_time' => isset($input['booking_start_time']) ? $input['booking_start_time'] : $bookingStartTime,
            'booking_end_time'  => isset($input['booking_end_time']) ? : $input['booking_end_time'] : $bookingEndTime,
            'start_time'        => $input['booking_start_time'],
            'end_time'          => $input['booking_end_time'],
            'booking_status'    => ,
            'parking_fees'      => isset($input['parking_fees']) ? $input['parking_fees'] : 0
        ]);*/

        $startTime  = $input['booking_start_time'];
        $endTime    = $input['booking_end_time'];

        $query = $this->model->where([
            'sitter_id'  => $input['sitter_id'],
        ])->whereIn('booking_status', [ 'REQUESTED', 'PENDING', 'STARTED']);

        if($startTime)
        {
            $query->where(function($q) use($startTime, $endTime)
            {
                $q->whereBetween('booking_start_time',  [$startTime, $endTime])
                ->orWhereBetween('booking_end_time',  [$startTime, $endTime]);
            });
        }

        $timeAllow = $query->get();

        if(isset($timeAllow) && count($timeAllow))
        {
            return false;
        }

        $model = $this->model->create($input);

        if($model)
        {
            if($userId)
            {
                
                $isBooking->allowed_bookings = $isBooking->allowed_bookings - 1;
                $isBooking->save();
            }

            $parent         = User::find($model->user_id);
            $sitter         = User::find($model->sitter_id);
            $sitterText     = config('constants.NotificationText.SITTER.JOB_ADD');

            $sitterpayload  = [
                'mtitle'    => '',
                'mdesc'     => $sitterText,
                'parent_id' => $parent->id,
                'sitter_id' => $model->sitter_id,
                'booking_id' => $model->id,
                'ntype'     => 'NEW_BOOKING'
            ];

            $storeSitterNotification = [
                'user_id'       => $model->user_id,
                'sitter_id'     => $model->sitter_id,
                'booking_id'    => $model->id,
                'to_user_id'    => $model->sitter_id,
                'description'   => $sitterText
            ];

            access()->addNotification($storeSitterNotification);

            access()->sentPushNotification($sitter, $sitterpayload);
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
        if(isset($input['baby_ids']))
        {
            if(count($input['baby_ids']) == 1)
            {
                $input['baby_id'] = $input['baby_ids'][0];
                unset($input['baby_ids']);
            }
            else if(is_array($input['baby_ids']) && count($input['baby_ids']))
            {
                $input['baby_id'] = array_pop($input['baby_ids']);

                if(count($input['baby_ids']))
                {
                    $input['is_multiple'] = 1;
                    $input['baby_ids'] = implode(',', $input['baby_ids']);
                }
            }
        }

        $inputBookingDate = explode('/', $input['booking_date']);
        $inputDate        = $inputBookingDate[2] . '-'.$inputBookingDate[1]. '-'. $inputBookingDate[0];

        $inputDate        = Carbon::parse($inputDate)->format('Y-m-d');

        $input['booking_date'] = $inputDate;
        
        $bookingEndDate     = isset($input['booking_date']) ? $input['booking_date'] : date('Y-m-d H:i:s');
        $bookingStartTime   = date('Y-m-d H:i:s', strtotime($input['booking_date'] . $input['booking_start_time']));
        $bookingEndTime     = date('Y-m-d H:i:s', strtotime($bookingEndDate . $input['booking_end_time']));

        $input              = array_merge($input, ['user_id' => $input['user_id'],
            'booking_date'      => date('Y-m-d', strtotime($input['booking_date'])),
            'booking_start_time' => $bookingStartTime,
            'booking_end_time'  => $bookingEndTime,
            'start_time'        => $input['booking_start_time'],
            'end_time'          => $input['booking_end_time'],
            'booking_status'    => 'REQUESTED',
            'parking_fees'      => isset($input['parking_fees']) ? $input['parking_fees'] : 0
        ]);

        $startTime  = $bookingStartTime;
        $endTime    = $bookingEndTime;

        $query = $this->model->where([
            'sitter_id'  => $input['sitter_id'],
        ]);

        if($startTime)
        {
            $query->where(function($q) use($startTime, $endTime)
            {
                $q->whereBetween('booking_start_time',  [$startTime, $endTime])
                ->orWhereBetween('booking_end_time',  [$startTime, $endTime]);
            });
        }

        $timeAllow = $query->get();

        if(isset($timeAllow) && count($timeAllow))
        {
            return false;
        }

        $model = $this->model->find($id);

        if($model)
        {
            $model          = $model->update($input);
            $model          = $this->model->find($id);
            $parent         = User::find($model->user_id);
            $sitter         = User::find($model->sitter_id);
            $sitterText     = config('constants.NotificationText.SITTER.JOB_ADD');

            $sitterpayload  = [
                'mtitle'    => '',
                'mdesc'     => $sitterText,
                'parent_id' => $parent->id,
                'sitter_id' => $model->sitter_id,
                'booking_id' => $model->id,
                'ntype'     => 'NEW_BOOKING'
            ];

            $storeSitterNotification = [
                'user_id'       => $model->user_id,
                'sitter_id'     => $model->sitter_id,
                'booking_id'    => $model->id,
                'to_user_id'    => $model->sitter_id,
                'description'   => $sitterText
            ];

            access()->addNotification($storeSitterNotification);

            access()->sentPushNotification($sitter, $sitterpayload);

            return $model;
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

        $completed = $this->model->whereIn('booking_status', ['COMPLETED'])
            ->with(['user', 'sitter', 'baby', 'payment', 'review'])
            ->where('user_id', $parentId)
            ->orderBy($orderBy, $sort)
            ->get();

        $canceled = $this->model->whereIn('booking_status', [ 'CANCELED'])
            ->with(['user', 'sitter', 'baby', 'payment', 'review'])
            ->where('user_id', $parentId)
            ->orderBy($orderBy, $sort)
            ->get();

        $result = [];

        foreach($completed as $c)
        {
            if(isset($c->payment) && isset($c->payment->payment_status))
            {
                $result[] = $c;
            }
        }


        foreach($canceled as $cd)
        {
            $result[] = $cd;
        }


        $output = collect($result);

        return $output->sortByDesc($orderBy);
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

    /**
     * Cancel By Admin
     * 
     * @param int $bookingId
     * @return bool
     */
    public function cancelByAdmin($bookingId = null)
    {
        if($bookingId)
        {
            $bookingInfo = $this->model->where('id', $bookingId)->first();

            $sitter         = User::find($bookingInfo->sitter_id);
            $parent         = User::find($bookingInfo->user_id);
            $sitterText     = 'Admin has cancelled the appointment';

            $sitterpayload  = [
                'mtitle'    => '',
                'mdesc'     => $sitterText,
                'parent_id' => $bookingInfo->user_id,
                'sitter_id' => $bookingInfo->sitter_id,
                'booking_id' => $bookingInfo->id,
                'ntype'     => 'BOOKING_ADMIN_CANCELED'
            ];


            $storeSitterNotification = [
                'user_id'       => 1,
                'sitter_id'     => $sitter->id,
                'booking_id'    => $bookingInfo->id,
                'to_user_id'    => $sitter->id,
                'description'   => $sitterText
            ];

            access()->addNotification($storeSitterNotification);

            access()->sentPushNotification($sitter, $sitterpayload);

            // Restore Booking
            access()->restoreSingleBooking($bookingInfo->sitter_id);

            $parentText     = 'Admin has cancelled your booking';

            $parentpayload  = [
                'mtitle'    => '',
                'mdesc'     => $parentText,
                'parent_id' => $bookingInfo->user_id,
                'sitter_id' => $bookingInfo->sitter_id,
                'booking_id' => $bookingInfo->id,
                'ntype'     => 'BOOKING_ADMIN_CANCELED'
            ];


            $storeParentNotification = [
                'user_id'       => 1,
                'sitter_id'     => $bookingInfo->sitter_id,
                'booking_id'    => $bookingInfo->id,
                'to_user_id'    => $parent->id,
                'description'   => $parentText
            ];

            access()->addNotification($storeParentNotification);

            access()->sentPushNotification($parent, $parentpayload);

            $bookingInfo->booking_status = 'CANCELED';
            return $bookingInfo->save();
        }

        return false; 
    }
}