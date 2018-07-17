<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\SittersTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Sitters\EloquentSittersRepository;
use App\Repositories\Booking\EloquentBookingRepository;
use App\Models\Booking\Booking;
use App\Models\Sitters\Sitters;

class APISittersController extends BaseApiController
{
    /**
     * Sitters Transformer
     *
     * @var Object
     */
    protected $sittersTransformer;

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
    protected $primaryKey = 'sitter_id';

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository                       = new EloquentSittersRepository();
        $this->sittersTransformer = new SittersTransformer();
    }

    /**
     * List of All Sitters
     *
     * @param Request $request
     * @return json
     */
    public function index(Request $request)
    {
        $paginate   = $request->get('paginate') ? $request->get('paginate') : false;
        $orderBy    = $request->get('orderBy') ? $request->get('orderBy') : 'id';
        $order      = $request->get('order') ? $request->get('order') : 'ASC';
        $items      = $paginate ? $this->repository->model->with('user')->orderBy($orderBy, $order)->paginate($paginate)->items() : $this->repository->getAll($orderBy, $order);

        if(isset($items) && count($items))
        {
            $itemsOutput = $this->sittersTransformer->transformCollection($items);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Sitters!'
            ], 'No Sitters Found !');
    }

    public function findSitters(Request $request)
    {
        // #ToDo
        // need to filter sitter by is_pet ( 0 / 1 )
        $paginate   = $request->get('paginate') ? $request->get('paginate') : false;
        $orderBy    = $request->get('orderBy') ? $request->get('orderBy') : 'id';
        $order      = $request->get('order') ? $request->get('order') : 'ASC';
        $items      = $paginate ? $this->repository->model->with('user')->orderBy($orderBy, $order)->paginate($paginate)->items() : $this->repository->getAll($orderBy, $order);

        if(isset($items) && count($items))
        {
            $itemsOutput = $this->sittersTransformer->transformCollection($items);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Sitters!'
            ], 'No Sitters Found !');
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
            $responseData = $this->sittersTransformer->transform($model);

            return $this->successResponse($responseData, 'Sitters is Created Successfully');
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
                $responseData = $this->sittersTransformer->transform($itemData);

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
                $responseData   = $this->sittersTransformer->transform($itemData);

                return $this->successResponse($responseData, 'Sitters is Edited Successfully');
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
                    'success' => 'Sitters Deleted'
                ], 'Sitters is Deleted Successfully');
            }
        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    /**
     * List of All Bookings
     *
     * @param Request $request
     * @return json
     */
    public function getMyCalendar(Request $request)
    {
        $userInfo   = $this->getAuthenticatedUser();
        $items      = Booking::with(['user', 'sitter', 'baby'])->where('sitter_id', $userInfo->id)->get();


        if(isset($items) && count($items))
        {
            $itemsOutput = $this->sittersTransformer->calendarTransform($items);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Sitters!'
            ], 'No Sitters Found !');
    }

    /**
     * Vacation Mode
     *
     * @param Request $request
     * @return json
     */
    public function vacationMode(Request $request)
    {
        if($request->has('vacation_mode'))
        {
            $userInfo = $this->getAuthenticatedUser();
            $sitter   = Sitters::where('user_id', $userInfo->id)->first();

            $sitter->vacation_mode = $request->get('vacation_mode');
            
            if($sitter->save())
            {
                $message = $request->get('vacation_mode') ? 'On Vacation - Enjoy Holidays!' : 'Back to work !';

                return $this->successResponse([
                    'success' => 'Vacation Mode Updated'
                ], $message);
            }

        }
        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Sitter or Invalid Input!'
            ], 'No Sitter Found or Invalid Input !');
    }

    /**
     * Vacation Mode
     *
     * @param Request $request
     * @return json
     */
    public function activeBookings(Request $request)
    {
        $bookingRepo    = new EloquentBookingRepository;
        $userInfo       = $this->getAuthenticatedUser();
        $items          = $bookingRepo->getSitterActiveBookings($userInfo->id);

        
        if(isset($items) && count($items))
        {
            $itemsOutput = $this->sittersTransformer->calendarTransform($items);

            return $this->successResponse($itemsOutput);   
        }
            

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Sitter Bookings!'
            ], 'No Sitter Found or Invalid Input !');
    }

    /**
     * Vacation Mode
     *
     * @param Request $request
     * @return json
     */
    public function pastBookings(Request $request)
    {
        $bookingRepo    = new EloquentBookingRepository;
        $userInfo       = $this->getAuthenticatedUser();
        $items          = $bookingRepo->getSitterPastBookings($userInfo->id);

        
        if(isset($items) && count($items))
        {
            $itemsOutput = $this->sittersTransformer->calendarTransform($items);

            return $this->successResponse($itemsOutput);   
        }
            

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Sitter Bookings!'
            ], 'No Sitter Found or Invalid Input !');
    }
}