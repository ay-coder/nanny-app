<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\SearchRequest;
use Illuminate\Http\Request;
use App\Models\Access\User\User;
use App\Repositories\Sitters\EloquentSittersRepository;
use App\Repositories\Booking\EloquentBookingRepository;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * Parent Dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function parentIndex()
    {
        if(session()->has('find_sitter')){
            session()->forget('find_sitter');
        }
        $userObj = new User;
        $user = $userObj->with('babies')->where('id', access()->user()->id)->first();
        return view('parent.index', compact('user'));
    }

    /**
     * Search Sitter
     * @param  Request $request
     * @return [type]
     */
    public function searchSitters(SearchRequest $request)
    {
        $repository = new EloquentSittersRepository();
        session(['find_sitter' => $request->except('_token')]);
        $sitters = $repository->model->with(['user', 'reviews', 'reviews.user'])->where('vacation_mode', 0)->orderBy('id', 'asc')->paginate(6);

        return view('parent.sitterlisting', compact('sitters'));
    }

    /**
     * Find Sitter
     * @param $id
     * @return
     */
    public function findSitter($id)
    {
        $sitterRepository  = new EloquentSittersRepository();
        $bookingRepository = new EloquentBookingRepository();
        $sitter            = $sitterRepository->model->with(['user', 'reviews', 'reviews.user'])->where('user_id', $id)->first();
        $upcoming          = $bookingRepository->getAllParentActiveBookings('booking_date', 'ASC');

        return view('parent.sitterprofile', compact('sitter', 'upcoming', 'id'));
    }

    /**
     * Book Sitter
     * @param  Request $request
     * @return
     */
    public function bookSitter(Request $request)
    {
        if(session()->has('find_sitter')){
            $input = session('find_sitter');
        } else {
            return redirect()->route('frontend.user.parent.dashboard')->withFlashDanger('Something went wrong. Please try again.');
        }
        $input['is_multiple'] = (count($input['baby_ids']) > 1) ? 1 : 0;
        $input['baby_id'] = $input['baby_ids'][0];
        $input['baby_ids'] = implode(",", $input['baby_ids']);
        $input['sitter_id'] = $request->sitter_id;

        $bookingStartTime   = date('Y-m-d H:i:s', strtotime($input['booking_date'] . $input['start_time']));
        $bookingEndTime     = date('Y-m-d H:i:s', strtotime($input['booking_date'] . $input['end_time']));
        $input              = array_merge($input, [
            'user_id'            => access()->user()->id,
            'booking_date'       => date('Y-m-d', strtotime($input['booking_date'])),
            'start_time'         => date('H:i:s', strtotime($input['start_time'])),
            'end_time'           => date('H:i:s', strtotime($input['end_time'])),
            'booking_start_time' => $bookingStartTime,
            'booking_end_time'   => $bookingEndTime,
            'booking_status'     => 'REQUESTED',
            'parking_fees'       => isset($input['parking_fees']) ? $input['parking_fees'] : 0
        ]);

        $bookingRepository = new EloquentBookingRepository();
        $model = $bookingRepository->create($input);

        if($model)
        {
            if(session()->has('find_sitter')){
                session()->forget('find_sitter');
            }
            return redirect()->route('frontend.user.parent.dashboard')->withFlashSuccess('Booking is Created Successfully');
        } else {
            return redirect()->route('frontend.user.parent.dashboard')->withFlashDanger('There is a Problem in Booking.  Please try again.');
        }
    }
	/**
     * Sitter Dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sitterIndex()
    {
        return view('sitter.index');
    }
}