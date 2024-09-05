<?php

namespace App\Http\Controllers;

use App\Models\AppModules;
use App\Models\CustomerLeadProfile;
use App\Models\ManageAnnouncements;
use App\Models\ManageLead;
use App\Models\ProductDetails;
use App\Models\RoleModule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $route_name = Route::currentRouteName();
        $this->middleware('permissioncheck:'.$route_name);

        $routeParse = explode('_',$route_name);
        if($route_name == 'home'){
            $routeName = 'home';
        }else{
            $routeName = 'manage_'.$routeParse[1];
        }

        $this->module_info = AppModules::get_module_id_by_slug($routeName);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //stats number 
        $total_employees = count(User::where('isActive',1)->get());
        $total_products = count(ProductDetails::where('isActive',1)->get());
        $total_leads = count(CustomerLeadProfile::where('isLead',1)->where('isActive',1)->get());
        $modules = RoleModule::get_active_modules_by_role_id();
        $all_announcements = ManageAnnouncements::get_all_announcements();
        return view('home',[
            'app_modules' => $modules,
            'total_employees' => $total_employees,
            'total_products' => $total_products,
            'total_leads' => $total_leads,
            'all_announcements' => $all_announcements,
        ]);
    }

}
