<?php namespace App\Repositories;

/**
 * Abstract Class DbRepository
 *
 * @author Justin Bevan justin@smokerschoiceusa.com
 * @package FTX\Repositories
 */

use App\Exceptions\GeneralException;

Abstract class DbRepository
{
	/**
	 * Find Or Throw Exception
	 *
	 * @param $id
	 * @param array $relations
	 * @return mixed
	 * @throws GeneralException
	 */
    public function findOrThrowException($id, $relations = array())
    {
        if(is_int($id) && !is_null($this->model->find($id)))
        {
            $this->model->find($id);
        }

        try
        {
            $model = $this->model->findHashed($id, $relations);
        }
        catch(DataNotFoundException $e)
        {
            throw new GeneralException(trans('exceptions.backend.not_found'));
        }

        if($model)
        {
           return $model;
        }

        throw new GeneralException(trans('exceptions.backend.not_found'));
    }

    /**
     * Get Paginated
     *
     * @param $per_page
     * @param string $active
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getPaginated($per_page, $active = '', $order_by = 'id', $sort = 'asc')
    {
    	if($active)
    	{
	        return $this->model->where('status', $active)
	            ->orderBy($order_by, $sort)
	            ->paginate($per_page);
	    }
	    else
	    {
	    	return $this->model->orderBy($order_by, $sort)
	            ->paginate($per_page);
	    }
    }

    /**
     * Get All Records
     *
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAll($order_by = 'id', $sort = 'asc')
    {
        return $this->model->orderBy($order_by, $sort)->get();
    }

    /**
     * Destroy Item
     *
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id)
    {
        if($this->model->where('ID', '=', $id)->delete())
        {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.delete_error'));
    }

    /**
     * Select All
     *
     * @param string $columns
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function selectAll($columns='*', $order_by = 'id', $sort = 'asc')
    {
        return $this->model->select($columns)->orderBy($order_by, $sort)->get();
    }

    /**
     * Set DateTimeFormat
     *
     * @param mixed $input
     * @param mixed $field
     * @param string $format
     * @return bool|string
     */
    public function setDateTimeFormat($input = null, $field = null, $format = 'Y-m-d')
    {
        if(isset($input[$field]))
        {
            return date($format, strtotime($input[$field]));
        }

        return false;
    }

    /**
     * Get Module Routes
     * 
     * @return object
     */
    public function getModuleRoutes()
    {
        return (object) $this->moduleRoutes;
    }

    /**
     * Get Route
     * 
     * @return object
     */
    public function getActionRoute($action = 'createRoute')
    {
        if($this->isAdmin)
        {
            return $this->adminRoutePrefix. '.' .$this->moduleRoutes[$action];
        }

        return $this->clientRoutePrefix. '.' .$this->moduleRoutes[$action];
    }
    
    /**
     * Get Route
     * 
     * @return object
     */
    public function getModuleView($view = 'createView')
    {
        if($this->isAdmin)
        {
            return $this->adminViewPrefix . '.' .$this->moduleViews[$view];
        }

        return $this->clientViewPrefix. '.' .$this->moduleViews[$view];
    }

    public function setTableStructure($array = array())
    {
        return array_values($array);
    }
}
