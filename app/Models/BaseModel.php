<?php namespace App\Models;

/**
 * Class BaseModel
 *
 * @author Anuj Jaha er.anujjaha@gm
 */

use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Input, Schema, ReflectionClass;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\GeneralException;
use App\Models\UpdateLogger;

class BaseModel extends Model
{
    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [ 'id' => 'string' ];

   public static function create(array $attributes = Array())
    {
        $user = access()->user();

        if($user)
        {
            $attributes['user_id'] = (!isset($attributes['user_id']) ? $user->id : $attributes['user_id'] );
        }

        $childClass     = get_called_class();
        $model          = new $childClass;
        $model->runActionLogger(false, 'create');

        return parent::query()->create($attributes);
    }

    /*public static function create(array $attributes = Array())
    {
        return parent::query()->create($attributes);
    }*/

    /**
     * Update the model in the database.
     *
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [] , array $options = [])
    {
        $this->runActionLogger($this, 'update');
        
        return parent::update($attributes);
    }

    /**
     * Delete the model in the database.
     *
     * @return bool
     */
    public function delete()
    {
       return parent::delete();
    }

    /**
     * Get Data With Account Filter
     *
     * @param $account
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function getAll($account = false)
    {
        return parent::get();
    }

    /**
     * Get Model Collection in Hashed Format
     *
     * @param  array $relations
     * @param int $pagination
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function getHashedCollection($relations = array(), $pagination = 20, $filters = array())
    {
       $collection = parent::with($relations)->paginate($pagination);

        // For each collection item, the ID needs to become hashed
        foreach ($collection as $data)
        {
            $data->id = $data->getHashedId();

            foreach($relations as $rel)
            {
                if(method_exists($data, $rel))
                {
                    // If collection is returned, run through each model and hash the ID
                    if(count($data->$rel) >= 1)
                    {
                        if(isset($data->$rel->id))
                        {
                            if(is_int($data->$rel->id))
                            {
                                $data->$rel->id = $data->$rel->getHashedId();
                            }
                        }
                    }
                }
            }
        }

        return $collection;
    }
    /**
     * Get Model Collection in Hashed Format
     *
     * @param array $filters
     * @param array $relations
     * @param array $sorting
     * @param int $pagination
     * @param mixed $nestedFilters
     * @return mixed
     */
    public function getAllWithFilters($filters, $relations = array(), $sorting = array(), $pagination = 10, $nestedFilters = false)
    {
        // Determine the Collection type
        $collection = $this->getCollectionByParentModel($filters, $sorting, $relations);

        // Filter by Encryption types
        $collection = $this->filterByEncryptionType($collection, $filters, $nestedFilters);

        // Sort Collection
        if(isset($sorting['dataKey']) && isset($sorting['direction']))
        {
            if(!$this->parentIsNode())
            {
                $collection->orderBy($sorting['dataKey'], $sorting['direction']);
            }
        }

	    /*
	    if(isset($sorting['relation']) && isset($sorting['direction']) && isset($sorting['sortCallback']) && $sorting['sortCallback'] instanceof \Closure)
	    {
		    try
		    {
			    $sortRelation = $collection->getRelation('playCount');
		    }
		    catch(RelationNotFoundException $e)
		    {
			    $sortRelation = false;
		    }

		    if(isset($sortRelation) && $sortRelation)
		    {
			    //$collection = call_user_func($sorting['sortCallback'], $collection, $sorting);

			    $newCollection = $collection->with('playCount')->get()->sortBy(function($model)
			    {
				    return $model->playCount->count();
			    });

			    dd($newCollection);

			    return new LengthAwarePaginator(
				    $newCollection, // Only grab the items we need
				    count($newCollection), // Total items
				    $pagination, // Items per page
				    1, // Current page
				    ['path' => request()->url(), 'query' => request()->query()] // We need this so we can keep all old query parameters from the url
			    );
		    }
	    }
	    */

        $collection = $collection->paginate($pagination);

        return $collection;
    }

