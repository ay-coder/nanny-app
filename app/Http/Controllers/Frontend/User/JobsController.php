<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\Booking;
use App\Repositories\Sitters\EloquentSittersRepository;
use App\Repositories\Booking\EloquentBookingRepository;
use Carbon\Carbon;
use App\Models\Access\User\User;
use App\Models\Payment\Payment;

/**
 * Class JobsController.
 */
class JobsController extends Controller
{
    /**
     * Repository
     *
     * @var Object
     */
    protected $repository;
    protected $sitterRepository;

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository = new EloquentBookingRepository();
        $this->sitterRepository = new EloquentSittersRepository();
    }
    /**
     * Sitter jobs
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $session = array();
        $calenderRecords    = Booking::with(['user', 'sitter', 'baby', 'payment'])->where('sitter_id', access()->user()->id)->orderBy('id', 'desc')->get();
        if (count($calenderRecords) > 0) {
            foreach ($calenderRecords as $key => $calenderRecord) {
                if(!empty($calenderRecord->booking_date) && !empty($calenderRecord->start_time) && !empty($calenderRecord->end_time)) {
                    $date = Carbon::parse($calenderRecord->booking_date)->format('Y-d-m');

                    $booking_start_time     = $date . 'T' . $calenderRecord->start_time;
                    $booking_end_time       = $date . 'T' . $calenderRecord->end_time;
                    $session[] = [
                        'start' => $booking_start_time,
                    'end'   => $booking_end_time,
                    'title' => $calenderRecord['user']->name];
                }
            }
            $calenderData = json_encode($session, JSON_NUMERIC_CHECK);
        } else {
            $session['start'] = '';
            $session['end'] = '';
            $session['title'] = '';
            $calenderData = json_encode($session, JSON_NUMERIC_CHECK);
        }

        $currentJobs = $this->repository->getSitterActiveBookings(access()->user()->id);
        $pastJobs    = $this->repository->getSitterPastBookings(access()->user()->id);
        $pastJobs    = $pastJobs->sortByDesc('booking_date');

        return view('sitter.my-jobs', compact('calenderData', 'currentJobs', 'pastJobs', 'calenderRecords'));
    }

    /* Cancel
     *
     * @param Request $request
     * @return json
     */
    public function cancel($bookingId)
    {
        if($bookingId)
        {
            $userInfo       = access()->user();
            $bookingInfo    = $this->repository->model->where([
                'id'        => $bookingId,
                'sitter_id' => $userInfo->id
            ])->whereNotIn('booking_status', ['STARTED', 'COMPLETED', 'CANCELED'])->first();

            if(isset($bookingInfo))
            {
                $bookingInfo->booking_status = 'CANCELED';
                if($bookingInfo->save())
                {
                    $parentText     = config('constants.NotificationText.PARENT.JOB_CANCEL');
                    $sitterText     = config('constants.NotificationText.SITTER.JOB_CANCEL');
                    $parent         = User::find($bookingInfo->user_id);

                    $storeParentNotification = [
                        'user_id'       => $parent->id,
                        'sitter_id'     => $userInfo->id,
                        'booking_id'    => $bookingInfo->id,
                        'to_user_id'    => $parent->id,
                        'description'   => $parentText
                    ];

                    $storeSitterNotification = [
                        'user_id'       => $parent->id,
                        'sitter_id'     => $userInfo->id,
                        'booking_id'    => $bookingInfo->id,
                        'to_user_id'    => $userInfo->id,
                        'description'   => $sitterText
                    ];

                    access()->addNotification($storeParentNotification);
                    access()->addNotification($storeSitterNotification);

                    return redirect()->route('frontend.user.sitter.myjobs')->withFlashSuccess('Booking cancelled Successfully.');
                }
            }
        }

        return redirect()->route('frontend.user.sitter.myjobs')->withFlashDanger('Unable to find Booking!');
    }

    /**
     * Start
     *
     * @param Request $request
     * @return json
     */
    public function start($bookingId)
    {
        if($bookingId)
        {
            $userInfo       = access()->user();
            $bookingInfo    = $this->repository->model->where([
                'id'                => $bookingId,
                'sitter_id'         => $userInfo->id,
                'booking_status'    => 'ACCEPTED'
            ])->first();

            if(isset($bookingInfo))
            {
                $startTime = date('Y-m-d H:i:s', strtotime(Carbon::now()));
                $bookingInfo->booking_status     = 'STARTED';
                $bookingInfo->booking_start_time = $startTime;

                if($bookingInfo->save())
                {
                    $parentText     = config('constants.NotificationText.PARENT.JOB_START');
                    $sitterText     = config('constants.NotificationText.SITTER.JOB_START');
                    $parent         = User::find($bookingInfo->user_id);

                    $storeParentNotification = [
                        'user_id'       => $parent->id,
                        'sitter_id'     => $userInfo->id,
                        'booking_id'    => $bookingInfo->id,
                        'to_user_id'    => $parent->id,
                        'description'   => $parentText
                    ];

                    $storeSitterNotification = [
                        'user_id'       => $parent->id,
                        'sitter_id'     => $userInfo->id,
                        'booking_id'    => $bookingInfo->id,
                        'to_user_id'    => $userInfo->id,
                        'description'   => $sitterText
                    ];

                    access()->addNotification($storeParentNotification);
                    access()->addNotification($storeSitterNotification);

                    return redirect()->route('frontend.user.sitter.myjobs')->withFlashSuccess('Job Started Successfully.');
                }
            }
        }

        return redirect()->route('frontend.user.sitter.myjobs')->withFlashDanger('Unable to find Booking!');
    }

    /**
     * Stop
     *
     * @param Request $request
     * @return json
     */
    public function stop($bookingId)
    {
        if($bookingId)
        {
            $userInfo       = access()->user();
            $bookingInfo    = $this->repository->model->where([
                'id'                => $bookingId,
                'sitter_id'         => $userInfo->id,
                'booking_status'    => 'STARTED'
            ])->first();

            if(isset($bookingInfo))
            {
                $stopTime = date('Y-m-d H:i:s', strtotime(Carbon::now()));
                $bookingInfo->booking_status     = 'COMPLETED';
                $bookingInfo->booking_end_time = $stopTime;

                if($bookingInfo->save())
                {
                    $perHour        = access()->getSitterPerHour($userInfo->id);
                    $hourdiff       = round((strtotime($bookingInfo->booking_end_time) - strtotime($bookingInfo->booking_start_time))/3600, 1);
                    $hourTotal      = abs($hourdiff * $perHour);
                    $parkingFees    = isset($bookingInfo->parking_fees) ? $bookingInfo->parking_fees : 0;

                    $inputData = [
                        'booking_id'    => $bookingId,
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

                    $parent         = User::find($bookingInfo->user_id);
                    $paymentInfo    = Payment::create($inputData);
                    $parentText     = config('constants.NotificationText.PARENT.JOB_STOP');
                    $sitterText     = config('constants.NotificationText.SITTER.JOB_STOP');

                    $storeParentNotification = [
                        'user_id'       => $parent->id,
                        'sitter_id'     => $userInfo->id,
                        'to_user_id'    => $parent->id,
                        'booking_id'    => $bookingInfo->id,
                        'description'   => $parentText
                    ];

                    $storeSitterNotification = [
                        'user_id'       => $parent->id,
                        'sitter_id'     => $userInfo->id,
                        'to_user_id'    => $userInfo->id,
                        'booking_id'    => $bookingInfo->id,
                        'description'   => $sitterText
                    ];

                    access()->addNotification($storeParentNotification);
                    access()->addNotification($storeSitterNotification);

                    return redirect()->route('frontend.user.sitter.myjobs')->withFlashSuccess('Job Stopped Successfully.');
                }
            }
        }

        return redirect()->route('frontend.user.sitter.myjobs')->withFlashDanger('Unable to find Booking!');
    }
}