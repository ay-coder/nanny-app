<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Repositories\Plans\EloquentPlansRepository;

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

	/**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository = new EloquentPlansRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $plans = $this->repository->getAll('id', 'ASC');
        return view('parent.subscription', compact('plans'));
    }
}