    /**
     * Get Collection By Parent
     *
     * @param $filters
     * @param $sorting
     * @param $relations
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function getCollectionByParentModel($filters, $sorting, $relations)
    {
        if($this->parentIsNode() && $this->filtersAreEmpty($filters))
        {
            if(isset($sorting['dataKey']) && isset($sorting['direction']))
            {
                return $this->setOrderColumn($sorting['dataKey'], $sorting['direction'])->roots();
            }
            else
            {
                return $this->roots();
            }
        }
        else
        {
            return parent::with($relations);
        }
    }

    /**
     * Check if Filter by Type is Empty
     *
     * @param $filterList
     * @return bool
     */
    public function filtersAreEmpty($filterList)
    {
        $empty = false;

        if(empty($filterList))
        {
            return true;
        }

        foreach($filterList as $filterTypes)
        {
            if(!empty($filterTypes) && is_array($filterTypes))
            {
                foreach($filterTypes as $filters)
                {
                    if(!empty($filters))
                    {
                        foreach($filters as $key => $filter)
                        {
                            if($filter && $filter != '')
                            {
                                return false;
                            }
                        }
                    }
                }
            }
        }

        return true;
    }

    /**
     * Find Hashed
     *
     * @param $id
     * @param array $relations
     * @param int $resetHash
     * @param array $hashed
     * @return bool|\Illuminate\Database\Eloquent\Collection|Model
     * @throws GeneralException
     */
    public static function findHashed($id, $relations = array(), $resetHash = 0, $hashed = array())
    {
        /*
        $account = access()->account();

        if(!$account)
        {
            throw new GeneralException('There seems to be an issue with this content');
        }
        */

        $decoded = hasher()->decode($id);

        // Determine if a valid ID exists, otherwise return false
        $identifier = ($decoded ? $decoded : ($id ? $id : false));

        // If no ID is presented when unHashed,
        // throw an AccountNotAccessible exception
        if(!$identifier)
        {
            throw new GeneralException('The item does not exist or is not accessible');
        }

        // Get model item by ID with relations
        $item = parent::with($relations)->findOrFail($identifier);

        $prepareMethod = 'prepareFormInput';

        if(method_exists($item, $prepareMethod))
        {
            $item->$prepareMethod();
        }

        // If item does not exist or isn't found,
        // throw an AccountNotAccessible exception
        if (!$item)
        {
            throw new GeneralException('The item does not exist or is not accessible');
        }

        // Here we can enable the model data and relations to
        // become re-hashed for user viewing so no ID is exposed

        if($resetHash)
        {
            // Hash item's ID
            $item->id = $item->getHashedId();

            $item = $item->hashModelRelations($relations);

            // For each model value that needs to be hashed
            // run through hasher object
            foreach($hashed as $hash)
            {
                if($item->$hash)
                {
                    $item->$hash = hasher()->encode($item->$hash);
                }
            }
        }

        // Lastly, check if the item's account_id matches the current user
        // If not, throw an AccountNotAccessible exception
        //if ($item->account_id !== $account->id)
        //{
            #throw new AccountNotAccessible('The item does not exist or is not accessible');
        //}
        return $item;
    }

    /**
     * Hash Collection Relations
     *
     * @param $collection
     * @param $relations
     * @return mixed
     */
    public function hashCollectionRelations($collection, $relations)
    {
        // For each collection item, the ID needs to become hashed
        foreach ($collection as $data)
        {
            foreach($relations as $rel)
            {
                if(method_exists($data, $rel))
                {
                    // If collection is returned, run through each model
                    // and hash the ID
                    if(count($data->$rel) >= 1)
                    {
                        if(isset($data->$rel->id))
                        {
                            if(is_int($data->$rel->id))
                            {
                                $data->$rel->id = $data->$rel->getHashedId();
                            }
                        }
                    }
                }
            }

            $data->id = $data->getHashedId();
        }

        return $collection;
    }

