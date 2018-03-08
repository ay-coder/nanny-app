<?php

namespace App\Http\Controllers\Frontend\Event;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Event\EloquentEventRepository;

/**
 * Class EventController
 *
 * @author Anuj Jaha
 */
class EventController extends Controller
{
	/**
	 * Event Repository
	 * 
	 * @var object
	 */
	public $repository;

	/**
	 * __construct
	 * 
	 * @param EloquentEventRepository $eventRepository
	 */
	public function __construct(EloquentEventRepository $eventRepository)
	{
		$this->repository = $eventRepository;
	}

    /**
     * Event Listing 
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->repository->getModuleView('listView'))->with(['repository' => $this->repository]);
    }

    /**
     * Event View
     * 
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view($this->repository->getModuleView('createView'))->with(['repository' => $this->repository]);
    }

    /**
     * Store View
     * 
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $this->repository->create($request->all());

        return redirect()->route($this->repository->getActionRoute('listRoute'))->withFlashSuccess('Event is Created Successfully !');
    }

    /**
     * Event View
     * 
     * @return \Illuminate\View\View
     */
    public function edit($id, Request $request)
    {
        $event = $this->repository->findOrThrowException($id);

        return view($this->repository->getModuleView('editView'))->with([
            'item'          => $event,
            'repository'    => $this->repository
        ]);
    }

    /**
     * Event Update
     * 
     * @return \Illuminate\View\View
     */
    public function update($id, Request $request)
    {
        $status = $this->repository->update($id, $request->all());
        
        return redirect()->route($this->repository->getActionRoute('listRoute'))->withFlashSuccess('Event is Edited Successfully !');
    }

    /**
     * Event Update
     * 
     * @return \Illuminate\View\View
     */
    public function destroy($id)
    {
        $status = $this->repository->destroy($id);
        
        return redirect()->route($this->repository->getActionRoute('listRoute'))->withFlashSuccess('Event is Deleted Successfully !');
    }

  	/**
     * Get Table Data
     *
     * @return json|mixed
     */
    public function getTableData()
    {
        return Datatables::of($this->repository->getForDataTable())
		    ->escapeColumns(['name', 'sort'])
            ->escapeColumns(['username', 'sort'])
            ->escapeColumns(['title', 'sort'])
            ->addColumn('start_date', function ($event) {
                return date('m-d-Y', strtotime($event->start_date));
            })
		    ->escapeColumns(['start_date', 'sort'])
		    ->escapeColumns(['end_date', 'sort'])
		    ->addColumn('actions', function ($event) {
                return $event->action_buttons;
            })
		    ->make(true);
    }
}
