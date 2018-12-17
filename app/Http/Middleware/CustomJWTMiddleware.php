<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use App\Http\Middleware\BaseJWTMiddleware;

class CustomJWTMiddleware extends BaseJWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
        }

        $invalidTokenCode = 200;
        $invalidDataCode  = 999;

        try 
        {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) 
        {
            $respond = [
                'success'   => false,
                'status'    => false,
                'code'      => $invalidDataCode,
                'message'   => 'Invalid Token - Wrong Token !'
            ];
            return $this->respond('tymon.jwt.invalid', $respond, $invalidTokenCode, [$e]);
        } catch (JWTException $e)
        {
            $respond = [
                'success'   => false,
                'status'    => false,
                'code'      => $invalidDataCode,
                'message'   => 'Invalid Token - Wrong Token !'
            ];
            return $this->respond('tymon.jwt.invalid', $respond, $invalidTokenCode, [$e]);
        }

        if (! $user)
        {
            $respond = [
                'success'   => false,
                'status'    => false,
                'code'      => $invalidDataCode,
                'message'   => 'Opps, User not Found !'
            ];
            return $this->respond('tymon.jwt.invalid', $respond, $invalidTokenCode, [$e]);
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }
}
