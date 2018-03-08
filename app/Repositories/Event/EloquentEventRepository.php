<?php namespace App\Repositories\Event;

use App\Models\Event\Event;
use App\Models\Access\User\User;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;

class EloquentEventRepository extends DbRepository implements EventRepositoryContract
{
	/**
	 * Event Model
	 * 
	 * @var Object
	 */
	public $model;

	/**
	 * Module Title
	 * 
	 * @var string
	 */
	public $moduleTitle = 'Event';

	/**
	 * Table Headers
	 *
	 * @var array
	 */
	public $tableHeaders = [
		'name' 			=> 'Event Name',
		'username' 		=> 'User Name',
		'title' 		=> 'Title',
		'start_date' 	=> 'Start Date',
		'end_date' 		=> 'End Date',
		'actions' 		=> 'Actions'
	];

	/**
	 * Table Columns
	 *
	 * @var array
	 */
	public $tableColumns = [
		'name' =>	[
			'data' 			=> 'name',
			'name' 			=> 'name',
			'searchable' 	=> true, 
			'sortable'		=> true
		],
		'username' => [
			'data' 			=> 'username',
			'name' 			=> 'username',
			'searchable' 	=> true, 
			'sortable'		=> true
		],
		'title' => [
			'data' 			=> 'title',
			'name' 			=> 'title',
			'searchable' 	=> true, 
			'sortable'		=> true
		],
		'start_date' => [
			'data' 			=> 'start_date',
			'name' 			=> 'start_date',
			'searchable' 	=> false, 
			'sortable'		=> false
		],
		'end_date' => [
			'data' 			=> 'end_date',
			'name' 			=> 'end_date',
			'searchable' 	=> false, 
			'sortable'		=> false
		],
		'actions' => [
			'data' 			=> 'actions',
			'name' 			=> 'actions',
			'searchable' 	=> false, 
			'sortable'		=> false
		]
	];

	/**
	 * Is Admin
	 * 
	 * @var boolean
	 */
	protected $isAdmin = false;

	/**
	 * Admin Route Prefix
	 * 
	 * @var string
	 */
	public $adminRoutePrefix = 'admin';

	/**
	 * Client Route Prefix
	 * 
	 * @var string
	 */
	public $clientRoutePrefix = 'frontend';

	/**
	 * Admin View Prefix
	 * 
	 * @var string
	 */
	public $adminViewPrefix = 'backend';

	/**
	 * Client View Prefix
	 * 
	 * @var string
	 */
	public $clientViewPrefix = 'frontend';

	/**
	 * Module Routes
	 * 
	 * @var array
	 */
	public $moduleRoutes = [
		'listRoute' 	=> 'event.index',
		'createRoute' 	=> 'event.create',
		'storeRoute' 	=> 'event.store',
		'editRoute' 	=> 'event.edit',
		'updateRoute' 	=> 'event.update',
		'deleteRoute' 	=> 'event.destroy',
		'dataRoute' 	=> 'event.get-list-data'
	];

	/**
	 * Module Views
	 * 
	 * @var array
	 */
	public $moduleViews = [
		'listView' 		=> 'event.index',
		'createView' 	=> 'event.create',
		'editView' 		=> 'event.edit',
		'deleteView' 	=> 'event.destroy',
	];

	/**
	 * Construct
	 *
	 */
	public function __construct()
	{
		$this->model 		= new Event;
		$this->userModel 	= new User;
	}

	/**
	 * Create Event
	 *
	 * @param array $input
	 * @return mixed
	 */
	public function create($input)
	{
		$input = $this->prepareInputData($input, true);
		$model = $this->model->create($input);

		if($model)
		{
			return $model;
		}

		return false;
	}	

	/**
	 * Update Event
	 *
	 * @param int $id
	 * @param array $input
	 * @return bool|int|mixed
	 */
	public function update($id, $input)
	{
		$model = $this->model->find($id);

		if($model)
		{
			$input = $this->prepareInputData($input);		
			
			return $model->update($input);
		}

		return false;
	}

	/**
	 * Destroy Event
	 *
	 * @param int $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function destroy($id)
	{
		$model = $this->model->find($id);
			
		if($model)
		{
			return $model->delete();
		}

		return  false;
	}

	/**
     * Get All
     *
     * @param string $orderBy
     * @param string $sort
     * @return mixed
     */
    public function getAll($orderBy = 'id', $sort = 'asc')
    {
        return $this->model->all();
    }

	/**
     * Get by Id
     *
     * @param int $id
     * @return mixed
     */
    public function getById($id = null)
    {
    	if($id)
    	{
    		return $this->model->find($id);
    	}
        
        return false;
    }   

    /**
     * Get Table Fields
     * 
     * @return array
     */
    public function getTableFields()
    {
    	return [
			$this->model->getTable().'.id as id',
			$this->model->getTable().'.name',
			$this->model->getTable().'.title',
			$this->model->getTable().'.start_date',
			$this->model->getTable().'.end_date',
			$this->userModel->getTable().'.name as username'
		];
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
    	return  $this->model->select($this->getTableFields())
    			->leftjoin($this->userModel->getTable(), $this->userModel->getTable().'.id', '=', $this->model->getTable().'.user_id')->get();
        
    }

    /**
     * Set Admin
     *
     * @param boolean $isAdmin [description]
     */
    public function setAdmin($isAdmin = false)
    {
    	$this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Prepare Input Data
     * 
     * @param array $input
     * @param bool $isCreate
     * @return array
     */
    public function prepareInputData($input = array(), $isCreate = false)
    {
    	if($isCreate)
    	{
    		$input = array_merge($input, ['user_id' => access()->user()->id]);
    	}


    	if(isset($input['start_date']))
    	{
    		$input['start_date'] = date('Y-m-d', strtotime($input['start_date']));
    	}

    	if(isset($input['end_date']))
    	{
    		$input['end_date'] = date('Y-m-d', strtotime($input['end_date']));
    	}

    	if(! isset($input['start_date']))
    	{
    		$input['start_date'] = date('Y-m-d');
    	}

    	if(! isset($input['end_date']))
    	{
    		$input['end_date'] = date('Y-m-d');
    	}

    	return $input;
    }

    /**
     * Get Table Headers
     * 
     * @return string
     */
    public function getTableHeaders()
    {
    	if($this->isAdmin)
    	{
    		return json_encode($this->setTableStructure($this->tableHeaders));
    	}

    	$clientHeaders = $this->tableHeaders;

    	unset($clientHeaders['username']);

    	return json_encode($this->setTableStructure($clientHeaders));
    }

	/**
     * Get Table Columns
     *
     * @return string
     */
    public function getTableColumns()
    {
    	if($this->isAdmin)
    	{
    		return json_encode($this->setTableStructure($this->tableColumns));
    	}

    	$clientColumns = $this->tableColumns;

    	unset($clientColumns['username']);
    	
    	return json_encode($this->setTableStructure($clientColumns));
    }
}