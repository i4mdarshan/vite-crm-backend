<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\CustomerLeadProfile;
use App\Models\ProductDetails;
use App\Models\RoleModule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AjaxDashboardController extends Controller
{
    //method to show stats
    public static function show_stats(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        // date converted to include higher bound values while querying counts
        $from_date = Carbon::createFromFormat('Y-m-d',$from_date)->startOfDay()->toDateTimeString();
        $to_date = Carbon::createFromFormat('Y-m-d',$to_date)->endOfDay()->toDateTimeString();

        // $total_products = count(ProductDetails::where('isActive',1)->whereBetween('updated',[$from_date,$to_date])->get());
        $total_products = ProductDetails::where('isActive',1)->get();
        
        if(Auth::user()->role_id == config('constants.director_role_id')){
            $total_employees = User::where('isActive',1)->get();
        }else{
            $total_employees = User::where('isActive',1)->where('added_by',Auth::user()->id)->get();
        }

        $total_leads = CustomerLeadProfile::get_leads_customers_data($is_lead=1);
        $total_leads = $total_leads->whereBetween('created',[$from_date,$to_date])->get();
        
        $total_customers = CustomerLeadProfile::get_leads_customers_data($is_lead=0);
        $total_customers = $total_customers->whereBetween('updated',[$from_date,$to_date])->get();

        $master_count_stats_html = "
        <div class='row mb-5'>
            <div class='col-xl-3 col-lg-6'>
                <div class='card card-stats mb-4 mb-xl-0 dash-card-style'>
                    <div class='card-body'>
                    <div class='row'>
                        <div class='col'>
                            <h5 class='card-title text-uppercase text-muted mb-0'>Leads</h5>
                            <span class='h2 font-weight-bold mb-0'>".count($total_leads)."</span>
                        </div>
                        <div class='col-auto'>
                            <div class='icon icon-shape bg-main-cl1 text-white rounded-circle shadow'>
                                <i class='ni ni-building'></i>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class='col-xl-3 col-lg-6'>
                <div class='card card-stats mb-4 mb-xl-0 dash-card-style'>
                    <div class='card-body '>
                    <div class='row'>
                        <div class='col'>
                            <h5 class='card-title text-uppercase text-muted mb-0'>Employees</h5>
                            <span class='h2 font-weight-bold mb-0'>".count($total_employees)."</span>
                        </div>
                        <div class='col-auto'>
                            <div class='icon icon-shape bg-main-cl2 text-white rounded-circle shadow'>
                                <i class='ni ni-circle-08'></i>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class='col-xl-3 col-lg-6'>
                <div class='card card-stats mb-4 mb-xl-0 dash-card-style'>
                    <div class='card-body '>
                    <div class='row'>
                        <div class='col'>
                            <h5 class='card-title text-uppercase text-muted mb-0'>Customers</h5>
                            <span class='h2 font-weight-bold mb-0'>".count($total_customers)."</span>
                        </div>
                        <div class='col-auto'>
                            <div class='icon icon-shape bg-main-cl3 text-white rounded-circle shadow'>
                                <i class='ni ni-credit-card'></i>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class='col-xl-3 col-lg-6'>
                <div class='card card-stats mb-4 mb-xl-0 dash-card-style'>
                    <div class='card-body '>
                    <div class='row'>
                        <div class='col'>
                            <h5 class='card-title text-uppercase text-muted mb-0'>Products</h5>
                            <span class='h2 font-weight-bold mb-0'>".count($total_products)."</span>
                        </div>
                        <div class='col-auto'>
                            <div class='icon icon-shape bg-main-cl4 text-white rounded-circle shadow'>
                                <i class='fas fa-coins'></i>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>";


        $modules = RoleModule::get_active_modules_by_role_id();
        // dd($modules);

        $dynamic_buttons_html = "";

        foreach ($modules as $module) {
            if($module->module->slug == "home" || $module->module->slug == "manage_reports" || $module->module->slug == "manage_quotations" || $module->modify_access == 0 || $module->module->slug == "manage_firms"){
                continue;
            }
            $module_slug = $module->module->slug;
            $module_slug = explode('_',$module_slug);
            $button_route = "add_".$module_slug[1];
            // dd($button_route);
            $dynamic_buttons_html .= "
            <div class='col-xl-3 col-lg-6'>
                <a href=".route($button_route)." type='button' class='btn-icon-clipboard dash-card-style shadow border-color'>
                    <div class='d-flex justify-content-between'>
                        <span class='h4'>Add ".ucwords($module_slug[1])."</span>
                        <i class='ni ni-bold-right'></i>
                    </div>
                </a>
            </div>
            ";
        }

        $quick_action_buttons_html = "<div class='row'>".$dynamic_buttons_html."</div>";


        return json_encode(array(
            'master_count_stats_html' => $master_count_stats_html,
            'quick_action_buttons_html' => $quick_action_buttons_html,
        ));

    }
}
