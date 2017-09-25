<?php

namespace App\Http\Middleware;

use App\Repositories\Response;

class FormattingRequestMiddleware
{
    public function handle($request, \Closure $next)
    {
        $data = $request['c'];

        $respond = new Response($request);

        if(! isset($request['c']))
        {
           return $respond ->error('param c cant empty');
        }

        $r = json_decode($data, true);

        if (isset($r['data']) AND is_array($r['data'])) {

            $request->merge(['data' => json_encode($r['data'])]);

            foreach ($r['data'] as $key => $value) {
                $request->merge([$key => $value]);
            }
        } else {
            return $respond ->error('param data cant empty');
        }

        if (isset($r['meta']) AND is_array($r['meta'])) {

            $request->merge(['meta' => json_encode($r['meta'])]);

            foreach ($r['meta'] as $key => $value) {
                $request->merge([$key => $value]);
            }
        }

        $request = null;

        return $next($request);
    }
}