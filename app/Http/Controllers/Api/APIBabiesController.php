<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\BabiesTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Babies\EloquentBabiesRepository;
use Illuminate\Support\Facades\Validator;

class APIBabiesController extends BaseApiController
{
    /**
     * Babies Transformer
     *
     * @var Object
     */
    protected $babiesTransformer;

    /**
     * Repository
     *
     * @var Object
     */
    protected $repository;

    /**
     * PrimaryKey
     *
     * @var string
     */
    protected $primaryKey = 'babiesId';

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository                       = new EloquentBabiesRepository();
        $this->babiesTransformer = new BabiesTransformer();
    }

    /**
     * List of All Babies
     *
     * @param Request $request
     * @return json
     */
    public function index(Request $request)
    {
        $userInfo   = $this->getAuthenticatedUser();
        $paginate   = $request->get('paginate') ? $request->get('paginate') : false;
        $orderBy    = $request->get('orderBy') ? $request->get('orderBy') : 'id';
        $order      = $request->get('order') ? $request->get('order') : 'ASC';
        $items      = $paginate ? $this->repository->model->where('parent_id', $userInfo->id)->orderBy($orderBy, $order)->paginate($paginate)->items() : $this->repository->getByParent($userInfo->id, $orderBy, $order);

        if(isset($items) && count($items))
        {
            $itemsOutput = $this->babiesTransformer->transformCollection($items);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Babies!'
            ], 'No Babies Found !');
    }

    /**
     * Create
     *
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'title'     => 'required'
        ]);

        if($validator->fails()) 
        {
            $messageData = '';

            foreach($validator->messages()->toArray() as $message)
            {
                $messageData = $message[0];
            }
            return $this->failureResponse($validator->messages(), $messageData);
        }

        $userInfo   = $this->getAuthenticatedUser();
        $input      = array_merge($input, ['image' => 'default.png', 'parent_id' => $userInfo->id]);

        if($request->file('image'))
        {
            $imageName  = rand(11111, 99999) . '_baby.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(base_path() . '/public/uploads/babies/', $imageName);
            $input = array_merge($input, ['image' => $imageName]);
        }

        $model = $this->repository->create($input);

        if($model)
        {
            $responseData = $this->babiesTransformer->transform($model);

            return $this->successResponse($responseData, 'Babies is Created Successfully');
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
            ], 'Something went wrong !');
    }

    /**
     * View
     *
     * @param Request $request
     * @return string
     */
    public function show(Request $request)
    {
        $itemId = (int) hasher()->decode($request->get($this->primaryKey));

        if($itemId)
        {
            $itemData = $this->repository->getById($itemId);

            if($itemData)
            {
                $responseData = $this->babiesTransformer->transform($itemData);

                return $this->successResponse($responseData, 'View Item');
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs or Item not exists !'
            ], 'Something went wrong !');
    }

    /**
     * Edit
     *
     * @param Request $request
     * @return string
     */
    public function edit(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'baby_id'   => 'required',
        ]);

        if($validator->fails()) 
        {
            $messageData = '';

            foreach($validator->messages()->toArray() as $message)
            {
                $messageData = $message[0];
            }
            return $this->failureResponse($validator->messages(), $messageData);
        }

        $userInfo   = $this->getAuthenticatedUser();
        
        if($request->file('image'))
        {
            $imageName  = rand(11111, 99999) . '_baby.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(base_path() . '/public/uploads/babies/', $imageName);
            $input = array_merge($input, ['image' => $imageName]);
        }

        $itemId = (int) hasher()->decode($request->get('baby_id'));


        if($itemId)
        {
            $status = $this->repository->update($itemId, $input);

            if($status)
            {
                $itemData       = $this->repository->getById($itemId);
                $responseData   = $this->babiesTransformer->transform($itemData);

                return $this->successResponse($responseData, 'Baby is Edited Successfully');
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    /**
     * Delete
     *
     * @param Request $request
     * @return string
     */
    public function delete(Request $request)
    {
        $itemId = (int) hasher()->decode($request->get('baby_id'));

        if($itemId)
        {
            
            $userInfo   = $this->getAuthenticatedUser();
            $babyCount  = $this->repository->model->where([
                'id'        => $request->get('baby_id'),
                'parent_id' => $userInfo->id
                ])->count();
            
            if($babyCount > 0)
            {
                $status     = $this->repository->destroy($itemId);

                if($status)
                {
                    return $this->successResponse([
                        'success' => 'Baby Deleted'
                    ], 'Baby is Deleted Successfully');
                }
            }

        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Baby Not Found or Baby Already Deleted !');
    }
}