<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppModules;
use App\Models\CustomersCollections;
use App\Models\RoleModule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Helper\Helper;
use App\Models\CustomerLeadContacts;

class CustomerCollectionsController extends Controller
{
     // initial constructor
     public function __construct()
     {
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
 
     //getter function to module id from constructor
     public function getModuleId()
     {
         return $this->module_info->id;
     }
 
     //method to list Customer collection
     public function list_customer_collections($customer_id)
     {   
         if(isset($_GET['q'])){
             $customer_collection_details = CustomersCollections::search(trim($_GET['q']),$customer_id)->orderBy('updated','desc')->paginate(10)->onEachSide(1)->withQueryString(); 
         }else{
             $customer_collection_details = CustomersCollections::where('customer_id', $customer_id)->orderBy('updated','desc')->paginate(10)->onEachSide(1)->withQueryString();
         }
         $modules = RoleModule::get_active_modules_by_role_id();
         $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
         return view('manage-customers.customer-collections.list-customer-collections',[
             'app_modules' => $modules,
             'module_access' => $module_access,
             'customer_id' => $customer_id,
             'customer_collection_details' =>$customer_collection_details,
         ]);
     }

     //method to add customer collections
     public function add_customer_collections($customer_id)
     {
         $modules = RoleModule::get_active_modules_by_role_id();
         $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
         $customer_contacts = CustomerLeadContacts::where('customer_id',$customer_id)->where('isActive',1)->get();
         return view('manage-customers.customer-collections.add-customer-collections',[
             'app_modules' => $modules,
             'module_access' => $module_access,
             'customer_id' => $customer_id,
             'customer_contacts' => $customer_contacts,
         ]);
     }
 
     //method to save customer collections
     public function save_customer_collections($customer_id, Request $request)
     {
         // validate
         $validated = $request->validate([
             'collected_person_name' => 'required',
             'received_money' => 'required|numeric',
             'person_name_collected_from' => 'required',
             'pending_money' => 'required|numeric',
             'pending_money_date' => ($request->pending_money > 0) ? 'required|date|after_or_equal:received_money_date' : 'nullable',
             'received_money_date' => 'required|date|before_or_equal:'.date("Y-m-d"),
             'collection_status' => ($request->pending_money > 0) ? 'required|in:"pending"' : 'required|in:"received"',
             'mode_of_payment' => 'required'
         ],[
            'collection_status.in' => 'This field cannot be Received with amount entered in Money Pending field.'
         ]);
 
 
         $collection_info = CustomersCollections::add_collection($customer_id, Auth::user()->id, $request);
 
         return redirect()->route('viewCollectionDetails_customers', ['customer_id' => $customer_id, 'collection_id' => $collection_info->id]);
     }

     //method to view customer collection detail
    public function view_customer_collection_detail($customer_id, $collection_id)
    {
        $collection_details = CustomersCollections::where('id',$collection_id)->where('customer_id', $customer_id)->first();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-collections.view-customer-collection',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'collection_details' => $collection_details,
        ]);
    }

    //method to edit customer collection detail
    public function edit_customer_collection($customer_id, $collection_id)
    {
        $collection_details = CustomersCollections::where('id',$collection_id)->where('customer_id', $customer_id)->first();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        $customer_contacts = CustomerLeadContacts::where('customer_id',$customer_id)->where('isActive',1)->get();
        return view('manage-customers.customer-collections.edit-customer-collection',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'collection_details' => $collection_details,
            'customer_contacts' => $customer_contacts,
        ]);
    }


    //method to update customer collections
    public function update_customer_collection($customer_id, $collection_id, Request $request)
    {
    
        $validated = $request->validate([
            'collected_person_name' => 'required',
            'received_money' => 'required|numeric',
            'person_name_collected_from' => 'required',
            'pending_money' => 'required|numeric',
            'pending_money_date' => ($request->pending_money > 0) ? 'required|date|after_or_equal:received_money_date' : 'nullable',
            'collection_status' => ($request->pending_money > 0) ? 'required|in:"pending"' : 'required|in:"received"',
            'received_money_date' => 'required|date|before_or_equal:'.date("Y-m-d"),
            'mode_of_payment' => 'required'
        ],[
            'collection_status.in' => 'This field cannot be Received with amount entered in Money Pending field.'
         ]);

        $contact_info = CustomersCollections::update_collection($collection_id, $request);

        return redirect()->route('viewCollectionDetails_customers', ['customer_id' => $customer_id, 'collection_id' => $collection_id]);
    }

    //function to delete collection
    public static function delete_collection($customer_id,$collection_id)
    {
        CustomersCollections::where('id', $collection_id)->delete();

        return redirect()->route('viewCollections_customers',$customer_id);
    }
}
