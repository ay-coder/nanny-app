<?php namespace App\Http\Controllers\Backend\Booking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Booking\EloquentBookingRepository;
use App\Models\Access\User\User;
use App\Models\Sitters\Sitters;
use App\Models\Babies\Babies;

/**
 * Class AdminBookingController
 */
class AdminBookingController extends Controller
{
    /**
     * Booking Repository
     *
     * @var object
     */
    public $repository;

    /**
     * Create Success Message
     *
     * @var string
     */
    protected $createSuccessMessage = "Booking Created Successfully!";

    /**
     * Edit Success Message
     *
     * @var string
     */
    protected $editSuccessMessage = "Booking Edited Successfully!";

    /**
     * Delete Success Message
     *
     * @var string
     */
    protected $deleteSuccessMessage = "Booking Deleted Successfully";

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository = new EloquentBookingRepository;
    }

    /**
     * Booking Listing
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
     * Booking View
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $sitterIds  = Sitters::where('vacation_mode', 0)->pluck('user_id')->toArray();
        $parents    = User::whereNotIn('id', $sitterIds)->where('id', '!=', 1)->pluck('name', 'id')->toArray();
        $sitters    = User::whereIn('id', $sitterIds)->pluck('name', 'id')->toArray();

        return view($this->repository->setAdmin(true)->getModuleView('createView'))->with([
            'repository' => $this->repository,
            'sitters'    => $sitters,
            'parents'    => $parents
        ]);
    }

    /**
     * Booking Store
     *
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $status = $this->repository->create($request->all());

        if($status == false)
        {
            return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashDanger("Please Select Another Sitter to Continue Booking!");
        }

        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->createSuccessMessage);
    }

    /**
     * Booking Edit
     *
     * @return \Illuminate\View\View
     */
    public function edit($id, Request $request)
    {
        $item       = $this->repository->findOrThrowException($id);
        $sitterIds  = Sitters::where('vacation_mode', 0)->pluck('user_id')->toArray();
        $parents    = User::whereNotIn('id', $sitterIds)->pluck('name', 'id')->toArray();
        $sitters    = User::whereIn('id', $sitterIds)->pluck('name', 'id')->toArray();
        $allBabies  = Babies::where('parent_id', $item->user_id)->pluck('title', 'id')->toArray();
        $mulipleBabies     = false;
        $selectedBaby[] = $item->baby_id;

        if($item->is_multiple == 1)
        {
            $mulipleBabies = Babies::whereIn('id', explode(',', $item->baby_ids))->get();
            if(isset($mulipleBabies) && count($mulipleBabies))
            {
                foreach($mulipleBabies as $mulipleBaby)   
                {
                    $selectedBaby[] = $mulipleBaby->id;
                }
            }
        }

        //dd( $selectedBaby);

        return view($this->repository->setAdmin(true)->getModuleView('editView'))->with([
            'item'          => $item,
            'repository'    => $this->repository,
            'parents'       => $parents,
            'sitters'       => $sitters,
            'allBabies'     => $allBabies,
            'selectedBabies'=> $selectedBaby,

        ]);
    }

    /**
     * Booking Show
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
     * Booking Update
     *
     * @return \Illuminate\View\View
     */
    public function update($id, Request $request)
    {
        $status = $this->repository->update($id, $request->all());

        if($status == false)
        {
            return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashDanger("Please choose other Sitter to Continue!");            
        }

        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->editSuccessMessage);
    }

    /**
     * Booking Destroy
     *
     * @return \Illuminate\View\View
     */
    public function destroy($id)
    {
        $status = $this->repository->destroy($id);

        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->deleteSuccessMessage);
    }

    /**
     * Cancel
     * 
     * @param Request $request
     * @return JSON
     */
    public function cancel(Request $request)
    {
        if($request->has('bookingId'))
        {
            $status = $this->repository->cancelByAdmin($request->get('bookingId'));

            if($status)
            {
                return response()->json([
                    'status' => true
                ]);
            }
        }

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Get Babies
     * 
     * @param Request $request
     * @return JSON
     */
    public function getBabies(Request $request)
    {
        if($request->has('parentId'))
        {
            $babies = Babies::where('parent_id', $request->get('parentId'))->select('title', 'id')->get();
            
            if(isset($babies) && count($babies))
            {
                return response()->json([
                    'status' => true,
                    'babies' => $babies
                ]);
            }
        }

        return response()->json([
            'status' => false
        ]);
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
            ->addColumn('sitter_id', function ($item) {
                return $item->sitter->name;
            })
            ->addColumn('baby_id', function ($item) {
                return $item->baby->title;
            })
            ->addColumn('actions', function ($item) {
                $html = '';
                if(in_array($item->booking_status, ['PENDING', 'REQUESTED']))
                {
                    $html = '<a href="javascript:void(0);" class="cancel-appointment" title="Cancel" data-id="'. $item->id .'"><i class="fa fa-2x fa-close"></i></a>';
                }
                return $html . $item->admin_action_buttons;
            })
            ->make(true);
    }
}