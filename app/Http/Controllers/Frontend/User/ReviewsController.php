<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Repositories\Reviews\EloquentReviewsRepository;
use Illuminate\Http\Request;

/**
 * Class ReviewsController
 */
class ReviewsController extends Controller
{
    /**
     * PrimaryKey
     *
     * @var string
     */
    protected $primaryKey = 'review_id';
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
        $this->repository = new EloquentReviewsRepository();
    }

    /**
     * @return
     */
    public function index()
    {
        //
    }

    /**
     * Subscribe Plan
     * @param $planId
     * @return
     */
    public function create(Request $request)
    {
        $userInfo   = access()->user();
        $input      = $request->all();
        $input      = array_merge($input, ['user_id' => $userInfo->id ]);
        $model      = $this->repository->create($input);

        if($model)
        {
            return redirect()->route('frontend.user.parent.myappointment')->withFlashSuccess('Reviews is Created Successfully.');
        }

        return redirect()->back()->withInput()->withFlashDanger('Something went wrong !');
    }
}
