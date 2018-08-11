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
}
