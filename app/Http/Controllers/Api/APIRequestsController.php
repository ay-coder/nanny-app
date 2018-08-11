<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\RequestsTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Requests\EloquentRequestsRepository;
use Illuminate\Support\Facades\Validator;

class APIRequestsController extends BaseApiController
{
    /**
     * Requests Transformer
     *
     * @var Object
     */
    protected $requestsTransformer;

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
    protected $primaryKey = 'requestsId';

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository                       = new EloquentRequestsRepository();
        $this->requestsTransformer = new RequestsTransformer();
    }

    /**
     * List of All Requests
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
            $itemsOutput = $this->requestsTransformer->transformCollection($items);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Requests!'
            ], 'No Requests Found !');
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
            'user_request'     => 'required'
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

        $input      = $request->all();
        $userInfo   = $this->getAuthenticatedUser();
        $input      = array_merge($input, ['user_id' => $userInfo->id ]);

        $model = $this->repository->create($input);

        if($model)
        {
            $responseData = $this->requestsTransformer->transform($model);

            return $this->successResponse($responseData, 'Requests is Created Successfully');
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
                $responseData = $this->requestsTransformer->transform($itemData);

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
                $responseData   = $this->requestsTransformer->transform($itemData);

                return $this->successResponse($responseData, 'Requests is Edited Successfully');
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
                    'success' => 'Requests Deleted'
                ], 'Requests is Deleted Successfully');
            }
        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }
}