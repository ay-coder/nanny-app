<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Access\User\User;
use Response;
use Carbon;
use App\Repositories\Backend\User\UserContract;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Backend\UserNotification\UserNotificationRepositoryContract;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Transformers\UserTransformer;
use App\Http\Utilities\FileUploads;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use App\Http\Controllers\Api\BaseApiController;
use App\Events\Backend\Access\User\UserPasswordChanged;
use App\Repositories\Backend\Access\User\UserRepository;
use Twilio;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VoiceGrant;
use Auth;
use Twilio\Rest\Client;

class UsersController extends BaseApiController
{
    protected $userTransformer;
    /**
     * __construct
     * @param UserTransformer                    $userTransformer
     */
    public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * Login request
     *
     * @param Request $request
     * @return type
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error'     => 'Invalid Credentials',
                    'message'   => 'No User Found for given details',
                    'status'    => false,
                    ], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json([
                    'error'     => 'Somethin Went Wrong!',
                    'message'   => 'Unable to Generate Token!',
                    'status'    => false,
                    ], 500);
        }

        if($request->get('device_token') && $request->get('device_type'))
        {
            $user = Auth::user();
            $user->device_type  = $request->get('device_type');
            $user->device_token = $request->get('device_token');
            $user->save();
        }

        $user = Auth::user()->toArray();


        $userData = array_merge($user, ['token' => $token]);

        $responseData = $this->userTransformer->transform((object)$userData);

        return $this->successResponse($responseData);
    }

    /**
     * Login request
     *
     * @param Request $request
     * @return type
     */
    public function sitterLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error'     => 'Invalid Credentials',
                    'message'   => 'No User Found for given details',
                    'status'    => false,
                    ], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json([
                    'error'     => 'Somethin Went Wrong!',
                    'message'   => 'Unable to Generate Token!',
                    'status'    => false,
                    ], 500);
        }

        if($request->get('device_token') && $request->get('device_type'))
        {
            $user = Auth::user();
            $user->device_type  = $request->get('device_type');
            $user->device_token = $request->get('device_token');
            $user->save();
        }

        $userInfo   = Auth::user();
        $user       = User::where('id', $userInfo->id)->with('sitter')->first()->toArray();
        $userData   = array_merge($user, ['token' => $token]);

        $responseData = $this->userTransformer->sitterTranform((object)$userData);

        return $this->successResponse($responseData);
    }

    /**
     * Sitter Profile request
     *
     * @param Request $request
     * @return type
     */
    public function sitterProfile(Request $request)
    {

        $userInfo = $this->getAuthenticatedUser();
        $user       = User::where('id', $userInfo->id)->with('sitter')->first()->toArray();

        $headerToken = request()->header('Authorization');

        if($headerToken)
        {
            $token      = explode(" ", $headerToken);
            $userToken  = $token[1];
        }


        $userData   = array_merge($user, ['token' => $userToken]);

        $responseData = $this->userTransformer->sitterTranform((object)$userData);

        return $this->successResponse($responseData);
    }

    /**
     * Login request
     *
     * @param Request $request
     * @return type
     */
    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'social_token'      => 'required',
            'social_provider'   => 'required'
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


        $user = User::where([
                'social_provider'   => $request->get('social_provider'),
                'social_token'      => $request->get('social_token')])->first();

        if(isset($user) && $user->id)
        {
            Auth::loginUsingId($user->id, true);

            if($request->get('device_token') && $request->get('device_type'))
            {
                $user = Auth::user();
                $user->device_type  = $request->get('device_type');
                $user->device_token = $request->get('device_token');
                $user->save();
            }

            if($request->file('profile_image'))
            {
                $imageName  = rand(11111, 99999) . '_user.' . $request->file('profile_image')->getClientOriginalExtension();
                if(strlen($request->file('profile_image')->getClientOriginalExtension()) > 0)
                {
                    $request->file('profile_image')->move(base_path() . '/public/uploads/user/', $imageName);
                    $user = Auth::user();
                    $user->profile_pic = $imageName;
                    $user->save();
                }
            }

            $user       = Auth::user()->toArray();
            $token      = JWTAuth::fromUser(Auth::user());
            $userData   = array_merge($user, ['token' => $token]);
            $responseData = $this->userTransformer->transform((object)$userData);

            return $this->successResponse($responseData);
        }

        return response()->json([
            'error'     => 'Invalid Credentials',
            'message'   => 'No User Found for given details',
            'status'    => false,
            ], 401);
    }

     /**
     * socialCreate
     *
     * @param Request $request
     * @return string
     */
    public function socialCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'social_token'      => 'required',
            'social_provider'   => 'required'
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

        $user = User::where([
                'social_provider'   => $request->get('social_provider'),
                'social_token'      => $request->get('social_token')])->first();

        if(isset($user) && $user->id)
        {
            return $this->socialLogin($request);
        }


        $validator = Validator::make($request->all(), [
            'email'             => 'required|unique:users|max:255',
            'social_token'      => 'required|unique:users|max:255',
            'social_provider'   => 'required'
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

        $status = $this->socialLogin($request);

        $repository = new UserRepository;
        $input      = $request->all();
        $input      = array_merge($input, ['profile_pic' => 'default.png']);
        if($request->file('profile_image'))
        {
            $imageName  = rand(11111, 99999) . '_user.' . $request->file('profile_image')->getClientOriginalExtension();
            if(strlen($request->file('profile_image')->getClientOriginalExtension()) > 0)
            {
                $request->file('profile_image')->move(base_path() . '/public/uploads/user/', $imageName);
                $input = array_merge($input, ['profile_pic' => $imageName]);
            }
        }

        $user = $repository->createSocialUserStub($input);
        if($user)
        {
            Auth::loginUsingId($user->id, true);

            $user           = Auth::user()->toArray();
            $token          = JWTAuth::fromUser(Auth::user());
            $userData       = array_merge($user, ['token' => $token]);
            $responseData   = $this->userTransformer->transform((object)$userData);
            return $this->successResponse($responseData);
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
    public function create(Request $request)
    {
        $repository = new UserRepository;
        $input      = $request->all();
        $input      = array_merge($input, ['profile_pic' => 'default.png']);
        if($request->file('profile_pic'))
        {
            $imageName  = rand(11111, 99999) . '_user.' . $request->file('profile_pic')->getClientOriginalExtension();
            if(strlen($request->file('profile_pic')->getClientOriginalExtension()) > 0)
            {
                $request->file('profile_pic')->move(base_path() . '/public/uploads/user/', $imageName);
                $input = array_merge($input, ['profile_pic' => $imageName]);
            }
        }
        $validator = Validator::make($request->all(), [
            'email'     => 'required|unique:users|max:255',
            'name'      => 'required',
            'password'  => 'required',
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
        $user = $repository->createUserStub($input);
        if($user)
        {
            Auth::loginUsingId($user->id, true);
            $credentials = [
                'email'     => $input['email'],
                'password'  => $input['password']
            ];

            $token          = JWTAuth::attempt($credentials);
            $user           = Auth::user()->toArray();
            $userData       = array_merge($user, ['token' => $token]);
            $responseData   = $this->userTransformer->transform((object)$userData);
            return $this->successResponse($responseData);
        }
        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
            ], 'Something went wrong !');
    }

    /**
     * Forgot Password
     *
     * @param Request $request
     * @return string
     */
    public function forgotpassword(Request $request)
    {
        if($request->get('email'))
        {
            $userObj = new User;

            $user = $userObj->where('email', $request->get('email'))->first();

            if($user)
            {
                if(1==1) // Send Mail Succes
                {
                    $successResponse = [
                        'message' => 'Reset Password Mail send successfully.'
                    ];
                }

                return $this->successResponse($successResponse);
            }

            return $this->setStatusCode(400)->failureResponse([
                'error' => 'User not Found !'
            ], 'Something went wrong !');
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    /**
     * Change Password
     *
     * @param Request $request
     * @return string
     */
    public function changePassword(Request $request)
    {
        if($request->get('password'))
        {
            $userInfo = $this->getAuthenticatedUser();
            $userInfo->password = bcrypt($request->get('password'));

            if ($userInfo->save())
            {
                event(new UserPasswordChanged($userInfo));

                $successResponse = [
                    'message' => 'Password Updated successfully.'
                ];

                return $this->successResponse($successResponse);
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    /**
     * Get User Profile
     *
     * @param Request $request
     * @return json
     */
    public function getUserProfile(Request $request)
    {
        if($request->get('user_id'))
        {
            $userObj = new User;

            $user = $userObj->find($request->get('user_id'));

            if($user)
            {
                $responseData = $this->userTransformer->transform($user);

                return $this->successResponse($responseData);
            }

            return $this->setStatusCode(400)->failureResponse([
                'error' => 'User not Found !'
            ], 'Something went wrong !');
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    /**
     * Update User Profile
     *
     * @param Request $request
     * @return json
     */
    public function updageUserProfile(Request $request)
    {
        $headerToken = request()->header('Authorization');

        if($headerToken)
        {
            $token      = explode(" ", $headerToken);
            $userToken  = $token[1];
        }

        $userInfo   = $this->getApiUserInfo();
        $repository = new UserRepository;
        $input      = $request->all();

        if($request->file('profile_pic'))
        {
            $imageName  = rand(11111, 99999) . '_user.' . $request->file('profile_pic')->getClientOriginalExtension();
            if(strlen($request->file('profile_pic')->getClientOriginalExtension()) > 0)
            {
                $request->file('profile_pic')->move(base_path() . '/public/uploads/user/', $imageName);
                $input = array_merge($input, ['profile_pic' => $imageName]);
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
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

        $status = $repository->updateUserStub($userInfo['userId'], $input);

        if($status)
        {
            $userObj = new User;

            $user = $userObj->with('babies')->where('id', $userInfo['userId'])->first();

            if($user)
            {
                $responseData = $this->userTransformer->updateUser($user);

                return $this->successResponse($responseData);
            }

            return $this->setStatusCode(400)->failureResponse([
                'error' => 'User not Found !'
            ], 'Something went wrong !');
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

     /**
     * Update Sitter Profile
     *
     * @param Request $request
     * @return json
     */
    public function updageSitterProfile(Request $request)
    {
        $headerToken = request()->header('Authorization');

        if($headerToken)
        {
            $token      = explode(" ", $headerToken);
            $userToken  = $token[1];
        }

        $userInfo   = $this->getApiUserInfo();
        $repository = new UserRepository;
        $input      = $request->all();

        if($request->file('profile_pic'))
        {
            $imageName  = rand(11111, 99999) . '_user.' . $request->file('profile_pic')->getClientOriginalExtension();
            if(strlen($request->file('profile_pic')->getClientOriginalExtension()) > 0)
            {
                $request->file('profile_pic')->move(base_path() . '/public/uploads/user/', $imageName);
                $input = array_merge($input, ['profile_pic' => $imageName]);
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
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

        unset($input['about_me']);
        unset($input['description']);
        unset($input['category']);
        unset($input['vacation_mode']);
        unset($input['sitter_start_time']);
        unset($input['sitter_end_time']);

        $status = $repository->updateUserStub($userInfo['userId'], $input);

        if($status)
        {
            $userObj = new User;

            $user = $userObj->with('sitter')->where('id', $userInfo['userId'])->first();

            if($request->has('about_me'))
            {
                $user->sitter->about_me = $request->get('about_me');
            }

            if($request->has('category'))
            {
                $user->sitter->category = $request->get('category');
            }

            if($request->has('description'))
            {
                $user->sitter->description = $request->get('description');
            }

            if($request->has('vacation_mode'))
            {
                $user->sitter->vacation_mode = $request->get('vacation_mode');
            }

            if($request->has('sitter_start_time'))
            {
                $user->sitter->sitter_start_time = $request->get('sitter_start_time');
            }

            if($request->has('sitter_end_time'))
            {
                $user->sitter->sitter_end_time = $request->get('sitter_end_time');
            }

            if($user)
            {
                $user->sitter->save();
                $responseData = $this->userTransformer->sitterTranform($user);

                return $this->successResponse($responseData);
            }

            return $this->setStatusCode(400)->failureResponse([
                'error' => 'User not Found !'
            ], 'Something went wrong !');
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    public function updageUserPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'  => 'required',
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

        $userInfo   = $this->getApiUserInfo();
        $user       = User::find($userInfo['userId']);

        $user->password = bcrypt($request->get('password'));

        if ($user->save())
        {
            $successResponse = [
                'message' => 'Password Updated successfully.'
            ];

            return $this->successResponse($successResponse);
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    /**
     * Logout request
     *
     * @param  Request $request
     * @return json
     */
    public function logout(Request $request)
    {
        $userInfo   = $this->getApiUserInfo();
        $user       = User::find($userInfo['userId']);

        $user->device_token = '';

        if($user->save())
        {
            $successResponse = [
                'message' => 'User Logged out successfully.'
            ];

            return $this->successResponse($successResponse);
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'User Not Found !'
        ], 'User Not Found !');
    }

    public function config(Request $request)
    {
        $successResponse = [
            'support_number'        => '110001010',
            'privacy_policy_url'    => 'https://www.google.co.in/',
            'tax'                   => (float) 0,
            'other_charges'         => (float) 0
        ];

        return $this->successResponse($successResponse);
    }

    public function profileCompletion(Request $request)
    {
    	$userInfo = $this->getAuthenticatedUser();

    	if(isset($userInfo) && isset($userInfo->id))
		{
			$count 	= 0;
			$mobile = $gender = $address = $birthdate = $name 	= false;

			if(isset($userInfo->name)  && strlen($userInfo->name) > 2)
			{
				$count 	= $count + 20;
				$name 	= true;
			}

			if(isset($userInfo->gender) && strlen($userInfo->gender) > 2)
			{
				$count 		= $count + 20;
				$gender 	= true;
			}


			if(isset($userInfo->mobile) && strlen($userInfo->mobile) > 2)
			{
				$count 		= $count + 20;
				$mobile 	= true;
			}

			if(isset($userInfo->address) && strlen($userInfo->address) > 2)
			{
				$count 		= $count + 20;
				$address 	= true;
			}

			if(isset($userInfo->birthdate) && strlen($userInfo->birthdate) > 2)
			{
				$count 		= $count + 20;
				$birthdate 	= true;
			}

			$successResponse = [
				'name'							=> $name,
				'gender'						=> $gender,
				'mobile'						=> $mobile,
				'address'						=> $address,
				'birthdate'						=> $birthdate,
	            'profile_completion_count' 		=> (int) $count
	        ];

	        return $this->successResponse($successResponse);
		}

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'User Not Found !'
        ], 'User Not Found !');
    }

    /**
     * Call Token
     * @param Request $request
     */
    public function callToken(Request $request)
    {
        // Your Account Sid and Auth Token from twilio.com/user/account
        $sid = "AC0de83c8b176e844565d89674c558f212";
        $token = "c8b3bdb413a324b23b899b777d7072b4";
        $client = new Client($sid, $token);
        $mobile = $request->has('mobile') ? $request->get('mobile')  : '+919879352734';
        $call = $client->calls->create(
            "+15017122624",
            $mobile,
            array("url" => "https://demo.twilio.com/welcome/voice/")
        );

        $twilioAccountSid   = 'ACdcf7bf55f7ff0faada90d4afaa5d06fe';
        $twilioApiKey       = 'SK6c8672d2448bf28ee09f36283e489ec6';
        $twilioApiSecret    = 'T0MjKzlGqlRyR5Sl4uBKdKoYNhmEm567';
        
        // Required for Voice grant
        //$outgoingApplicationSid = 'PNebb6b08a67e0eec24de4e67e9b0bdc79';
        //$outgoingApplicationSid = 'CA9b6e7ce3fd72058483d0b0a0598bc8db';
        $outgoingApplicationSid = $call->sid;

        // An identifier for your app - can be anything you'd like
        $identity = "john_doe";

        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
            $twilioAccountSid,
            $twilioApiKey,
            $twilioApiSecret,
            3600,
            $identity
        );
        // Create Voice grant
        $voiceGrant = new VoiceGrant();
        $voiceGrant->setOutgoingApplicationSid($outgoingApplicationSid);
        // Add grant to token
        $token->addGrant($voiceGrant);
        // render token to string
        
        $successResponse = [    
            'token' => $token->toJWT()
        ];
        return $this->successResponse($successResponse);
    }
}
