<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\BookingTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Booking\EloquentBookingRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment\Payment;

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
        $orderBy    = $request->get('orderBy') ? $request->get('orderBy') : 'id';
        $order      = $request->get('order') ? $request->get('order') : 'ASC';
        $items      = $paginate ? $this->repository->model->with(['user', 'sitter', 'baby'])->orderBy($orderBy, $order)->paginate($paginate)->items() : $this->repository->getAll($orderBy, $order);

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
        $paginate   = $request->get('paginate') ? $request->get('paginate') : false;
        $orderBy    = $request->get('orderBy') ? $request->get('orderBy') : 'id';
        $order      = $request->get('order') ? $request->get('order') : 'ASC';
        $items      = $paginate ? $this->repository->model->whereIn('booking_status', ['COMPLETED'])->with(['user', 'sitter', 'baby'])->orderBy($orderBy, $order)->paginate($paginate)->items() : $this->repository->getAllPast($orderBy, $order);

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
        $input              = $request->all();
        $bookingStartTime   = date('Y-m-d H:i:s', strtotime($input['booking_date'] . $input['start_time']));
        $bookingEndTime     = date('Y-m-d H:i:s', strtotime($input['booking_date'] . $input['end_time']));
        $input              = array_merge($input, ['user_id' => $userInfo->id,
            'booking_date'      => date('Y-m-d', strtotime($input['booking_date'])),
            'booking_start_time' => $bookingStartTime,
            'booking_end_time'  => $bookingEndTime,
            'booking_status'    => 'REQUESTED'
        ]);

        $model = $this->repository->create($input);

        if($model)
        {
            $responseData = $this->bookingTransformer->transform($model);

            return $this->successResponse($responseData, 'Booking is Created Successfully');
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
                'id'                => $request->get('booking_id'),
                'sitter_id'         => $userInfo->id
            ])->whereNotIn('booking_status', ['STARTED', 'COMPLETED', 'CANCELED'])->first();

            if(isset($bookingInfo))
            {
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
                    $parkingFees    = $request->has('parking_fees') ? $request->get('parking_fees') : 0;

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

                    $paymentInfo = Payment::create($inputData);

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