<?php namespace App\Http\Controllers\Backend\Messages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Messages\EloquentMessagesRepository;
use Html;
use App\Models\Access\User\User;

/**
 * Class AdminMessagesController
 */
class AdminMessagesController extends Controller
{
    /**
     * Messages Repository
     *
     * @var object
     */
    public $repository;

    /**
     * Create Success Message
     *
     * @var string
     */
    protected $createSuccessMessage = "Messages Created Successfully!";

    /**
     * Edit Success Message
     *
     * @var string
     */
    protected $editSuccessMessage = "Messages Edited Successfully!";

    /**
     * Delete Success Message
     *
     * @var string
     */
    protected $deleteSuccessMessage = "Messages Deleted Successfully";

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository = new EloquentMessagesRepository;
    }

    /**
     * Messages Listing
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->repository->setAdmin(true)->getModuleView('listView'))->with([
            'repository' => $this->repository
        ]);
    }

    /**
     * Messages View
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
     * Messages Store
     *
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $this->repository->create($request->all());

        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->createSuccessMessage);
    }

    /**
     * Messages Edit
     *
     * @return \Illuminate\View\View
     */
    public function edit($id, Request $request)
    {
        $item = $this->repository->findOrThrowException($id);

        $messages = $this->repository->model->where([
            'from_user_id'  => $item->from_user_id,
            'to_user_id'    => $item->to_user_id
        ])->orWhere([
            'from_user_id'  => $item->to_user_id,
            'to_user_id'    => $item->from_user_id
        ])->orderBy('id', 'desc')->get();

        return view($this->repository->setAdmin(true)->getModuleView('editView'))->with([
            'item'          => $item,
            'messages'      => $messages,
            'repository'    => $this->repository
        ]);
    }

    /**
     * Messages Show
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
     * Messages Update
     *
     * @return \Illuminate\View\View
     */
    public function update($id, Request $request)
    {   
        $status = $this->repository->model->create([
            'from_user_id'  => 1,
            'to_user_id'    => $request->get('to_user_id'),
            'message'       => $request->get('message')
        ]);

        $toUser     = User::find($request->get('to_user_id'));
        $text       = 'Admin has sent you message';
        $payloadData = [
            'mtitle'    => '',
            'mdesc'     => $text,
            'ntype'     => 'NEW_MESSAGE'
        ];

        $storeNotification = [
            'user_id'       => 1,
            'to_user_id'    => $request->get('to_user_id'),
            'description'   => $text,
            'ntype'         => 'NEW_MESSAGE'
        ];

        access()->addNotification($storeNotification);

        access()->sentPushNotification($toUser, $payloadData);

        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess('Replied Successfully!');
    }

    /**
     * Messages Destroy
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
            ->addColumn('from_user_id', function ($item) {
                return $item->from_user->name;
            })
            ->addColumn('to_user_id', function ($item) {
                return $item->to_user->name;
            })
            ->addColumn('image', function ($item) {
                return Html::image('/uploads/messages/'.$item->image, 'image', ['width' => 50, 'height' => 50]);
                //URL::to('/').;
            })
            ->addColumn('actions', function ($item) {
                return $item->admin_action_buttons;
            })
            ->make(true);
    }
}