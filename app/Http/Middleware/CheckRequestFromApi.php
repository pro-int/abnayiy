<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRequestFromApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $except = [
            'transaction_response',
            'payfort_processResponse',
            'ApiWebHook'
        ];
        
        if (! $request->wantsJson() && ! in_array($request->route()->getName(),$except)) {
            abort(403);
        }

        if ($request->route()->getPrefix() == 'api/noor' &&  $request->apikey != env('NOOR_CLIENT_API', 'g24565t214651uyw34tr234tf')) {
            abort(401);
        }
        
        return $next($request);
    }
}
