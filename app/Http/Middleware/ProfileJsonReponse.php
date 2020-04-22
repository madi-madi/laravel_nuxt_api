<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;

class ProfileJsonReponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response =  $next($request);

        if(! app()->bound('debugbar') || ! app('debugbar')->isEnabled()){
            return $response;
        }

        if($response instanceof JsonResponse && $request->has('_debug')){
            // $response->setData(array_merge($response->getData(true)),[
            //  '_debugbar'=> app('debugbar')->getData()
            // ]);
            $response->setData(array_merge($response->getData(true),[
                '_debugbar'=> Arr::only(app('debugbar')->getData(),'queries')
            ]));
        }

        return $response;
    }
}
