<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\ResponseFactory;

use Tymon\JWTAuth\Middleware\BaseMiddleware as Base;

class BaseMiddleware extends Base
{
    /**
     * @var \Illuminate\Routing\ResponseFactory
     */
    protected $response;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;

    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $auth;

    /**
     * Create a new BaseMiddleware instance
     *
     * @param \Illuminate\Routing\ResponseFactory $response
     * @param \Illuminate\Events\Dispatcher       $events
     * @param \Tymon\JWTAuth\JWTAuth              $auth
     */
    public function __construct(ResponseFactory $response, Dispatcher $events, JWTAuth $auth)
    {
        parent::__construct($response, $events, $auth);

        $this->response = $response;
        $this->events = $events;
        $this->auth = $auth;
    }

    /**
     * Fire event and return the response
     *
     * @param  string  $event
     * @param  string  $error
     * @param  integer $status
     * @param  array   $payload
     *
     * @return mixed
     */
    protected function respond($event, $error, $status, $payload = [])
    {
        $response = $this->events->fire($event, $payload, true);

        $result['c']['status']['error'] = true;
        $result['c']['status']['message'] = $error;
        $result['c']['status']['code'] = $status;
        $result['c']['data'] = (object)[];
        $result['c']['token'] = null;
        $result['c']['timestamp'] = time();

        return $response ?: $this->response->json($result, $status);
    }
}
