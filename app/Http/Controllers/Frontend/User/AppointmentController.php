<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Repositories\Booking\EloquentBookingRepository;

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

	/**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository = new EloquentBookingRepository();
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
     * @param  [type] $id
     * @return [type]
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
            $userInfo       = access()->user();
            $booking        = $this->repository->getSingleBooking($bookingId);

            if(isset($booking) && count($booking))
            {
                return view('sitter.earning-detail', compact('booking'));
            }
        }

        return redirect()->back()->withFlashDanger('Unable to find Sitter Booking!');
    }
}