    /**
     * Hash Relations
     *
     * @param $relations
     * @param object|null $item
     * @return bool
     */
    public function hashModelRelations($relations, $item = null)
    {
        $item = (!is_null($item) ? $item : $this);

        // For each relation, check if the method exists
        // and hash each ID of a relation collection
        foreach($relations as $relation)
        {
            if(method_exists($item, $relation))
            {
                // If collection is returned, run through each model
                // and hash the ID
                if(count($item->$relation) > 1)
                {
                    foreach($item->$relation as $key => $relationItem)
                    {
                        if(isset($relationItem->id))
                        {
                            $relationItem->id = hasher()->encode($relationItem->id);
                        }
                    }
                }
                // If collection is not returned, and just a single model
                // is used, hash the ID of the single mo$item->del item
                else
                {
                    if(is_array($item->$relation) || count($item->$relation))
                    {
                        foreach($item->$relation as $key => $relationItem)
                        {
                            if(isset($relationItem->id))
                            {
                                $relationItem->id = hasher()->encode($relationItem->id);
                            }
                        }
                        continue;
                    }

                    if($item->$relation)
                    {
                        if(isset($item->$relation->id))
                        {
                            $item->$relation->id = hasher()->encode($item->$relation->id);
                        }
                    }
                }
            }
        }

        return $item;
    }

    /**
     * Filter by Custom Filter Set
     *
     * @param $collection
     * @param $filters
     * @return bool
     */
	public function filterByCustomFilterSet($collection, $filters)
	{
		if($filters && !empty($filters))
		{
			foreach($filters as $filter)
			{
				if(!isset($filter->type)) { return false; }

				$filterType = $filter->type;

				switch($filterType)
				{
                    case 'modelKey':

                        $collection = $this->filterByModelProperty($collection, $filter);

                        break;

					case 'relation':

						$collection = $this->filterByCustomRelation($collection, $filter);

						break;
				}
			}
		}

		return $collection;
	}

    /**
     * Filter By Model Property
     *
     * @param $collection
     * @param $filter
     * @return mixed
     */
    public function filterByModelProperty($collection, $filter)
    {
        if(isset($filter->key) && isset($filter->value) && isset($filter->operator))
        {
            $collection->where($filter->key, $filter->operator, $filter->value);
        }

        return $collection;
    }

    /**
     * Filter by Custom Relation
     *
     * @param $collection
     * @param $filter
     * @return mixed
     */
	public function filterByCustomRelation($collection, $filter)
	{
		if(isset($filter->relation))
		{
			$relation       = $filter->relation;
			$relationTable  = (isset($this->$relation) && $this->$relation()->getRelated()) ? $this->$relation()->getRelated()->table : '';
            $key            = $filter->key;
            $value          = $filter->value;
            $shownEmpty     = false;

            if(Schema::hasTable($relationTable) && Schema::hasColumn($relationTable, $key))
            {
                if(!isset($filter->hideEmpty) || !$filter->hideEmpty)
                {
                    $shownEmpty = true;
                    $collection->whereDoesntHave($filter->relation);
                }

                if(isset($filter->key) && isset($filter->value) && $relationTable)
                {
                    if($shownEmpty)
                    {
                        $collection->orWhereHas($filter->relation, function($query) use ($key, $value, $relationTable)
                        {
                            if(is_array($value))
                            {
                                $query->whereIn($relationTable.'.'.$key, $value);
                            }
                            else
                            {
                                $query->where($relationTable.'.'.$key, $value);
                            }
                        });
                    }
                    else
                    {
                        $collection->whereHas($filter->relation, function($query) use ($key, $value, $relationTable)
                        {
                            if(is_array($value))
                            {
                                $query->whereIn($relationTable.'.'.$key, $value);
                            }
                            else
                            {
                                $query->where($relationTable.'.'.$key, $value);
                            }
                        });
                    }
                }
            }
		}

		return $collection;
	}

