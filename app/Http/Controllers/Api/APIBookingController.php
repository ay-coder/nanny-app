<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\BookingTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Booking\EloquentBookingRepository;
use Illuminate\Support\Facades\Validator;

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
}