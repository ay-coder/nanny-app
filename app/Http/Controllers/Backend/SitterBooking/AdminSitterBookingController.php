<?php namespace App\Http\Controllers\Backend\SitterBooking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\SitterBooking\EloquentSitterBookingRepository;
use PDF;
use App\Models\Access\User\User;

/**
 * Class AdminSitterBookingController
 */
class AdminSitterBookingController extends Controller
{
    /**
     * SitterBooking Repository
     *
     * @var object
     */
    public $repository;

    /**
     * Create Success Message
     *
     * @var string
     */
    protected $createSuccessMessage = "SitterBooking Created Successfully!";

    /**
     * Edit Success Message
     *
     * @var string
     */
    protected $editSuccessMessage = "SitterBooking Edited Successfully!";

    /**
     * Delete Success Message
     *
     * @var string
     */
    protected $deleteSuccessMessage = "SitterBooking Deleted Successfully";

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository = new EloquentSitterBookingRepository;
    }

    /**
     * SitterBooking Listing
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->has('download') && $request->has('download') == 1)
        {

            $selected_array = [
                'id', 'Sitter Name', 'No of Completed Bookings'
            ];

            $data = $this->repository->getForDataTable();
            $Array_data = [];

            foreach($data as $d)
            {
                $bookingCount = isset($d->sitter_completed_bookings)  ? count($d->sitter_completed_bookings) : 0 ;

                $Array_data[] = [
                    $d->id,
                    $d->user->name,
                    $bookingCount
                ];
            }


            $Filename = 'sitter-booking-report.csv';
            header('Content-Type: text/csv; charset=utf-8');
            Header('Content-Type: application/force-download');
            header('Content-Disposition: attachment; filename='.$Filename.'');
            // create a file pointer connected to the output stream
            $output = fopen('php://output', 'w');
            fputcsv($output, $selected_array);
            foreach ($Array_data as $row){
                fputcsv($output, $row);
            }
            fclose($output);

            return;
        }

        $users = User::where('id', '!=', 1)->where('user_type', 2)->get();
        $users = $users->pluck('name', 'id')->toArray();

        return view($this->repository->setAdmin(true)->getModuleView('listView'))->with([
            'repository' => $this->repository,
            'allUsers'   => $users
        ]);
    }

    /**
     * SitterBooking View
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
     * SitterBooking Store
     *
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $this->repository->create($request->all());

        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->createSuccessMessage);
    }

    /**
     * SitterBooking Edit
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
     * SitterBooking Show
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
     * SitterBooking Update
     *
     * @return \Illuminate\View\View
     */
    public function update($id, Request $request)
    {
        $status = $this->repository->update($id, $request->all());

        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->editSuccessMessage);
    }

    /**
     * SitterBooking Destroy
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
            ->addColumn('user_id', function ($item) {
                return isset($item->user) ? $item->user->name : 'N/A';
            })
            ->addColumn('booking_count', function ($item) {
                return isset($item->sitter_completed_bookings) ? count($item->sitter_completed_bookings) : 0;
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
        if($request->has('printPDF') && $request->get('printPDF') == 1)
        {
            $data = $this->repository->getForDataTable();
            //dd(PDF::loadHTML('test')->save('myfile.pdf'));

            $pdf = PDF::loadView('backend.sitterbooking.pdf', [ 'data' => $data]);
            $pdfPath = public_path() . '/pdf/sitter-booking-report.pdf';
            if($pdf->save($pdfPath))
            {
                return response()->json([
                    'status' => true,
                    'path'   => url('/pdf/sitter-booking-report.pdf')
                ]);
            }
        }

        session([
            'sitterBookingFilter' => $request->get('userId'),
            'startDate'          => $request->get('startDate'),
            'endDate'            => $request->get('endDate')
        ]);
        
        return response()->json([
            'status' => true
        ]);
    }
}