<?php namespace App\Http\Controllers\Backend\Subscription;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Subscription\EloquentSubscriptionRepository;
use App\Models\Access\User\User;
use PDF;

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
    public function index(Request $request)
    {   
        if($request->has('download') && $request->has('download') == 1)
        {

            $selected_array = [
                'id', 'Parent Name', 'Subscription Plan', 'Allowed Bookings', 'Amount'
            ];

            $data = $this->repository->getForDataTable();
            $Array_data = [];

            foreach($data as $d)
            {
                $Array_data[] = [
                    $d->id,
                    $d->username,
                    $d->plan_title,
                    $d->allowed_bookings,
                    $d->plan->amount
                ];
            }


            $Filename = 'subscription-report.csv';
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
        if($request->has('printPDF') && $request->get('printPDF') == 1)
        {
            $data = $this->repository->getForDataTable();
            //dd(PDF::loadHTML('test')->save('myfile.pdf'));

            $pdf = PDF::loadView('backend.subscription.pdf', [ 'data' => $data]);
            $pdfPath = public_path() . '/pdf/subscription-report.pdf';
            if($pdf->save($pdfPath))
            {
                return response()->json([
                    'status' => true,
                    'path'   => url('/pdf/subscription-report.pdf')
                ]);
            }
        }

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