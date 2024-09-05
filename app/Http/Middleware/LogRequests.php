<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequests
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
        $response = $next($request);

        if(app()->environment('local')){
            $log = [
                'URL' => $request->getUri(),
                'METHOD' => $request->getMethod(),
                'BODY' => $request->all(),
                'USER_ID' => auth()->user()->id,
                'USER_NAME' => auth()->user()->full_name,
                'IP' => $request->ip(),
                'MAC' => exec('getmac')
            ];

            Log::channel('anjaliChemicalsSystem')->info(json_encode($log));
        }

        return $response;

    }
}
