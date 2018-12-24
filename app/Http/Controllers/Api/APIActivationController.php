<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\ActivationTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Activation\EloquentActivationRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\Access\User\User;

class APIActivationController extends BaseApiController
{
    /**
     * Activation Transformer
     *
     * @var Object
     */
    protected $activationTransformer;

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
    protected $primaryKey = 'activationId';

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository                       = new EloquentActivationRepository();
        $this->activationTransformer = new ActivationTransformer();
    }

    /**
     * List of All Activation
     *
     * @param Request $request
     * @return json
     */
    public function index(Request $request)
    {
        $userInfo = $this->getAuthenticatedUser();

        $activationInfo = $this->repository->model->where([
            'user_id'           => $userInfo->id,
            'payment_status'    => 1,
            'status'            => 1,
        ])
        ->orderBy('id', 'DESC')
        ->first();

        if(isset($activationInfo) && count($activationInfo))
        {
            $itemsOutput = $this->activationTransformer->activateTransform($activationInfo);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'No Activation Found!'
            ], 'No Activation Found !');
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
            'plan_id'   => 'required',
            'token'     => 'required'
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
        $planId         = $request->get('plan_id');
        $token          = $request->get('token');
        $paymentStatus  = $this->repository->addPayment($planId, $token);

        if($paymentStatus)
        {
            return $this->successResponse([
                'success' => 'Plan Activated Successfully !'
            ], 'Payment Done Successfully ');
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
        if($request->has('user_id'))
        {
            $userId = $request->get('user_id');

            $activationInfo = $this->repository->model->where([
                'user_id'           => $userId,
                'payment_status'    => 1,
                'status'            => 1,
            ])
            ->orderBy('id', 'DESC')
            ->first();

            if(isset($activationInfo) && count($activationInfo))
            {
                $itemsOutput = $this->activationTransformer->activateTransform($items);

                return $this->successResponse($itemsOutput);
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'No Activation Found!'
            ], 'No Activation Found !');
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
                $responseData   = $this->activationTransformer->transform($itemData);

                return $this->successResponse($responseData, 'Activation is Edited Successfully');
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
                    'success' => 'Activation Deleted'
                ], 'Activation is Deleted Successfully');
            }
        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    /**
     * Get My Activation
     * 
     * @param Request $request
     * @return json
     */
    public function getMyActivation(Request $request)
    {
        $userInfo       = $this->getAuthenticatedUser();       
        $activationInfo = $this->repository->model->where([
            'user_id'           => $userInfo->id,
        ])
        ->with('plan')
        ->orderBy('id', 'DESC')
        ->get();

        if(isset($activationInfo) && count($activationInfo))
        {
            $itemsOutput = $this->activationTransformer->myActivationTransform($activationInfo);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'No Activation Found!'
            ], 'No Activation Found !');
    }
}