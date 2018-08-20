<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Repositories\Notifications\EloquentNotificationsRepository;
use App\Repositories\Booking\EloquentBookingRepository;
use App\Models\Sitters\Sitters;
use Illuminate\Http\Request;

/**
 * Class AccountController.
 */
class AccountController extends Controller
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
		$this->repository = new EloquentNotificationsRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.account');
    }

    /**
     * Parent Account
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function parentIndex()
    {
        return view('parent.account')->withUser(access()->user());
    }

    /**
     * Sitter Account
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sitterIndex()
    {
    	return view('sitter.account')->withUser(access()->user());
    }

    /**
     * Parent Notification
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function parentNotification()
    {
    	$notifications = $this->repository->model->where('user_id', access()->user()->id)->where('to_user_id', access()->user()->id)->with(['sitter'])->orderBy('id', 'DESC')->paginate(10);
    	return view('parent.notification', compact('notifications'));
    }

    /**
     * Sitter Notification
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function sitterNotification()
    {
    	$notifications = $this->repository->model->where('sitter_id', access()->user()->id)->where('to_user_id', access()->user()->id)->with(['user', 'sitter', 'booking', 'booking.payment'])->orderBy('id', 'DESC')->paginate(10);
    	return view('sitter.notification', compact('notifications'));
    }

    /**
     * Sitter Earnings
     *
     * @param Request $request
     * @return json
     */
    public function sitterEarnings()
    {
        $userInfo       = access()->user();
        $sitter         = Sitters::where('user_id', $userInfo->id)->first();
        $bookingRepo    = new EloquentBookingRepository;
        $sitterBookings = $bookingRepo->getSitterCompletedBookings($userInfo->id);

        if(isset($sitterBookings) && count($sitterBookings) > 0) {
            return view('sitter.earning', compact('sitterBookings'));
        } else {
            $sitterBookings = array();
            return view('sitter.earning', compact('sitterBookings'));
        }
    }

    public function vacationMode()
    {
        $user = access()->user();
        if(isset($user->sitter->id)) {
            $vacationMode = $user->sitter;
            return view('sitter.vacation', compact('vacationMode'));
        } else {
            return redirect()->back()->withFlashDanger('Sitter not found.');
        }
    }

    /**
     * Vacation Mode
     *
     * @param Request $request
     * @return json
     */
    public function changeVacationMode(Request $request)
    {
        if($request->has('vacation_mode'))
        {
            $userInfo = access()->user();
            $sitter   = Sitters::where('user_id', $userInfo->id)->first();

            $sitter->vacation_mode = $request->get('vacation_mode');

            if($sitter->save())
            {
                $message = $request->get('vacation_mode') ? 'On Vacation - Enjoy Holidays!' : 'Back to work !';

                return redirect()->route('frontend.user.sitter.vacation')->withFlashSuccess('Vacation Mode Updated Successfully. ' . $message);
            }

        }
        return redirect()->back()->withFlashDanger('Please select Vacation Mode');
    }
}
