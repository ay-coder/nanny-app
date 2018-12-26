<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\PlansTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Plans\EloquentPlansRepository;
use App\Repositories\Activation\EloquentActivationRepository;

class APIPlansController extends BaseApiController
{
    /**
     * Plans Transformer
     *
     * @var Object
     */
    protected $plansTransformer;

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
    protected $primaryKey = 'plansId';

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository                       = new EloquentPlansRepository();
        $this->plansTransformer = new PlansTransformer();
    }

    /**
     * List of All Plans
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
            $repo           = new EloquentActivationRepository;
            $userInfo       = $this->getAuthenticatedUser();       
            $activationInfo = $repo->model->where([
                'user_id'           => $userInfo->id,
            ])
            ->with('plan')
            ->orderBy('id', 'DESC')
            ->get();
            
            $totalBooking = 0;

            if(isset($items) && count($items))
            {
                foreach($activationInfo as $activation)
                {
                    $totalBooking   = $totalBooking + $activation->allowed_bookings;
                }
            }

            $itemsOutput = $this->plansTransformer->transformCollection($items);
            $response = [
                'plans'             => $itemsOutput,
                'allowed_bookings'  => $totalBooking
            ];

            return $this->successResponse($response);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Plans!'
            ], 'No Plans Found !');
    }

    /**
     * Create
     *
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $model = $this->repository->create($request->all());

        if($model)
        {
            $responseData = $this->plansTransformer->transform($model);

            return $this->successResponse($responseData, 'Plans is Created Successfully');
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
                $responseData = $this->plansTransformer->transform($itemData);

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
                $responseData   = $this->plansTransformer->transform($itemData);

                return $this->successResponse($responseData, 'Plans is Edited Successfully');
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
                    'success' => 'Plans Deleted'
                ], 'Plans is Deleted Successfully');
            }
        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }
}