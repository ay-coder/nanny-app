<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use App\Http\Transformers\UserTransformer;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class BaseApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * UserTransformer
     *
     * @var object
     */
    protected $userTransformer;

    /**
     * __construct
     * 
     * @param UserTransformer $userTransformer
     */
    public function __construct()
    {
        $this->userTransformer = new UserTransformer;
    }

    /**
     * default status code
     *
     * @var integer
     */
    protected $statusCode = 200;
    
    /**
     * get the status code
     *
     * @return statuscode
     */
    
    public function getStatusCode()
    {
    	return $this->statusCode;
    }

    /**
     * Get JWT Authenticated User
     *
     * @return object
     */
    public function getAuthenticatedUser()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    /**
     * Get Api User Info
     * 
     * @return array
     */
    public function getApiUserInfo()
    {
        return  $this->userTransformer->getUserInfo($this->getAuthenticatedUser());
    }

    /**
     * set the status code
     *
     * @param int $statusCode
     * @return mix
     */
    public function setStatusCode($statusCode = 200)
    {
    	$this->statusCode = $statusCode;

    	return $this;
    }

    /**
     * Success Response
     * 
     * @param array $data
     * @param string $message
     * @param int $code
     * @return json|string
     */
    public function successResponse($data = array(), $message = 'Success', $code = 200)
    {
        $response = [
            'data'      => $data,
            'status'    => true,
            'message'   => $message ? $message : 'Success',
            'code'      => $code ? $code : $this->getStatusCode()
        ];

        return response()->json([
            (object)$response],
            $this->getStatusCode()  
        );
    }

    /**
     * Failure Response
     * 
     * @param array $data
     * @param string $message
     * @param int $code
     * @return json|string
     */
    public function failureResponse($data = array(), $message = 'Failure', $code = null)
    {
        $response = [
            'error'     => $data,
            'status'    => false,
            'message'   => $message ? $message : 'Failure',
            'code'      => $code ? $code : $this->getStatusCode()
        ];

        return response()->json([
            (object)$response],
            $this->getStatusCode()  
        );
    }

    /**
     * respond with pagincation
     *
     * @param Paginator $lessions
     * @param array $data
     * @return mix
     */
    public function respondWithPagination($lessions, $data)
    {
        $data = array_merge($data, [
            'paginator'   => [
                'total_count'   => $lessions->total(),
                'total_pages'   => ceil($lessions->total() / $lessions->perPage()),
                'current_page'  => $lessions->currentPage(),
                'limit'         => $lessions->perPage()
             ]
        ]);
        return $this->respond($data);
    }
}
