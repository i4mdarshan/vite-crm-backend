<?php

namespace App\Http\Middleware;

use App\Models\AppModules;
use App\Models\RoleModule;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutePermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,  $route_name)
    {
        // dd($route_name);
        $routeParse = explode('_',$route_name);
        if($route_name == 'home'){
            $routeName = 'home';
        }else{
            $routeName = 'manage_'.$routeParse[1];
        }

        // dd($routeParse);
        //get all module ids of role_id
        $module_ids = RoleModule::where('role_id',Auth::user()->role_id)->pluck('module_id');
        //get module slugs in array according to module_ids array
        $module_slugs = AppModules::whereIn('id', $module_ids)->pluck('slug')->toArray();
        // dd(in_array($routeName,$module_slugs));

        if(in_array($routeName,$module_slugs)){
            return $next($request);
        }else if(!in_array('home',$module_slugs)){  
            return redirect($module_slugs[0]);
        }else{
            return redirect('/access_forbidden');
        }

        // abort(403);
    }
}
