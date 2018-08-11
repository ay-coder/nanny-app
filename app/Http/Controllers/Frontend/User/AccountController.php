<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Repositories\Notifications\EloquentNotificationsRepository;

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
    	return view('sitter.account');
    }

    /**
     * Parent Notification
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function parentNotification()
    {
    	$notifications = $this->repository->model->where('user_id', access()->user()->id)->with(['sitter'])->orderBy('id', 'DESC')->paginate(10);
    	return view('parent.notification', compact('notifications'));
    }

    /**
     * Sitter Notification
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function sitterNotification()
    {
    	$notifications = $this->repository->model->where('sitter_id', access()->user()->id)->with(['user'])->orderBy('id', 'DESC')->paginate(10);
    	return view('sitter.notification', compact('notifications'));
    }
}
