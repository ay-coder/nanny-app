<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\MessagesTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Messages\EloquentMessagesRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\Access\User\User;

class APIMessagesController extends BaseApiController
{
    /**
     * Messages Transformer
     *
     * @var Object
     */
    protected $messagesTransformer;

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
    protected $primaryKey = 'messagesId';

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository                       = new EloquentMessagesRepository();
        $this->messagesTransformer = new MessagesTransformer();
    }

    /**
     * List of All Messages
     *
     * @param Request $request
     * @return json
     */
    public function index(Request $request)
    {
        $userInfo   = $this->getAuthenticatedUser();
        $paginate   = $request->get('paginate') ? $request->get('paginate') : false;
        $orderBy    = $request->get('orderBy') ? $request->get('orderBy') : 'id';
        $order      = $request->get('order') ? $request->get('order') : 'asc';
        $items      = $paginate ? $this->repository->model->where('from_user_id', $userInfo->id)->orWhere('to_user_id', $userInfo->id)->with(['from_user', 'to_user'])->orderBy($orderBy, $order)->paginate($paginate)->items() : $this->repository->getAll($orderBy, $order, $userInfo->id);

        if(isset($items) && count($items))
        {
            $itemsOutput = $this->messagesTransformer->transformCollection($items);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Messages!'
            ], 'No Messages Found !');
    }

    /**
     * List of All Messages
     *
     * @param Request $request
     * @return json
     */
    public function myMessages(Request $request)
    {
        $userInfo   = $this->getAuthenticatedUser();
        $items      = $this->repository->getAllUserMessages($userInfo->id);

        if(isset($items) && count($items))
        {
            $itemsOutput = $this->messagesTransformer->myMessageTransform($items);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Messages!'
            ], 'No Messages Found !');
    }

    /**
     * List of All Messages
     *
     * @param Request $request
     * @return json
     */
    public function getChat(Request $request)
    {
        if($request->has('from_user_id') && $request->has('to_user_id') && $request->has('booking_id'))
        {
            $messages = $this->repository->getAllChat($request->get('from_user_id'), $request->get('to_user_id'), $request->get('booking_id'));   
            
            if($messages && count($messages))
            {
                $userInfo       = $this->getAuthenticatedUser();
                $readMessageIds = [];

                foreach($messages as $message)
                {
                    if($userInfo->id == $message->to_user_id)
                    {
                        $readMessageIds[] = $message->id;
                    }
                }

                // Set Read Message
                if(count($readMessageIds))
                {
                    $this->repository->model->whereIn('id', $readMessageIds)
                    ->update(['is_read' => 1]);
                }
                
                $itemsOutput = $this->messagesTransformer->myMessageTransform($messages);

                return $this->successResponse($itemsOutput);
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Messages!'
            ], 'No Messages Found !');
        
    }

    /**
     * Create
     *
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_user_id'        => 'required',
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
        $input      = $request->all();
        $input      = array_merge($input, ['from_user_id' => $userInfo->id ]);


        if($request->file('image'))
        {
            $imageName  = rand(11111, 99999) . '_message.' . $request->file('image')->getClientOriginalExtension();
            if(strlen($request->file('image')->getClientOriginalExtension()) > 0)
            {
                $request->file('image')->move(base_path() . '/public/uploads/messages/', $imageName);
                $input = array_merge($input, ['image' => $imageName, 'is_image' => 1]);
            }
        }

        $model = $this->repository->create($input);

        if($model)
        {
            $toUser     = User::find($request->get('to_user_id'));
            $toUserText = $toUser .' has sent you message';
            $payloadData = [
                'mtitle'    => '',
                'mdesc'     => $toUserText,
                'ntype'     => 'NEW_MESSAGE'
            ];

            $storeNotification = [
                'user_id'       => $userInfo->id,
                'to_user_id'    => $request->get('to_user_id'),
                'description'   => $toUserText,
                'ntype'         => 'NEW_MESSAGE'
            ];

            access()->addNotification($storeNotification);

            access()->sentPushNotification($toUser, $payloadData);


            $responseData = $this->messagesTransformer->transform($model);

            return $this->successResponse($responseData, 'Messages is Created Successfully');
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
            ], 'Something went wrong !');
    }

    /**
     * Create
     *
     * @param Request $request
     * @return string
     */
    public function createMyMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_user_id'        => 'required',
            'booking_id'        => 'required'
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
        $input      = $request->all();
        $input      = array_merge($input, ['from_user_id' => $userInfo->id ]);


        if($request->file('image'))
        {
            $imageName  = rand(11111, 99999) . '_message.' . $request->file('image')->getClientOriginalExtension();
            if(strlen($request->file('image')->getClientOriginalExtension()) > 0)
            {
                $request->file('image')->move(base_path() . '/public/uploads/messages/', $imageName);
                $input = array_merge($input, ['image' => $imageName, 'is_image' => 1]);
            }
        }


        $model = $this->repository->create($input);

        if($model)
        {
            $toUser     = User::find($request->get('to_user_id'));
            $text       = $userInfo->name . ' has sent you message';
            $payloadData = [
                'mtitle'    => '',
                'mdesc'     => $text,
                'ntype'     => 'NEW_MESSAGE'
                
            ];

            $storeNotification = [
                'user_id'       => $userInfo->id,
                'to_user_id'    => $request->get('to_user_id'),
                'booking_id'    => $request->get('booking_id'),
                'description'   => $text,
                'ntype'         => 'NEW_MESSAGE'
            ];

            access()->addNotification($storeNotification);

            access()->sentPushNotification($toUser, $payloadData);


            $responseData = $this->messagesTransformer->transform($model);

            return $this->successResponse($responseData, 'Messages is Created Successfully');
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
                $responseData = $this->messagesTransformer->transform($itemData);

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
        $itemId = (int) hasher()->decode($request->get($this->primaryKey));

        if($itemId)
        {
            $status = $this->repository->update($itemId, $request->all());

            if($status)
            {
                $itemData       = $this->repository->getById($itemId);
                $responseData   = $this->messagesTransformer->transform($itemData);

                return $this->successResponse($responseData, 'Messages is Edited Successfully');
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
        $itemId = (int) hasher()->decode($request->get($this->primaryKey));

        if($itemId)
        {
            $status = $this->repository->destroy($itemId);

            if($status)
            {
                return $this->successResponse([
                    'success' => 'Messages Deleted'
                ], 'Messages is Deleted Successfully');
            }
        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }
}