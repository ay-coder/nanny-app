<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\PaymentTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Payment\EloquentPaymentRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\Booking\Booking;
use App\Models\Payment\Payment;

class APIPaymentController extends BaseApiController
{
    /**
     * Payment Transformer
     *
     * @var Object
     */
    protected $paymentTransformer;

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
    protected $primaryKey = 'paymentId';

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository                       = new EloquentPaymentRepository();
        $this->paymentTransformer = new PaymentTransformer();
    }

    /**
     * List of All Payment
     *
     * @param Request $request
     * @return json
     */
    public function index(Request $request)
    {
        $paginate   = $request->get('paginate') ? $request->get('paginate') : false;
        $orderBy    = $request->get('orderBy') ? $request->get('orderBy') : 'id';
        $order      = $request->get('order') ? $request->get('order') : 'ASC';
        $items      = $paginate ? $this->repository->model->orderBy($orderBy, $order)->paginate($paginate)->items() : $this->repository->getAll($orderBy, $order);

        if(isset($items) && count($items))
        {
            $itemsOutput = $this->paymentTransformer->transformCollection($items);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Payment!'
            ], 'No Payment Found !');
    }

    /**
     * Create
     *
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id'     => 'required',
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

        $userInfo       = $this->getAuthenticatedUser();
        $booking        = new Booking;
        $bookingInfo    = $booking->where([
            'id'            => $request->get('booking_id'),
            'sitter_id'     => $userInfo->id,
            'booking_status' => 'COMPLETED'
        ])->first();

        if(isset($bookingInfo) && $bookingInfo->id)
        {       
            $perHour  = access()->getSitterPerHour();
            $hourdiff = round((strtotime($bookingInfo->booking_end_time) - strtotime($bookingInfo->booking_start_time))/3600, 1);
            $input    = $request->all();
            $hourTotal   = abs($hourdiff * $perHour);
            $parkingFees = $input['parking_fees'];
            $inputData = [
                'booking_id'    => $input['booking_id'],
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

            $model = $this->repository->create($inputData);
            
            if($model)
            {
                $responseData = $this->paymentTransformer->transform($model);

                return $this->successResponse($responseData, 'Payment is Created Successfully');
            }
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
                $responseData = $this->paymentTransformer->transform($itemData);

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
                $responseData   = $this->paymentTransformer->transform($itemData);

                return $this->successResponse($responseData, 'Payment is Edited Successfully');
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
                    'success' => 'Payment Deleted'
                ], 'Payment is Deleted Successfully');
            }
        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    /**
     * Add Payment
     * 
     * @param Request $request
     */
    public function addPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id'    => 'required',
            'payment_id'    => 'required',
            'token'         => 'required'
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

        $userInfo       = $this->getAuthenticatedUser();
        $paymentId      = $request->get('payment_id');
        $bookingId      = $request->get('booking_id');
        $token          = $request->get('token');
        $paymentStatus  = $this->repository->addPayment($paymentId, $token);

        if($paymentStatus)
        {
            return $this->successResponse([
                'success' => 'Payment Done Successfully !'
            ], 'Payment Done Successfully ');
        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Payment Failed !');
    }
}