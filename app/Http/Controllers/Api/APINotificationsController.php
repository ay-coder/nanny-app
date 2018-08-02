<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\NotificationsTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Notifications\EloquentNotificationsRepository;

class APINotificationsController extends BaseApiController
{
    /**
     * Notifications Transformer
     *
     * @var Object
     */
    protected $notificationsTransformer;

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
    protected $primaryKey = 'notification_id';

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository                       = new EloquentNotificationsRepository();
        $this->notificationsTransformer = new NotificationsTransformer();
    }

    /**
     * List of All Notifications
     *
     * @param Request $request
     * @return json
     */
    public function index(Request $request)
    {
        $userInfo   = $this->getAuthenticatedUser();
        $paginate   = $request->get('paginate') ? $request->get('paginate') : false;
        $orderBy    = $request->get('orderBy') ? $request->get('orderBy') : 'id';
        $order      = $request->get('order') ? $request->get('order') : 'ASC';
        $items      = $paginate ? $this->repository->model->where('user_id', $userInfo->id)->with(['user', 'sitter', 'booking', 'booking.payment'])->orderBy($orderBy, $order)->paginate($paginate)->items() : $this->repository->getAll($userInfo->id, $orderBy, $order);

        if(isset($items) && count($items))
        {
            $itemsOutput = $this->notificationsTransformer->transformCollection($items);

            $this->repository->markReadAll($userInfo->id);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Notifications!'
            ], 'No Notifications Found !');
    }


    public function sitterNotification(Request $request)
    {
        $userInfo   = $this->getAuthenticatedUser();
        $paginate   = $request->get('paginate') ? $request->get('paginate') : false;
        $orderBy    = $request->get('orderBy') ? $request->get('orderBy') : 'id';
        $order      = $request->get('order') ? $request->get('order') : 'ASC';
        $items      = $paginate ? $this->repository->model->where('sitter_id', $userInfo->id)->with(['user', 'sitter', 'booking', 'booking.payment'])->orderBy($orderBy, $order)->paginate($paginate)->items() : $this->repository->getAllSitter($userInfo->id, $orderBy, $order);

        if(isset($items) && count($items))
        {

            $itemsOutput = $this->notificationsTransformer->transformCollection($items);

            $this->repository->markReadAll($userInfo->id);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Notifications!'
            ], 'No Notifications Found !');
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
            $responseData = $this->notificationsTransformer->transform($model);

            return $this->successResponse($responseData, 'Notifications is Created Successfully');
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
                $responseData = $this->notificationsTransformer->transform($itemData);

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
                $responseData   = $this->notificationsTransformer->transform($itemData);

                return $this->successResponse($responseData, 'Notifications is Edited Successfully');
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
                    'success' => 'Notifications Deleted'
                ], 'Notifications is Deleted Successfully');
            }
        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }
}