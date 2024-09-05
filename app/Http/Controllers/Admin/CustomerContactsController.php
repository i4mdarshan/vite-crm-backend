<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\CustomerLeadContacts;
use App\Models\RoleModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class CustomerContactsController extends Controller
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

    //method to view Customer contacts
    public function view_customer_contacts($customer_id)
    {   
        if(isset($_GET['q'])){
            $customer_contact_details = CustomerLeadContacts::search(trim($_GET['q']),$customer_id)->paginate(10)->onEachSide(1)->withQueryString(); 
        }else{
            $customer_contact_details = CustomerLeadContacts::where('customer_id', $customer_id)->paginate(10)->onEachSide(1)->withQueryString();
        }
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-contacts.list-customer-contacts',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'customer_contact_details' =>$customer_contact_details,
        ]);
    }

    //method to view customer contact detail
    public function view_customer_contact_detail($customer_id, $contact_id)
    {
        $contact_details = CustomerLeadContacts::where('id',$contact_id)->where('customer_id', $customer_id)->first();
        // dd($contact_details);
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-contacts.view-customer-contact',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'contact_details' => $contact_details,
        ]);
    }

    //method to add customer contacts
    public function add_customer_contacts($customer_id)
    {
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-contacts.add-customer-contacts',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
        ]);
    }

    //method to save customer contacts
    public function save_customer_contacts($customer_id, Request $request)
    {
        // validate
        $validated = $request->validate([
            'person_name' => 'required|max:40',
            'phone_number' => 'required|digits:10|unique:customer_lead_contacts,contact_number',
            'designation' => 'required|max:30',
            'person_email' => 'required|email|max:50|unique:customer_lead_contacts,contact_email',
            'contact_status' => 'required',
            'notes' => 'nullable|max:1500',
            'contact_image' => 'nullable|mimes:jpg,jpeg,png|max:2048'
        ]);


        $contact_info = CustomerLeadContacts::add_contact($customer_id, Auth::user()->id, $request);

        return redirect()->route('viewContactDetails_customers', ['customer_id' => $customer_id, 'contact_id' => $contact_info->id]);
    }

    //method to edit customer contact detail
    public function edit_customer_contact($customer_id, $contact_id)
    {
        $contact_details = CustomerLeadContacts::where('id',$contact_id)->where('customer_id', $customer_id)->first();
        // dd($contact_details);
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-contacts.edit-customer-contact',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'contact_details' => $contact_details,
        ]);
    }


    //method to update customer contacts
    public function update_customer_contact($customer_id, $contact_id, Request $request)
    {
        // validate
        // dd($request);
        $validated = $request->validate([
            'person_name' => 'required|max:40',
            'phone_number' => 'required|digits:10|unique:customer_lead_contacts,contact_number,'.$contact_id,
            'designation' => 'required|max:30',
            'person_email' => 'required|email|max:50|unique:customer_lead_contacts,contact_email,'.$contact_id,
            'contact_status' => 'required',
            'notes' => 'nullable|max:1500',
            'contact_image' => 'nullable|mimes:jpg,jpeg,png|max:2048'
        ]);

        $contact_info = CustomerLeadContacts::update_contact($contact_id, $request);

        return redirect()->route('viewContactDetails_customers', ['customer_id' => $customer_id, 'contact_id' => $contact_id]);
    }
}
