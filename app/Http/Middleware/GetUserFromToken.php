<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class GetUserFromToken extends BaseMiddleware
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
        $auth_error = 403;
        // $headers = apache_request_headers();
        // $authenticateHeader = isset($headers['Authorization']) ? $headers['Authorization'] : "";
        // if (strlen($authenticateHeader) < 1) {
        //     return $this->respond('tymon.jwt.absent', trans('auth.token.not_provided'), $auth_error);
        // }

        // $temp = explode("Bearer ", $authenticateHeader);
        // $token = $temp[1];

        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return $this->respond('tymon.jwt.absent', trans('auth.token.not_provided'), $auth_error);
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return $this->respond('tymon.jwt.expired', trans('auth.token.expired'), $auth_error, [$e]);
        } catch (JWTException $e) {
            return $this->respond('tymon.jwt.invalid', trans('auth.token.invalid'), $auth_error, [$e]);
        }

        if (! $user) {
            return $this->respond('tymon.jwt.user_not_found', 'user_not_found', 401);
        }

        $this->events->fire('tymon.jwt.valid', $user);
    
        return $next($request);
    }
}
