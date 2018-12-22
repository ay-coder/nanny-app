<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Repositories\Booking\EloquentBookingRepository;
use App\Repositories\Payment\EloquentPaymentRepository;
use App\Repositories\Reviews\EloquentReviewsRepository;
use Illuminate\Http\Request;
use App\Models\Booking\Booking;
use App\Http\Requests\Frontend\User\PaymentRequest;
use Carbon\Carbon;
use App\Models\Access\User\User;

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
    protected $reviewRepository;

	/**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository = new EloquentBookingRepository();
        $this->paymentRepository = new EloquentPaymentRepository();
        $this->reviewRepository = new EloquentReviewsRepository();
    }

    /**
     * Parent index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $upcoming = $this->repository->getAllParentActiveBookings('booking_date', 'ASC');
        $previous = $this->repository->getAllPast('booking_date', 'ASC');
        $reviews = $this->reviewRepository->getMySubmittedReviews(['is_user' => access()->user()->id]);

        return view('parent.appointment', compact('upcoming', 'previous', 'reviews'));
    }

    /**
     * Delete Appointment/Booking
     * @param  $id
     * @return
     */
    public function delete($id)
    {
        $status = $this->repository->destroy($id);

        access()->restoreSingleBooking(access()->user()->id);
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
                    $parentText     = config('constants.NotificationText.PARENT.JOB_ACCEPT');
                    $sitterText     = config('constants.NotificationText.SITTER.JOB_ACCEPT');
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

                    return redirect()->back()->withFlashSuccess('Booking accepted Successfully');
                }
            }
        }

        return redirect()->back()->withFlashDanger('Unable to find Booking!');
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
                    $parentText     = config('constants.NotificationText.PARENT.JOB_REJECT');
                    $sitterText     = config('constants.NotificationText.SITTER.JOB_REJECT');
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

                    return redirect()->back()->withFlashSuccess('Booking rejected Successfully');
                }
            }
        }

        return redirect()->back()->withFlashDanger('Unable to find Booking!');
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

    /**
     * Booking Payment
     * @param  Request $request
     * @return
     */
    public function bookingPayment(PaymentRequest $request)
    {
        $tipAmount      = $request->get('tip') ? $request->get('tip') : 0;
        $userInfo       = access()->user();
        $paymentId      = $request->get('payment_id');
        $bookingId      = $request->get('booking_id');
        $token          = $request->get('stripeToken');
        $tip            = (float) $tipAmount;
        $paymentStatus  = $this->paymentRepository->addPayment($paymentId, $token, $tip);

        if($paymentStatus)
        {
            return redirect()->route('frontend.user.parent.myappointment')->withFlashSuccess('Payment Done Successfully !');
        }

        return redirect()->back()->withFlashDanger('Payment Failed ! Please try again.');
    }
}
