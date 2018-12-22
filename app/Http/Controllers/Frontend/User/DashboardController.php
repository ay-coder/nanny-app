<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\SearchRequest;
use Illuminate\Http\Request;
use App\Models\Access\User\User;
use App\Repositories\Sitters\EloquentSittersRepository;
use App\Repositories\Booking\EloquentBookingRepository;
use Carbon\Carbon;

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
        if(session()->has('find_sitter'))
        {
            $input = session('find_sitter');
        }
        else
        {
            return redirect()->route('frontend.user.parent.dashboard')->withFlashDanger('Something went wrong. Please try again.');
        }

        $isBooking = access()->isActiveBookingAvailable(access()->user()->id);

        if(isset($isBooking) && count($isBooking))
        {
            $bookingDate = Carbon::createFromFormat('d/m/Y',$input['booking_date'])->format('Y-m-d');
            $input['is_multiple'] = (count($input['baby_ids']) > 1) ? 1 : 0;
            $input['baby_id'] = $input['baby_ids'][0];
            $input['baby_ids'] = implode(",", $input['baby_ids']);
            $input['sitter_id'] = $request->sitter_id;
            $input              = array_merge($input, [
                'user_id'             => access()->user()->id,
                'booking_date'       => $bookingDate,
                'start_time'         => date('H:i:s', strtotime($input['start_time'])),
                'end_time'           => date('H:i:s', strtotime($input['end_time'])),
                'booking_status'     => 'REQUESTED',
                'parking_fees'       => isset($input['parking_fees']) ? $input['parking_fees'] : 0
            ]);

            $bookingRepository = new EloquentBookingRepository();
            $model = $bookingRepository->create($input);

            if($model)
            {
                $parent         = User::find($model->user_id);
                $parentText     = config('constants.NotificationText.PARENT.JOB_ADD');
                $sitterText     = config('constants.NotificationText.SITTER.JOB_ADD');
                $sitter         = User::find($model->sitter_id);
                $parentpayload  = [
                    'mtitle'    => '',
                    'mdesc'     => $parentText
                ];
                $sitterpayload  = [
                    'mtitle'    => '',
                    'mdesc'     => $sitterText
                ];

                $storeParentNotification = [
                    'user_id'       => $model->user_id,
                    'sitter_id'     => $model->sitter_id,
                    'booking_id'    => $model->id,
                    'to_user_id'    => $model->user_id,
                    'description'   => $parentText
                ];

                $storeSitterNotification = [
                    'user_id'       => $model->user_id,
                    'sitter_id'     => $model->sitter_id,
                    'booking_id'    => $model->id,
                    'to_user_id'    => $model->sitter_id,
                    'description'   => $sitterText
                ];

                // Notification
                access()->addNotification($storeSitterNotification);
                access()->sentPushNotification($sitter, $sitterpayload);

                $isBooking->allowed_bookings = $isBooking->allowed_bookings - 1;
                $isBooking->save();

                if(session()->has('find_sitter')){
                    session()->forget('find_sitter');
                }
                return redirect()->route('frontend.user.parent.dashboard')->withFlashSuccess('Booking is Created Successfully');
            } else {
                return redirect()->route('frontend.user.parent.dashboard')->withFlashDanger('There is a Problem in Booking.  Please try again.');
            }   
        }
        
        return redirect()->route('frontend.user.parent.dashboard')->withFlashDanger('Please purchase plan to Continue Booking.');
        
    }
}