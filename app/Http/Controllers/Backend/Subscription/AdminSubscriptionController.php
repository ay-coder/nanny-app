<?php namespace App\Http\Controllers\Backend\Subscription;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Subscription\EloquentSubscriptionRepository;
use App\Models\Access\User\User;

/**
 * Class AdminSubscriptionController
 */
class AdminSubscriptionController extends Controller
{
    /**
     * Subscription Repository
     *
     * @var object
     */
    public $repository;

    /**
     * Create Success Message
     *
     * @var string
     */
    protected $createSuccessMessage = "Subscription Created Successfully!";

    /**
     * Edit Success Message
     *
     * @var string
     */
    protected $editSuccessMessage = "Subscription Edited Successfully!";

    /**
     * Delete Success Message
     *
     * @var string
     */
    protected $deleteSuccessMessage = "Subscription Deleted Successfully";

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository = new EloquentSubscriptionRepository;
    }

    /**
     * Subscription Listing
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::where('id', '!=', 1)->where('user_type', 1)->get();
        $users = $users->pluck('name', 'id')->toArray();

        return view($this->repository->setAdmin(true)->getModuleView('listView'))->with([
            'repository' => $this->repository,
            'allUsers'   => $users
        ]);
    }

    /**
     * Subscription View
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view($this->repository->setAdmin(true)->getModuleView('createView'))->with([
            'repository' => $this->repository
        ]);
    }

    /**
     * Subscription Store
     *
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $this->repository->create($request->all());

        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->createSuccessMessage);
    }

    /**
     * Subscription Edit
     *
     * @return \Illuminate\View\View
     */
    public function edit($id, Request $request)
    {
        $item = $this->repository->findOrThrowException($id);

        return view($this->repository->setAdmin(true)->getModuleView('editView'))->with([
            'item'          => $item,
            'repository'    => $this->repository
        ]);
    }

    /**
     * Subscription Show
     *
     * @return \Illuminate\View\View
     */
    public function show($id, Request $request)
    {
        $item = $this->repository->findOrThrowException($id);

        return view($this->repository->setAdmin(true)->getModuleView('editView'))->with([
            'item'          => $item,
            'repository'    => $this->repository
        ]);
    }


    /**
     * Subscription Update
     *
     * @return \Illuminate\View\View
     */
    public function update($id, Request $request)
    {
        $status = $this->repository->update($id, $request->all());

        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->editSuccessMessage);
    }

    /**
     * Subscription Destroy
     *
     * @return \Illuminate\View\View
     */
    public function destroy($id)
    {
        $status = $this->repository->destroy($id);

        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->deleteSuccessMessage);
    }

    /**
     * Get Table Data
     *
     * @return json|mixed
     */
    public function getTableData()
    {
        return Datatables::of($this->repository->getForDataTable())
            ->escapeColumns(['id', 'sort'])
            ->addColumn('amount', function ($item) {
                return isset($item->plan) ? $item->plan->amount : 'N/A';
            })
            ->make(true);
    }

    /**
     * Subscription Listing
     *
     * @return \Illuminate\View\View
     */
    public function filter(Request $request)
    {
        session([
            'subscriptionFilter' => $request->get('userId'),
            'startDate'          => $request->get('startDate'),
            'endDate'            => $request->get('endDate')
        ]);
        
        return response()->json([
            'status' => true
        ]);
    }
}