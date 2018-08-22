<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Repositories\Booking\EloquentBookingRepository;
use App\Repositories\Payment\EloquentPaymentRepository;
use Illuminate\Http\Request;
use App\Models\Booking\Booking;
use Carbon\Carbon;

/**
 * Class AccountController.
 */
class AppointmentController extends Controller
{
	/**
     * Repository
     *
     * @var Object
     */
    protected $repository;
    protected $paymentRepository;

	/**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository = new EloquentBookingRepository();
        $this->paymentRepository = new EloquentPaymentRepository();
    }

    /**
     * Parent index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $upcoming = $this->repository->getAllParentActiveBookings('booking_date', 'ASC');
        $previous = $this->repository->getAllPast('booking_date', 'ASC');

        return view('parent.appointment', compact('upcoming', 'previous'));
    }

    /**
     * Delete Appointment/Booking
     * @param  $id
     * @return
     */
    public function delete($id)
    {
        $status = $this->repository->destroy($id);

        return redirect()->route('frontend.user.parent.myappointment')->withFlashSuccess('Appointment is Deleted Successfully');
    }

    /**
     * Accept
     *
     * @param Request $request
     * @return json
     */
    public function accept($bookingId)
    {
        if($bookingId)
        {
            $userInfo       = access()->user();
            $bookingInfo    = $this->repository->model->where([
                'id'                => $bookingId,
                'sitter_id'         => $userInfo->id,
                'booking_status'    => 'REQUESTED'
            ])->first();

            if(isset($bookingInfo))
            {
                $bookingInfo->booking_status = 'ACCEPTED';
                if($bookingInfo->save())
                {
                    return redirect()->route('frontend.user.sitter.notification')->withFlashSuccess('Booking accepted Successfully');
                }
            }
        }

        return redirect()->route('frontend.user.sitter.notification')->withFlashDanger('Unable to find Booking!');
    }

    /* Reject
     *
     * @param Request $request
     * @return json
     */
    public function reject($bookingId)
    {
        if($bookingId)
        {
            $userInfo       = access()->user();
            $bookingInfo    = $this->repository->model->where([
                'id'                => $bookingId,
                'sitter_id'         => $userInfo->id,
                'booking_status'    => 'REQUESTED'
            ])->first();

            if(isset($bookingInfo))
            {
                $bookingInfo->booking_status = 'REJECTED';
                if($bookingInfo->save())
                {
                    return redirect()->route('frontend.user.sitter.notification')->withFlashSuccess('Booking rejected Successfully');
                }
            }
        }

        return redirect()->route('frontend.user.sitter.notification')->withFlashDanger('Unable to find Booking!');
    }

    /**
     * get Single Booking
     *
     * @param Request $request
     * @return json
     */
    public function getBooking($bookingId)
    {
        if($bookingId)
        {
            $booking        = $this->repository->getSingleBooking($bookingId);

            if(isset($booking) && count($booking))
            {
                return view('sitter.earning-detail', compact('booking'));
            }
        }

        return redirect()->back()->withFlashDanger('Unable to find Sitter Booking!');
    }

    /**
     * Previous Parent Bookings
     * @param  $bookingId
     * @return
     */
    public function previousParentBooking($bookingId)
    {
        if($bookingId)
        {
            $booking        = $this->repository->getSingleBooking($bookingId);
            if(isset($booking) && count($booking))
            {
                if($booking->is_multiple == 1 && isset($item->baby_ids))
                {
                    $babyIds    = array_values(explode(',', $item->baby_ids));
                    $babies     = Babies::whereIn('id', $babyIds)->get();

                    if(isset($babies) && count($babies))
                    {
                        return view('parent.previous-appointment', compact('booking', 'babies'));
                    }
                } else {
                    $babies[] = $booking['baby'];
                    return view('parent.previous-appointment', compact('booking', 'babies'));
                }
            }
        }

        return redirect()->back()->withFlashDanger('Unable to find Details of booking!');
    }

    /**
     * Previous Parent Bookings
     * @param  $bookingId
     * @return
     */
    public function ParentBookingdetails($bookingId)
    {
        if($bookingId)
        {
            $booking        = $this->repository->getSingleBooking($bookingId);
            if(isset($booking) && count($booking))
            {
                if($booking->is_multiple == 1 && isset($item->baby_ids))
                {
                    $babyIds    = array_values(explode(',', $item->baby_ids));
                    $babies     = Babies::whereIn('id', $babyIds)->get();

                    if(isset($babies) && count($babies))
                    {
                        return view('parent.appointment-detail', compact('booking', 'babies'));
                    }
                } else {
                    $babies[] = $booking['baby'];
                    return view('parent.appointment-detail', compact('booking', 'babies'));
                }
            }
        }

        return redirect()->back()->withFlashDanger('Unable to find Details of booking!');
    }

    public function bookingPayment(Request $request)
    {
        $userInfo       = access()->user();
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
                return redirect()->roite('frontend.user.parent.myappointment')->withFlashSuccess('Payment is Created Successfully');
            }
        }

        return redirect()->back()->withFlashDanger('Something went wrong !');
    }
}
