<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\EventTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Event\EloquentEventRepository;

class APIEventsController extends BaseApiController 
{   
    /**
     * Event Transformer
     * 
     * @var Object
     */
    protected $eventTransformer;

    /**
     * Repository
     * 
     * @var Object
     */
    protected $repository;

    /**
     * __construct
     * 
     * @param EventTransformer $eventTransformer
     */
    public function __construct(EloquentEventRepository $repository, EventTransformer $eventTransformer)
    {
        parent::__construct();

        $this->repository       = $repository;
        $this->eventTransformer = $eventTransformer;
    }

    /**
     * List of All Events
     * 
     * @param Request $request
     * @return json
     */
    public function index(Request $request) 
    {
        $userInfo   = $this->getApiUserInfo();
        $events     = $this->repository->getAll()->toArray();

        if($events && count($events))
        {
            $eventsData     = $this->eventTransformer->transformCollection($events);
            $responseData   = array_merge($userInfo, ['events' => $eventsData]);

            return $this->successResponse($responseData);
        }

        $error = [
            'reason' => 'Unable to find Events!'
        ];

        return $this->setStatusCode(400)->failureResponse($error, 'No Events Found !');
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
            $responseData = $this->eventTransformer->createEvent($model);

            return $this->successResponse($responseData, 'Event is Created Successfully');
        }

        $error = [
            'reason' => 'Invalid Inputs'
        ];

        return $this->setStatusCode(400)->failureResponse($error, 'Something went wrong !');
    }

    /**
     * Edit
     * 
     * @param Request $request
     * @return string
     */
    public function edit(Request $request)
    {
        $eventId    = (int) $request->event_id;
        $model      = $this->repository->update($eventId, $request->all());

        if($model)
        {
            $eventData      = $this->repository->getById($eventId);
            $responseData   = $this->eventTransformer->transform($eventData);

            return $this->successResponse($responseData, 'Event is Edited Successfully');
        }

        $error = [
            'reason' => 'Invalid Inputs'
        ];

        return $this->setStatusCode(400)->failureResponse($error, 'Something went wrong !');
    }

    /**
     * Delete
     * 
     * @param Request $request
     * @return string
     */
    public function delete(Request $request)
    {
        $eventId = (int) $request->event_id;

        if($eventId)
        {
            $status = $this->repository->destroy($eventId);

            if($status)
            {
                $responseData = [
                    'success' => 'Event Deleted'
                ];

                return $this->successResponse($responseData, 'Event is Deleted Successfully');
            }
        }

        $error = [
            'reason' => 'Invalid Inputs'
        ];

        return $this->setStatusCode(404)->failureResponse($error, 'Something went wrong !');
    }
}
