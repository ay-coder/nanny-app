<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\BookingTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Booking\EloquentBookingRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment\Payment;
use App\Models\Access\User\User;
use App\Library\Push\PushNotification;

class APIBookingController extends BaseApiController
{
    /**
     * Booking Transformer
     *
     * @var Object
     */
    protected $bookingTransformer;

    /**
     * Repository
     *
     * @var Object
     */
    protected $repository;

    /**
     * PrimaryKey
     *
     * @var string
     */
    protected $primaryKey = 'bookingId';

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository                       = new EloquentBookingRepository();
        $this->bookingTransformer = new BookingTransformer();
    }

    /**
     * List of All Booking
     *
     * @param Request $request
     * @return json
     */
    public function index(Request $request)
    {
        $paginate   = $request->get('paginate') ? $request->get('paginate') : false;
        $orderBy    = $request->get('orderBy') ? $request->get('orderBy') : 'booking_date';
        $order      = $request->get('order') ? $request->get('order') : 'ASC';
        $items      = $paginate ? $this->repository->model->with(['user', 'payment', 'sitter', 'baby', 'review'])->orderBy($orderBy, $order)
            ->whereDate('booking_date', '>=', date('Y-m-d'))
            ->whereIn('booking_status', ['ACCEPTED', 'REQUESTED', 'STARTED', 'COMPLETED'])
        ->paginate($paginate)->items() : $this->repository->getAllParentActiveBookings($orderBy, $order);

        if(isset($items) && count($items))
        {
            $itemsOutput = $this->bookingTransformer->transformCollection($items);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Booking!'
            ], 'No Booking Found !');
    }

    /**
     * Past Bookings
     *
     * @param Request $request
     * @return json
     */
    public function pastBookings(Request $request)
    {
        $userInfo   = $this->getAuthenticatedUser();
        $paginate   = $request->get('paginate') ? $request->get('paginate') : false;
        $orderBy    = $request->get('orderBy') ? $request->get('orderBy') : 'booking_date';
        $order      = $request->get('order') ? $request->get('order') : 'DESC';
        $items      = $paginate ? $this->repository->model->whereIn('booking_status', ['COMPLETED', 'CANCELED'])->with(['user', 'sitter', 'baby', 'payment', 'review'])->orderBy($orderBy, $order)->paginate($paginate)->items() : $this->repository->getAllPast($orderBy, $order);

        if(isset($items) && count($items))
        {
            $itemsOutput = $this->bookingTransformer->pastBookingTransform($items);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Booking!'
            ], 'No Booking Found !');
    }

    /**
     * Create
     *
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'baby_id'       => 'required',
            'sitter_id'     => 'required',
            'booking_date'  => 'required',
            'start_time'    => 'required',
            'end_time'      => 'required',
        ]);

        if($validator->fails())
        {
            $messageData = '';

            foreach($validator->messages()->toArray() as $message)
            {
                $messageData = $message[0];
            }
            return $this->failureResponse($validator->messages(), $messageData);
        }

        $userInfo           = $this->getAuthenticatedUser();
        $isBooking          = access()->isActiveBookingAvailable($userInfo->id);

        if(isset($isBooking->id))
        {
            $input              = $request->all();
            $bookingEndDate     = $request->has('booking_end_date') ? $request->get('booking_end_date') : date('Y-m-d H:i:s');
            $bookingStartTime   = date('Y-m-d H:i:s', strtotime($input['booking_date'] . $input['start_time']));
            $bookingEndTime     = date('Y-m-d H:i:s', strtotime($bookingEndDate . $input['end_time']));
            $input              = array_merge($input, ['user_id' => $userInfo->id,
                'booking_date'      => date('Y-m-d', strtotime($input['booking_date'])),
                'booking_start_time' => $bookingStartTime,
                'booking_end_time'  => $bookingEndTime,
                'booking_status'    => 'REQUESTED',
                'parking_fees'      => isset($input['parking_fees']) ? $input['parking_fees'] : 0
            ]);

            $model = $this->repository->create($input);

            if($model)
            {
                $parent         = User::find($model->user_id);
                $sitter         = User::find($model->sitter_id);
                //$parentText     = config('constants.NotificationText.PARENT.JOB_ADD');
                $sitterText     = config('constants.NotificationText.SITTER.JOB_ADD');
                /*$parentpayload  = [
                    'mtitle'    => '',
                    'mdesc'     => $parentText,
                    'parent_id' => $parent->id,
                    'sitter_id' => $request->get('sitter_id'),
                    'booking_id' => $model->id,
                    'ntype'     => 'NEW_BOOKING'
                ];*/

                $sitterpayload  = [
                    'mtitle'    => '',
                    'mdesc'     => $sitterText,
                    'parent_id' => $parent->id,
                    'sitter_id' => $request->get('sitter_id'),
                    'booking_id' => $model->id,
                    'ntype'     => 'NEW_BOOKING'
                ];

                /*$storeParentNotification = [
                    'user_id'       => $model->user_id,
                    'sitter_id'     => $model->sitter_id,
                    'booking_id'    => $model->id,
                    'to_user_id'    => $model->user_id,
                    'description'   => $parentText
                ];*/

                $storeSitterNotification = [
                    'user_id'       => $model->user_id,
                    'sitter_id'     => $model->sitter_id,
                    'booking_id'    => $model->id,
                    'to_user_id'    => $model->sitter_id,
                    'description'   => $sitterText
                ];

                //access()->addNotification($storeParentNotification);
                access()->addNotification($storeSitterNotification);

                //access()->sentPushNotification($parent, $parentpayload);
                access()->sentPushNotification($sitter, $sitterpayload);

                $responseData = $this->bookingTransformer->transform($model);

                $isBooking->allowed_bookings = $isBooking->allowed_bookings - 1;
                $isBooking->save();

                return $this->successResponse($responseData, 'Booking is Created Successfully');
            }
        }
        else
        {
            return $this->setStatusCode(400)->failureResponse([
                'reason' => 'Please purchase Plan to Continue with Booking'
                ], 'Please purchase Plan to Continue with Booking');
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
            ], 'Something went wrong !');
    }

    /**
     * View
     *
     * @param Request $request
     * @return string
     */
    public function show(Request $request)
    {
        $itemId = (int) hasher()->decode($request->get($this->primaryKey));

        if($itemId)
        {
            $itemData = $this->repository->getById($itemId);

            if($itemData)
            {
                $responseData = $this->bookingTransformer->transform($itemData);

                return $this->successResponse($responseData, 'View Item');
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs or Item not exists !'
            ], 'Something went wrong !');
    }

    /**
     * Edit
     *
     * @param Request $request
     * @return string
     */
    public function edit(Request $request)
    {
        $itemId = (int) hasher()->decode($request->get($this->primaryKey));

        if($itemId)
        {
            $status = $this->repository->update($itemId, $request->all());

            if($status)
            {
                $itemData       = $this->repository->getById($itemId);
                $responseData   = $this->bookingTransformer->transform($itemData);

                return $this->successResponse($responseData, 'Booking is Edited Successfully');
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    /**
     * Delete
     *
     * @param Request $request
     * @return string
     */
    public function delete(Request $request)
    {
        $itemId = (int) hasher()->decode($request->get($this->primaryKey));

        if($itemId)
        {
            $status = $this->repository->destroy($itemId);

            if($status)
            {
                return $this->successResponse([
                    'success' => 'Booking Deleted'
                ], 'Booking is Deleted Successfully');
            }
        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    /**
     * Accept
     *
     * @param Request $request
     * @return json
     */
    public function accept(Request $request)
    {
        if($request->has('booking_id'))
        {
            $userInfo       = $this->getAuthenticatedUser();
            $bookingInfo    = $this->repository->model->where([
                'id'                => $request->get('booking_id'),
                'sitter_id'         => $userInfo->id,
                'booking_status'    => 'REQUESTED'
            ])->first();

            if(isset($bookingInfo))
            {
                $parent         = User::find($bookingInfo->user_id);
                $sitter         = User::find($bookingInfo->sitter_id);
                $parentText     = $sitter->name . ' has Accepted your booking';

                $parentpayload  = [
                    'mtitle'    => '',
                    'mdesc'     => $parentText,
                    'parent_id' => $parent->id,
                    'sitter_id' => $userInfo->id,
                    'booking_id' => $bookingInfo->id,
                    'ntype'     => 'BOOKING_ACCEPTED'
                ];


                $storeParentNotification = [
                    'user_id'       => $userInfo->id,
                    'sitter_id'     => $userInfo->id,
                    'booking_id'    => $bookingInfo->id,
                    'to_user_id'    => $parent->id,
                    'description'   => $parentText
                ];

                access()->addNotification($storeParentNotification);

                access()->sentPushNotification($parent, $parentpayload);

                $bookingInfo->booking_status = 'ACCEPTED';
                if($bookingInfo->save())
                {
                    return $this->successResponse([
                        'success' => 'Booking Accepted by Sitter'
                    ], 'Booking Accepted by Sitter');
                }
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Booking!'
            ], 'No Booking Found !');
    }

    /* Reject
     *
     * @param Request $request
     * @return json
     */
    public function reject(Request $request)
    {
        if($request->has('booking_id'))
        {
            $userInfo       = $this->getAuthenticatedUser();
            $bookingInfo    = $this->repository->model->where([
                'id'                => $request->get('booking_id'),
                'sitter_id'         => $userInfo->id,
                'booking_status'    => 'REQUESTED'
            ])->first();

            if(isset($bookingInfo))
            {
                $parent         = User::find($bookingInfo->user_id);
                $parentText     = $userInfo->name . ' has denied your booking';

                $parentpayload  = [
                    'mtitle'    => '',
                    'mdesc'     => $parentText,
                    'parent_id' => $parent->id,
                    'sitter_id' => $userInfo->id,
                    'booking_id' => $bookingInfo->id,
                    'ntype'     => 'BOOKING_REJECTEd'
                ];


                $storeParentNotification = [
                    'user_id'       => $userInfo->id,
                    'sitter_id'     => $userInfo->id,
                    'booking_id'    => $bookingInfo->id,
                    'to_user_id'    => $parent->id,
                    'description'   => $parentText
                ];

                access()->addNotification($storeParentNotification);

                access()->sentPushNotification($parent, $parentpayload);

                $bookingInfo->booking_status = 'REJECTED';
                if($bookingInfo->save())
                {
                    return $this->successResponse([
                        'success' => 'Booking Rejected by Sitter'
                    ], 'Booking Rejected by Sitter');
                }
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Booking!'
            ], 'No Booking Found !');
    }

    /* Reject
     *
     * @param Request $request
     * @return json
     */
    public function cancel(Request $request)
    {
        if($request->has('booking_id'))
        {
            $userInfo       = $this->getAuthenticatedUser();
            $bookingInfo    = $this->repository->model->where([
                'id'        => $request->get('booking_id'),
                'user_id'   => $userInfo->id
            ])->whereNotIn('booking_status', ['STARTED', 'COMPLETED', 'CANCELED'])->first();

            if(isset($bookingInfo))
            {
                $sitter         = User::find($bookingInfo->sitter_id);
                $sitterText     = $userInfo->name . ' has cancelled the appointment';

                $sitterpayload  = [
                    'mtitle'    => '',
                    'mdesc'     => $sitterText,
                    'parent_id' => $userInfo->id,
                    'sitter_id' => $sitter->id,
                    'booking_id' => $bookingInfo->id,
                    'ntype'     => 'BOOKING_PARENT_CANCELED'
                ];


                $storeSitterNotification = [
                    'user_id'       => $userInfo->id,
                    'sitter_id'     => $sitter->id,
                    'booking_id'    => $bookingInfo->id,
                    'to_user_id'    => $userInfo->id,
                    'description'   => $sitterText
                ];

                access()->addNotification($storeSitterNotification);

                access()->sentPushNotification($sitter, $sitterpayload);


                $bookingInfo->booking_status = 'CANCELED';
                if($bookingInfo->save())
                {
                    return $this->successResponse([
                        'success' => 'Booking Cancel by Parent'
                    ], 'Booking Cancel by Parent');
                }
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Booking!'
            ], 'No Booking Found !');
    }

    /* Reject
     *
     * @param Request $request
     * @return json
     */
    public function cancelBySitter(Request $request)
    {
        if($request->has('booking_id'))
        {
            $userInfo       = $this->getAuthenticatedUser();
            $bookingInfo    = $this->repository->model->where([
                'id'        => $request->get('booking_id'),
                'sitter_id' => $userInfo->id
            ])->whereNotIn('booking_status', ['STARTED', 'COMPLETED', 'CANCELED'])->first();

            if(isset($bookingInfo))
            {
                $parent         = User::find($bookingInfo->user_id);
                $parentText     = $userInfo->name . ' has cancelled your booking';

                $parentpayload  = [
                    'mtitle'    => '',
                    'mdesc'     => $parentText,
                    'parent_id' => $parent->id,
                    'sitter_id' => $userInfo->id,
                    'booking_id' => $bookingInfo->id,
                    'ntype'     => 'BOOKING_SITTER_CANCELED'
                ];


                $storeParentNotification = [
                    'user_id'       => $userInfo->id,
                    'sitter_id'     => $userInfo->id,
                    'booking_id'    => $bookingInfo->id,
                    'to_user_id'    => $parent->id,
                    'description'   => $parentText
                ];

                access()->addNotification($storeParentNotification);

                access()->sentPushNotification($parent, $parentpayload);

                $bookingInfo->booking_status = 'CANCELED';
                if($bookingInfo->save())
                {
                    return $this->successResponse([
                        'success' => 'Booking Cancel by Sitter'
                    ], 'Booking Cancel by Sitter');
                }
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Booking!'
            ], 'No Booking Found !');
    }


    /**
     * Start
     *
     * @param Request $request
     * @return json
     */
    public function start(Request $request)
    {
        if($request->has('booking_id') && $request->has('booking_start_time'))
        {
            $userInfo       = $this->getAuthenticatedUser();
            $bookingInfo    = $this->repository->model->where([
                'id'                => $request->get('booking_id'),
                'sitter_id'         => $userInfo->id,
                'booking_status'    => 'ACCEPTED'
            ])->first();

            if(isset($bookingInfo))
            {
                $startTime = date('Y-m-d H:i:s', strtotime($request->get('booking_start_time')));
                $bookingInfo->booking_status     = 'STARTED';
                $bookingInfo->booking_start_time = $startTime;

                if($bookingInfo->save())
                {
                    $parentText     = $userInfo->name .' has started the job';
                    $parent         = User::find($bookingInfo->user_id);
                    $parentpayload  = [
                        'mtitle'    => '',
                        'mdesc'     => $parentText,
                        'parent_id' => $parent->id,
                        'booking_id' => $bookingInfo->id,
                        'sitter_id' => $userInfo->id,
                        'ntype'     => 'BOOKING_START'
                    ];

                    $storeParentNotification = [
                        'user_id'       => $parent->id,
                        'sitter_id'     => $userInfo->id,
                        'booking_id'    => $bookingInfo->id,
                        'to_user_id'    => $parent->id,
                        'description'   => $parentText
                    ];

                    access()->addNotification($storeParentNotification);

                    access()->sentPushNotification($parent, $parentpayload);

                    return $this->successResponse([
                        'success' => 'Booking Started by Sitter'
                    ], 'Booking Started by Sitter');
                }
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Booking!'
            ], 'No Booking Found !');
    }

    /**
     * Stop
     *
     * @param Request $request
     * @return json
     */
    public function stop(Request $request)
    {
        if($request->has('booking_id') && $request->has('booking_end_time'))
        {
            $userInfo       = $this->getAuthenticatedUser();
            $bookingInfo    = $this->repository->model->where([
                'id'                => $request->get('booking_id'),
                'sitter_id'         => $userInfo->id,
                'booking_status'    => 'STARTED'
            ])->first();

            if(isset($bookingInfo))
            {
                $stopTime = date('Y-m-d H:i:s', strtotime($request->get('booking_end_time')));
                $bookingInfo->booking_status     = 'COMPLETED';
                $bookingInfo->booking_end_time = $stopTime;

                if($bookingInfo->save())
                {
                    $perHour        = access()->getSitterPerHour($userInfo->id);
                    $hourdiff       = round((strtotime($bookingInfo->booking_end_time) - strtotime($bookingInfo->booking_start_time))/3600, 1);
                    $hourTotal      = abs($hourdiff * $perHour);
                    $parkingFees    = isset($bookingInfo->parking_fees) ? $bookingInfo->parking_fees : 0;

                    $inputData = [
                        'booking_id'    => $request->get('booking_id'),
                        'sitter_id'     => $userInfo->id,
                        'per_hour'      => $perHour,
                        'total_hour'    => $hourdiff,
                        'sub_total'     => $hourTotal,
                        'tax'           => 0,
                        'other_charges' => 0,
                        'parking_fees'  => $parkingFees,
                        'total'         => $parkingFees + ($hourdiff * $perHour),
                        'description'   => 'Test Mode - Payment'
                    ];

                    $parent         = User::find($bookingInfo->user_id);
                    $paymentInfo    = Payment::create($inputData);
                    $parentText     = $userInfo->name . ' has stopped the job';

                    $parentpayload  = [
                        'mtitle'    => '',
                        'mdesc'     => $parentText,
                        'parent_id' => $parent->id,
                        'booking_id' => $bookingInfo->id,
                        'sitter_id' => $userInfo->id,
                        'ntype'     => 'BOOKING_STOP'
                    ];

                    $storeParentNotification = [
                        'user_id'       => $userInfo->id,
                        'sitter_id'     => $userInfo->id,
                        'to_user_id'    => $parent->id,
                        'booking_id'    => $bookingInfo->id,
                        'description'   => $parentText
                    ];

                    access()->addNotification($storeParentNotification);
                     access()->sentPushNotification($parent, $parentpayload);


                    return $this->successResponse([
                        'success' => 'Booking Completed by Sitter'
                    ], 'Booking Completed by Sitter');
                }
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Booking!'
            ], 'No Booking Found !');
    }
}