    /**
     * Filter by Encryption Type
     *
     * @param $collection
     * @param $filterList
     * @param $nestedFilters
     * @return mixed
     */
    public function filterByEncryptionType($collection, $filterList, $nestedFilters)
    {
        foreach(array('normal', 'hashed') as $encType)
        {
            if(isset($filterList[$encType]))
            {
                $filterTypes = $filterList[$encType];

                foreach($filterTypes as $type => $filters)
                {
                    foreach($filters as $key => $filter)
                    {
                        if($encType == 'hashed')
                        {
                            $decoded = hasher()->decode($filter);
                        }

                        $filter = ((isset($decoded) && $decoded) ? $decoded : $filter);

                        if($filter !== '' && $filter !== null)
                        {
                            if(Schema::hasColumn($this->getTable(), $key))
                            {
                                switch($type)
                                {
                                    case 'text':

                                        $collection->where($key, 'LIKE', "%".$filter."%");

                                        break;

                                    case 'data':

                                        if(isset($filter['operator']))
                                        {
                                            if($filter['operator'] == 'NOT IN')
                                            {
                                                $collection->whereNotIn($key, $filter['value']);
                                            }
                                            else if($filter['operator'] == 'IN')
                                            {
                                                $collection->whereIn($key, $filter['value']);
                                            }
                                            else
                                            {
                                                $collection->where($key, $filter['operator'], $filter['value']);
                                            }
                                        }
                                        else
                                        {
                                            $collection->where($key, '=', $filter);
                                        }

                                        break;

                                    case 'model':

                                        $collection->where($key, '=', $filter);

                                        break;
                                }
                            }

                            if($nestedFilters)
                            {
                                $nestedFilter = $this->getNestedFilterByKey($key, $nestedFilters);

                                if($nestedFilter)
                                {
                                    if($parent = $nestedFilter['model']->find($filter))
                                    {
                                        $children = $parent->getDescendants();

                                        if(!empty($children) && count($children) > 0)
                                        {
                                            foreach($children as $child)
                                            {
                                                $collection->orWhere($key, '=', $child->id);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $collection;
    }

    /**
     * Get Nested Filter by Key
     *
     * @param $key
     * @param $nestedFilters
     * @return bool
     */
    public function getNestedFilterByKey($key, $nestedFilters)
    {
        if(!empty($nestedFilters) && count($nestedFilters) > 0)
        {
            foreach($nestedFilters as $nestedFilter)
            {
                if($nestedFilter['key'] == $key)
                {
                    return $nestedFilter;
                }
            }
        }

        return false;
    }

    /**
     * Check if Instance of Node Model (Nested)
     *
     * @param $model
     * @return bool
     */
    public function parentIsNode($model = false)
    {
        $model = ($model ? $model : $this);

        $class      = new ReflectionClass($model);
        $parent     = $class->getParentClass();
        $parentName = $parent->getShortName();

        if($parentName == 'Node')
        {
            return true;
        }

        return false;
    }

    /**
     * Get Hashed Relation Lists
     *
     * @param $model
     * @param $relation
     * @return array
     */
    public static function getHashedRelationLists($model, $relation)
    {
        $list = [];

        if($model->$relation)
        {
            foreach($model->$relation as $rel)
            {
                $list[] = (is_int($rel->id) ? hasher()->encode($rel->id) : $rel->id);
            }
        }

        return $list;
    }

    /**
     * Generate drop-down select data with basic IDs
     *
     * @param bool $useAccount
     * @return array
     */
	public static function getSelectData($useAccount = false, $val = null)
       {
           $items = array();
           $value = 'name';

           if($val)
           {
               $value = $val;
           }

           if($useAccount)
           {
               $account    = access()->account();
               $collection = parent::where('account_id', '=', $account->id)->get()->pluck($value, 'id');
           }
           else
           {
               $collection = parent::pluck($value, 'id');
           }

           // For each item, the ID needs to become hashed
           foreach ($collection as $id => $name)
           {
               $item = parent::find($id);

               if(isset(static::$selectHTMLFormat) && static::$selectHTMLFormat !== '')
               {
                   $items[$id] = static::generateSelectName($item, static::$selectHTMLFormat);
               }
               else
               {
                   $items[$id]   = $name;
               }
           }


           return $items;
    }

    /**
     * Generate drop-down select data with basic IDs
     *
     * @return array
     */
    public static function getSelectDataByAccount($id=null, $val = null)
    {
        $value = 'name';

        if($val)
        {
            $value = $val;
        }

        if($id)
        {
            $collection = parent::where(['account_id' => $id])->get()->pluck($value, 'id');
        }
        else
        {
            $collection = parent::get()->pluck($value, 'id');
        }

        $items      = array();

        // For each item, the ID needs to become hashed
        foreach ($collection as $id => $name)
        {
            $item = parent::find($id);

            if(isset(static::$selectHTMLFormat) && static::$selectHTMLFormat !== '')
            {
                $items[$id] = static::generateSelectName($item, static::$selectHTMLFormat);
            }
            else
            {
                $items[$id]   = $name;
            }
        }

        return $items;
    }

    /**
     * Generate drop-down select data with hashed IDs
     *
     * @param null|int $accountId
     * @return array
     */
    public static function getHashedSelectData($accountId = null)
    {
        $hashed = array();

        if(!$accountId)
        {
            $accountId = access()->account()->id;
        }

        $collection = parent::where(['account_id' => $accountId])->get()->pluck('name', 'id');

        // For each item, the ID needs to become hashed
        foreach ($collection as $id => $name)
        {
            $item   = parent::find($id);
            $key    = hasher()->encode($id);

            if(isset(static::$selectHTMLFormat) && static::$selectHTMLFormat !== '')
            {
                $hashed[$key] = static::generateSelectName($item, static::$selectHTMLFormat);
            }
            else
            {
                $hashed[$key]   = $name;
            }
        }

        return $hashed;
    }

    /**
     * Generate Custom Drop-Down Name
     *
     * @param object $model
     * @param string $params
     * @return array
     */
    public static function generateSelectName($model, $params)
    {
        preg_match_all("/\[[^\]]*\]/", $params, $matches);

        if(!isset($matches[0]))
        {
            return false;
        }

        $keys = [];

        foreach($matches[0] as $match)
        {
            $matchKey = preg_match("/\[(.*)\]/", $match , $keyMatch);

            $keys[] = [
                'tag'   => $keyMatch[0],
                'key'   => $keyMatch[1]
            ];
        }

        $toReplace = [];

        foreach($keys as $key)
        {
            $keyVal = $key['key'];

            if(isset($model->$keyVal))
            {
                $keyValue = $model->$keyVal;

                $toReplace[] = [
                    'tag'       => $key['tag'],
                    'value'   => $keyValue
                ];
            }
        }

        $string = $params;

        foreach($toReplace as $replace)
        {
            $string = str_replace($replace['tag'], $replace['value'], $string);
        }

        return $string;
    }

    /**
     * Get last used order value
     *
     * @param  array  $filters
     * @return int
     */
    public static function getLastOrderValue($filters = array())
    {
        $account    = access()->account();
        $match      = ['account_id' => $account->id];

        if(!empty($filters))
        {
            foreach($filters as $key => $filter)
            {
                if(!is_null($filter['value']))
                {
                    if(isset($filter['hash']) && !empty($filter['hash']))
                    {
                        $match[$key] = hasher()->decode($filter['value']);
                    }
                    else
                    {
                        $match[$key] = $filter['value'];
                    }
                }
            }
        }

        $maxOrder = parent::where($match)->get()->max('ordering') + 1;

        return $maxOrder;
    }

    /**
     * Update status of a model item
     *
     * @return void
     */
    public static function updateStatus($id, $setStatus = NULL)
    {
        $model = static::findHashed($id);

        if(is_null($setStatus))
        {
            $status = ($model->status ? 0 : 1);
        }
        else
        {
            $status = (int) $setStatus;
        }

        $model->status = $status;

        $model->save();
    }

    /**
     * Update Star Flag
     *
     * @return void
     */
    public static function updateFlag($id, $setFlag = NULL)
    {
        $model = static::findHashed($id);

        if(is_null($setFlag))
        {
            $flag = ($model->flag ? 0 : 1);
        }
        else
        {
            $flag = (int) $setFlag;
        }

        $model->flag = $flag;

        $model->save();
    }

    /**
     * Get Hashed ID
     *
     * @param bool $model
     * @return mixed
     */
    public function getHashedId($model = false)
    {
        $model  = (!$model ? $this : $model);

        return hasher()->encode($model->getOriginal('id'));
    }

    /**
     * Hash Models ID
     *
     * @param bool|false $model
     * @return mixed
     */
    public function hashId($model = false)
    {
        $model      = (!$model ? $this : $model);
	    $model->id  = hasher()->encode($model->getOriginal('id'));
	    return $model;
    }

    /**
     * Hash Model Properties
     *
     * @param $properties
     * @param bool|false $model
     * @param bool|false $nullOnEmpty
     * @return bool|BaseModel
     */
    public function hashProperties($properties, $model = false, $nullOnEmpty = false)
    {
        $model = (!$model ? $this : $model);

	    if(!empty($properties) && is_array($properties))
	    {
		    foreach($properties as $property)
		    {
			    if(isset($model->$property))
			    {
                    if(is_a($model->$property, 'Illuminate\Database\Eloquent\Collection'))
                    {
                        foreach($model->$property as $collectionItem)
                        {
                            if(isset($collectionItem->id))
                            {
                                $collectionItem->id = hasher()->encode($collectionItem->id, $nullOnEmpty);
                            }
                        }
                    }
                    else
                    {
                        $model->$property = hasher()->encode($model->$property, $nullOnEmpty);
                    }
			    }
		    }
	    }
	    else if($properties != '')
	    {
		    if(isset($model->$properties))
		    {
			    $model->$properties = hasher()->encode($model->$properties, $nullOnEmpty);
		    }
	    }

        return $model;
    }

    /**
     * Get Model Flag
     *
     * @param bool $model
     * @return bool|string
     */
    public function getFlag($model = false)
    {
        $model = (!$model ? $this : $model);

        if(!isset($model->flag))
        {
            return false;
        }

        switch ($model->flag)
        {
            case '1':
                return 'Important';

            case '2':
                return 'Review';

            case '0':
                return 'None';

            default:
                return false;
        }
    }

    /**
     * Run Action Logger
     *
     * @param $model
     * @param $action
     */
    public function runActionLogger($model = false, $action)
    {
        $modelClass  = (new \ReflectionClass($this))->getShortName();
        $model       = $model ? $model : $this;
        $user        = access()->user();
        
        $notAllowed  = [
        ];

        if($user && isset($model->id))
        {
            $actionLogger = new UpdateLogger();

            $data = [
                'user_id'       => $user->id,
                'section'       => $modelClass,
                'action'        => $action,
                'item'          => $model->getOriginal('id')
            ];

            $actionLogger->create($data);
        }
    }

    /**
     * Get Action Logs
     *
     * @param bool $model
     * @param bool $item
     * @param int $limit
     * @return mixed
     */
    public function getActionLogs($model = false, $item = true, $limit = 10)
    {
        $actionLogger   = new UpdateLogger();
        $model          = $model ? $model : $this;

        if($item)
        {
            return $actionLogger->getActionLogs($model, $model->getOriginal('id'), $limit);
        }
        else
        {
            return $actionLogger->getActionLogs($model, false, $limit);
        }
    }
}
