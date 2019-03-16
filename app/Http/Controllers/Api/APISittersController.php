<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\SittersTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Sitters\EloquentSittersRepository;
use App\Repositories\Booking\EloquentBookingRepository;
use App\Models\Booking\Booking;
use App\Models\Sitters\Sitters;
use DateTime;
use App\Models\Babies\Babies;

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
        $items      = $paginate ? $this->repository->model->with('user')->where('vacation_mode', 0)->orderBy($orderBy, $order)->paginate($paginate)->items() : $this->repository->getAll($orderBy, $order);

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
        $minAge     = 0;
        $maxAge     = 100;
        $babyIds    = $request->has('babyIds') ? explode(",", $request->get('babyIds')) : [];

        if(isset($babyIds) && count($babyIds))
        {
            $babies = Babies::whereIn('id', $babyIds)->pluck('age')->toArray();

            if(isset($babies) && count($babies))
            {
                $minAge = min($babies);
                $maxAge = max($babies);
            }
        }

        /*$items      = $paginate ? $this->repository->model->with('user')->orderBy($orderBy, $order)->paginate($paginate)->items() : $this->repository->getAll($orderBy, $order);*/

        $items = $this->repository->model->where('age_start_range', '>=', $minAge)
        ->where('age_end_range', '<=', $maxAge)->get();

        $bookingRepo = new EloquentBookingRepository;

        if(isset($items) && count($items))
        {   
            $sitters = [];
            if($request->has('start_time') && $request->has('end_time'))
            {
                $input              = $request->all();
                $bookingEndDate     = $request->has('booking_end_date') ? $request->get('booking_end_date') : date('Y-m-d H:i:s');
                $bookingStartTime   = date('Y-m-d H:i:s', strtotime($input['booking_date'] . $input['start_time']));
                $bookingEndTime     = date('Y-m-d H:i:s', strtotime($bookingEndDate . $input['end_time']));
                $blockSitterIds     = [];

                foreach($items as $item)
                {
                    if(in_array($item->user_id, $blockSitterIds))
                    {
                        continue;
                    }

                    $startTime  = $bookingStartTime;
                    $endTime    = $bookingEndTime;

                    $query = $bookingRepo->model->where([
                        'sitter_id'  => $item->user_id,
                    ]);

                    if($startTime)
                    {
                        $query->where(function($q) use($startTime, $endTime)
                            {
                                $q->whereBetween('booking_start_time',  [$startTime, $endTime])
                                ->orWhereBetween('booking_end_time',  [$startTime, $endTime]);
                            });
                    }

                    $timeAllow = $query->first();

                    if(isset($timeAllow) && count($timeAllow))
                    {
                        $blockSitterIds[] = $item->user_id;
                        continue;
                    }

                    $sitters[] = $item;
                }
            }
            else
            {
                $sitters  = $items;
            }

            $itemsOutput = $this->sittersTransformer->transformCollection($sitters);

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
        if($request->has('sitter_id') && $request->get('sitter_id'))
        {
            $item = $this->repository->getById($request->get('sitter_id'));

            if(isset($item) && count($item))
            {
                $itemsOutput = $this->sittersTransformer->transform($item);

                return $this->successResponse($itemsOutput);
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Sitter!'
            ], 'No Sitter Found !');
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
            $items = $items->sortByDesc('booking_date');
            $itemsOutput = $this->sittersTransformer->pastBookingTransform($items);

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
    public function getBooking(Request $request)
    {
        if($request->has('booking_id'))
        {
            $bookingRepo    = new EloquentBookingRepository;
            $userInfo       = $this->getAuthenticatedUser();
            $item           = $bookingRepo->getSingleBooking($request->get('booking_id'));

            if(isset($item) && count($item))
            {
                $itemsOutput = $this->sittersTransformer->singleBookingTransform($item);

                return $this->successResponse($itemsOutput);
            }


        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Sitter Booking!'
            ], 'No Sitter Found or Invalid Input !');
    }

    /**
     * Add Timings Mode
     *
     * @param Request $request
     * @return json
     */
    public function addTimings(Request $request)
    {
        $userInfo       = $this->getAuthenticatedUser();
        $sitter         = Sitters::where('user_id', $userInfo->id)->first();

        if($sitter)
        {
            if($request->has('sitter_start_time'))
            {
                $sitter->sitter_start_time = date("H:i:s", strtotime($request->get('sitter_start_time')));
            }

            if($request->has('sitter_end_time'))
            {
                $sitter->sitter_end_time = date("H:i:s", strtotime($request->get('sitter_end_time')));
            }
        }

        if($sitter->save())
        {
            $message = "Updated Sitter Timings";

            return $this->successResponse([
                'success' => 'Sitter Timings Updated'
            ], $message);
        }


        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Sitter!'
            ], 'No Sitter Found or Invalid Input !');
    }

    /**
     * My Earnings
     *
     * @param Request $request
     * @return json
     */
    public function myEarnings(Request $request)
    {
        $userInfo       = $this->getAuthenticatedUser();
        $sitter         = Sitters::where('user_id', $userInfo->id)->first();
        $bookingRepo    = new EloquentBookingRepository;
        $sitterBookings = $bookingRepo->getSitterCompletedBookings($userInfo->id);

        if(isset($sitterBookings) && count($sitterBookings))
        {
            $result = $this->sittersTransformer->sitterEarningTransform($sitterBookings);

            return $this->successResponse($result);

        }
        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Sitter!'
            ], 'No Sitter Found or Invalid Input !');
    }
}