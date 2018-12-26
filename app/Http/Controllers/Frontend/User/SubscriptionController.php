<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Repositories\Plans\EloquentPlansRepository;
use App\Repositories\Activation\EloquentActivationRepository;
use Illuminate\Http\Request;

/**
 * Class AccountController.
 */
class SubscriptionController extends Controller
{
	/**
     * Repository
     *
     * @var Object
     */
    protected $repository;
    protected $activationRepository;

	/**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository = new EloquentPlansRepository();
        $this->activationRepository = new EloquentActivationRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $plans = $this->repository->getAll('id', 'ASC');
        $activationInfo = $this->activationRepository->model->where([
            'user_id'           => access()->user()->id,
            'payment_status'    => 1,
            'status'            => 1,
        ])->where('allowed_bookings', '>', 0)
        ->orderBy('id', 'DESC')
        ->with(['plan'])
        ->first();

        return view('parent.subscription', compact('plans', 'activationInfo'));
    }

    /**
     * Subscribe Plan
     * @param $planId
     * @return
     */
    public function subscribePlan(Request $request)
    {
        $planId = $request->plan_id;
        $token = $request->stripeToken;
        if(!empty($planId) && !empty($token))
        {
            $paymentStatus  = $this->activationRepository->addPayment($planId, $token);
            return redirect()->route('frontend.user.parent.subscription')->withFlashSuccess('Plan Activated Successfully');
        }

        return redirect()->route('frontend.user.parent.subscription')->withFlashDanger('Please select Plan for subscription');
    }
}
