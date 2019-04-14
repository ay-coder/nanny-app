<?php namespace App\Http\Controllers\Backend\SitterEarning;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\SitterEarning\EloquentSitterEarningRepository;
use App\Models\Access\User\User;
use PDF;

/**
 * Class AdminSitterEarningController
 */
class AdminSitterEarningController extends Controller
{
    /**
     * SitterEarning Repository
     *
     * @var object
     */
    public $repository;

    /**
     * Create Success Message
     *
     * @var string
     */
    protected $createSuccessMessage = "SitterEarning Created Successfully!";

    /**
     * Edit Success Message
     *
     * @var string
     */
    protected $editSuccessMessage = "SitterEarning Edited Successfully!";

    /**
     * Delete Success Message
     *
     * @var string
     */
    protected $deleteSuccessMessage = "SitterEarning Deleted Successfully";

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository = new EloquentSitterEarningRepository;
    }

    /**
     * SitterEarning Listing
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->has('download') && $request->has('download') == 1)
        {

            $selected_array = [
                'id', 'Sitter', 'Parent Name', 'Date', 'In Time', 'Out Time', 'Amount'
            ];

            $data = $this->repository->getForDataTable();
            $Array_data = [];

            foreach($data as $d)
            {
                $bDate = date('m-d-Y', strtotime($d->booking_date));

                $Array_data[] = [
                    $d->id,
                    $d->sitter->name,
                    $d->user->name,
                    $bDate,
                    $d->start_time,
                    $d->end_time,
                    $d->payment->per_hour * $d->payment->total_hour + $d->payment->parking_fees + $d->payment->tip
                ];
            }


            $Filename = 'sitterearning-report.csv';
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
     * SitterEarning View
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
     * SitterEarning Store
     *
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $this->repository->create($request->all());

        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->createSuccessMessage);
    }

    /**
     * SitterEarning Edit
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
     * SitterEarning Show
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
     * SitterEarning Update
     *
     * @return \Illuminate\View\View
     */
    public function update($id, Request $request)
    {
        $status = $this->repository->update($id, $request->all());

        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->editSuccessMessage);
    }

    /**
     * SitterEarning Destroy
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
            ->addColumn('sitter_id', function ($item) {
                return isset($item->sitter) ? $item->sitter->name : 'N/A';
            })
            ->addColumn('booking_date', function ($item) {
                return date('m-d-Y', strtotime($item->booking_date));
            })
            ->addColumn('amount', function ($item) {
                return isset($item->payment) ? $item->payment->per_hour * $item->payment->total_hour + $item->payment->parking_fees + $item->payment->tip : 'N/A';
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

            $pdf = PDF::loadView('backend.sitterearning.pdf', [ 'data' => $data]);
            $pdfPath = public_path() . '/pdf/sitter-earning-report.pdf';
            if($pdf->save($pdfPath))
            {
                return response()->json([
                    'status' => true,
                    'path'   => url('/pdf/sitter-earning-report.pdf')
                ]);
            }
        }


        session([
            'sitterEarningFilter' => $request->get('userId'),
            'startDate'          => $request->get('startDate'),
            'endDate'            => $request->get('endDate')
        ]);
        
        return response()->json([
            'status' => true
        ]);
    }
    
}