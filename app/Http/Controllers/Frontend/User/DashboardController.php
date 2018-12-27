<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\SearchRequest;
use Illuminate\Http\Request;
use App\Models\Access\User\User;
use App\Repositories\Sitters\EloquentSittersRepository;
use App\Repositories\Booking\EloquentBookingRepository;
use Carbon\Carbon;
use App\Models\Messages\Messages;

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
        $input = $request->all();
        $repository = new EloquentSittersRepository();
        session(['find_sitter' => $request->except('_token')]);
        $sitters = $repository->model->with(['user', 'reviews', 'reviews.user'])->where('vacation_mode', 0)->orderBy('id', 'asc')->paginate(6);

        return view('parent.sitterlisting', compact('sitters', 'input'));
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
           
            if(count($input['baby_ids']) == 1)
            {
                $input['is_multiple']   = 0;
                $input['baby_id']       = $input['baby_ids'][0];
                unset($input['baby_ids']);
            }
            else
            {
                $input['is_multiple'] = 1;
                $input['baby_id']       = $input['baby_ids'][0];
                $babyIds = $input['baby_ids'];
                unset($babyIds[0]);
                $input['baby_ids']    = implode(",", $babyIds);
            }

            $input['sitter_id'] = $request->sitter_id;
            $input              = array_merge($input, [
                'user_id'             => access()->user()->id,
                'booking_date'       => $bookingDate,
                'booking_type'       => isset($input['booking_type']) ? $input['booking_type'] : 0,
                'is_pet'            => isset($input['is_pet']) ? $input['is_pet'] : 0,
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

    public function addMessage(Request $request)
    {
        $user       = access()->user();
        $message    = $request->get('message-text');
        $imageName  = '';
        $isImage    = 0;

        if($request->file('attachment'))
        {
            $imageName  = rand(11111, 99999) . '_message.' . $request->file('attachment')->getClientOriginalExtension();
            if(strlen($request->file('attachment')->getClientOriginalExtension()) > 0)
            {
                $request->file('attachment')->move(base_path() . '/public/uploads/messages/', $imageName);
                $isImage = 1;
            }
        }

        $status = Messages::create([
            'from_user_id'  => $user->id,
            'to_user_id'    => 1,
            'image'         => $imageName,
            'message'       => $message,
            'is_image'      => $isImage
        ]);

        if($status)
        {
            return redirect()->route('frontend.user.parent.subscription')->withFlashSuccess('Message Send Successfully.'); 
        }

        return redirect()->route('frontend.user.parent.subscription')->withFlashDanger('Please try again! Something went Wrong.');
    }
}