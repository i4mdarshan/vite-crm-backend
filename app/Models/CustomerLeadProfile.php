<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CustomerLeadProfile extends Model
{
    use HasFactory;
    //method to get all customers
    public static function get_all_customers()
    {
        return CustomerLeadProfile::where('isLead', 0)->where('firm_id', Auth::user()->firm_id)->where('isActive', 1)->whereRaw('(employee_id = ' . Auth::user()->id)->orWhereRaw('customer_assigned_to = ' . Auth::user()->id . ')')->paginate(15);
    }
    //function to get user details
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    //relation to get cutomer/lead contacts
    public function contacts()
    {
        return $this->hasMany(CustomerLeadContacts::class, 'customer_id');
    }

    //relation to get details of assigned to employee
    public function assigned()
    {
        return $this->belongsTo(User::class, 'customer_assigned_to');
    }

    // relation to get firm details
    public function firm()
    {
        return $this->belongsTo(Firms::class, 'firm_id');
    }

    //relation to get state details
    public function state()
    {
        return $this->belongsTo(States::class, 'customer_state', 'state_id');
    }

    //relation to get office state details
    public function state_office()
    {
        return $this->belongsTo(States::class, 'office_state', 'state_id');
    }

    //scope method to search customer 
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('customer_name', 'LIKE', $term)
                ->orWhere('customer_type', 'LIKE', $term)
                ->orWhereHas('employee', function ($query) use ($term) {
                    $query->where('full_name', 'LIKE', $term);
                })->orWhereHas('assigned', function ($query) use ($term) {
                    $query->where('full_name', 'LIKE', $term);
                })->orWhereHas('contacts', function($query) use ($term){
                    $query->where('contact_person_name', 'LIKE', $term);
                });
        });
    }

    /**
     * 
     * function to get the leads or customers for the loggedin user.  
     **/    
    public static function get_leads_customers_data($is_lead,$search_by = null){
        // this array is used to extract the logged in user employee id and its child employees ids
        $employee_ids = [Auth::user()->id];
        $auth_child_employees = Auth::user()->child_employees;
        if(count($auth_child_employees) > 0){
            foreach ($auth_child_employees as $employee) {
                array_push($employee_ids,$employee->id);
            }
        }

        // query to get the data according to the conditions
        $leads_customers_result = CustomerLeadProfile::where('isLead',$is_lead)
        ->when(!is_null($search_by), function ($query) use($search_by){
            $query->search($search_by);
        })
        ->when(Auth::user()->role_id != config('constants.director_role_id'), function($query) use($employee_ids){
            $query->where(function($query) use ($employee_ids){
                $query->orWhere(function($query) use ($employee_ids){
                    $query->whereIn('employee_id',$employee_ids);
                    $query->orWhereIn('customer_assigned_to',$employee_ids);
                });
            });
        })
        ->orderBy('created', 'DESC');
        return $leads_customers_result;
    }


    //function to save customer
    public static function add_customers($request, $employee_id)
    {
        $customer_info = new CustomerLeadProfile();
        $customer_info->employee_id = $employee_id;
        if (Auth::user()->role_id == config("constants.director_role_id")) {
            $assigned_to = User::findOrFail($request->customer_assigned_to);
            $customer_info->firm_id = $assigned_to->firm_id;
        } else {
            $customer_info->firm_id = Auth::user()->firm_id;
        }
        $customer_info->customer_name = $request->customer_name;
        $customer_info->customer_owner_name = $request->customer_owner_name;
        $customer_info->customer_gst_no = $request->customer_gst_no;
        $customer_info->customer_type = $request->customer_type;
        $customer_info->customer_assigned_to = $request->customer_assigned_to;
        $customer_info->customer_website = $request->customer_website;
        $customer_info->customer_no1 = $request->customer_no1;
        $customer_info->customer_no2 = $request->customer_no2;
        $customer_info->customer_mail = isset($request->customer_mail) ? $request->customer_mail : null;
        $customer_info->customer_mail2 = $request->customer_mail2;
        $customer_info->manager_name = isset($request->manager_name) ? $request->manager_name : null;
        $customer_info->manager_number = isset($request->manager_number) ? $request->manager_number : null;
        $customer_info->accountant_name = isset($request->accountant_name) ? $request->accountant_name : null;
        $customer_info->accountant_number = isset($request->accountant_number) ? $request->accountant_number : null;
        $customer_info->customer_country = $request->customer_country;
        $customer_info->customer_state = $request->customer_state;
        $customer_info->customer_district = $request->customer_district;
        $customer_info->customer_taluka = $request->customer_taluka;
        $customer_info->customer_pin_code = $request->customer_pin_code;
        $customer_info->office_country = isset($request->office_country) ? $request->office_country : null;
        $customer_info->office_state = isset($request->office_state) ? $request->office_state : null;
        $customer_info->office_district = isset($request->office_district) ? $request->office_district : null;
        $customer_info->office_taluka = isset($request->office_taluka) ? $request->office_taluka : null;
        $customer_info->office_pin_code = isset($request->office_pin_code) ? $request->office_pin_code : null;

        $address = $request->address_line_1 . "__" . $request->address_line_2;

        if (isset($request->address_line_3)) {
            $address .= "__" . $request->address_line_3;
        }

        if (isset($request->address_line_4)) {
            $address .= "__" . $request->address_line_4;
        }

        if (isset($request->address_line_5)) {
            $address .= "__" . $request->address_line_5;
        }

        if (isset($request->address_line_6)) {
            $address .= "__" . $request->address_line_6;
        }

        $customer_info->customer_address = $address;

        //office address//
        $address_office = "";

        if (isset($request->o_address_line_1)) {
            $address_office .= "__" . $request->o_address_line_1;
        }

        if (isset($request->o_address_line_2)) {
            $address_office .= "__" . $request->o_address_line_2;
        }

        if (isset($request->o_address_line_3)) {
            $address_office .= "__" . $request->o_address_line_3;
        }

        if (isset($request->o_address_line_4)) {
            $address_office .= "__" . $request->o_address_line_4;
        }

        if (isset($request->o_address_line_5)) {
            $address_office .= "__" . $request->o_address_line_5;
        }

        if (isset($request->o_address_line_6)) {
            $address_office .= "__" . $request->o_address_line_6;
        }

        $customer_info->office_address = ($address_office != "") ? $address_office : null;

        $customer_info->customer_notes = $request->customer_notes;
        $customer_info->isActive = $request->isActive;
        $customer_info->created = date("Y-m-d h:i:s");
        $customer_info->updated = date("Y-m-d h:i:s");
        $customer_info->save();

        return $customer_info;
    }

    //method to update customer
    public static function update_customer($customer_id, $request)
    {
        $customer_info = CustomerLeadProfile::findOrFail($customer_id);
        $customer_info->customer_name = isset($request->customer_name) ? $request->customer_name : $customer_info->customer_name;
        $customer_info->customer_gst_no = isset($request->customer_gst_no) ? $request->customer_gst_no : $customer_info->customer_gst_no;
        $customer_info->customer_owner_name = isset($request->customer_owner_name) ? $request->customer_owner_name : $customer_info->customer_owner_name;
        $customer_info->customer_type = isset($request->customer_type) ? $request->customer_type : $customer_info->customer_type;
        $customer_info->customer_assigned_to = isset($request->customer_assigned_to) ? $request->customer_assigned_to : $customer_info->customer_assigned_to;
        $customer_info->customer_website = $request->customer_website;
        $customer_info->customer_no1 = isset($request->customer_no1) ? $request->customer_no1 : $customer_info->customer_no1;
        $customer_info->customer_no2 = $request->customer_no2;
        $customer_info->customer_mail = isset($request->customer_mail) ? $request->customer_mail : $customer_info->customer_mail;
        $customer_info->customer_mail2 = $request->customer_mail2;
        $customer_info->manager_name = isset($request->manager_name) ? $request->manager_name : $customer_info->manager_name;
        $customer_info->manager_number = isset($request->manager_number) ? $request->manager_number : $customer_info->manager_number;
        $customer_info->accountant_name = isset($request->accountant_name) ? $request->accountant_name : $customer_info->accountant_name;
        $customer_info->accountant_number = isset($request->accountant_number) ? $request->accountant_number : $customer_info->accountant_number;
        $customer_info->customer_country = isset($request->customer_country) ? $request->customer_country : $customer_info->customer_country;
        $customer_info->customer_state = isset($request->customer_state) ? $request->customer_state : $customer_info->customer_state;
        $customer_info->customer_district = isset($request->customer_district) ? $request->customer_district : $customer_info->customer_district;
        $customer_info->customer_taluka = isset($request->customer_taluka) ? $request->customer_taluka : $customer_info->customer_taluka;
        $customer_info->customer_pin_code = isset($request->customer_pin_code) ? $request->customer_pin_code : $customer_info->customer_pin_code;
        $customer_info->office_country = isset($request->office_country) ? $request->office_country : $customer_info->office_country;
        $customer_info->office_state = isset($request->office_state) ? $request->office_state : $customer_info->office_state;
        $customer_info->office_district = isset($request->office_district) ? $request->office_district : $customer_info->office_district;
        $customer_info->office_taluka = isset($request->office_taluka) ? $request->office_taluka : $customer_info->office_taluka;
        $customer_info->office_pin_code = isset($request->office_pin_code) ? $request->office_pin_code : $customer_info->office_pin_code;

        $address = $request->address_line_1 . "__" . $request->address_line_2;

        if (isset($request->address_line_3)) {
            $address .= "__" . $request->address_line_3;
        }

        if (isset($request->address_line_4)) {
            $address .= "__" . $request->address_line_4;
        }

        if (isset($request->address_line_5)) {
            $address .= "__" . $request->address_line_5;
        }

        if ($request->address_line_6) {
            $address .= "__" . $request->address_line_6;
        }

        $customer_info->customer_address = $address;

        //office address//

        // $address_office = $request->o_address_line_1 . "__" . $request->o_address_line_2;
        //office address//
        $address_office = "";

        if (isset($request->o_address_line_1)) {
            $address_office .= "__" . $request->o_address_line_1;
        }

        if (isset($request->o_address_line_2)) {
            $address_office .= "__" . $request->o_address_line_2;
        }

        if (isset($request->o_address_line_3)) {
            $address_office .= "__" . $request->o_address_line_3;
        }

        if (isset($request->o_address_line_4)) {
            $address_office .= "__" . $request->o_address_line_4;
        }

        if (isset($request->o_address_line_5)) {
            $address_office .= "__" . $request->o_address_line_5;
        }

        if (isset($request->o_address_line_6)) {
            $address_office .= "__" . $request->o_address_line_6;
        }

        $customer_info->office_address = ($address_office != "") ? $address_office : null;

        $customer_info->customer_notes = isset($request->customer_notes) ? $request->customer_notes : $customer_info->customer_notes;
        $customer_info->isActive = isset($request->isActive) ? $request->isActive : $customer_info->isActive;
        $customer_info->updated = date("Y-m-d h:i:s");
        $customer_info->save();

        return $customer_info;
    }

    //function to save lead
    public static function add_lead($request)
    {
        $lead_info = new CustomerLeadProfile;
        $lead_info->employee_id = Auth::user()->id;

        if (Auth::user()->role_id == config("constants.director_role_id")) {
            $assigned_to = User::findOrFail($request->lead_assigned_to);
            $lead_info->firm_id = $assigned_to->firm_id;
        } else {
            $lead_info->firm_id = Auth::user()->firm_id;
        }

        $lead_info->customer_name = $request->lead_name;
        $lead_info->customer_owner_name = $request->lead_owner_name;
        $lead_info->customer_gst_no = $request->lead_gst_no;
        $lead_info->customer_type = $request->lead_type;
        $lead_info->customer_assigned_to = $request->lead_assigned_to;
        $lead_info->customer_website = $request->lead_web;
        $lead_info->customer_no1 = $request->lead_no_1;
        $lead_info->customer_no2 = $request->lead_no_2;
        $lead_info->customer_mail = isset($request->lead_mail_1) ? $request->lead_mail_1 : null;
        $lead_info->customer_mail2 = $request->lead_mail_2;
        $lead_info->manager_name = isset($request->lead_manager_name) ? $request->lead_manager_name : null;
        $lead_info->manager_number = isset($request->lead_manager_number) ? $request->lead_manager_number : null;
        $lead_info->accountant_name = isset($request->lead_accountant_name) ? $request->lead_accountant_name : null;
        $lead_info->accountant_number = isset($request->lead_accountant_number) ? $request->lead_accountant_number : null;
        $lead_info->customer_district = $request->lead_district;
        $lead_info->customer_state = $request->lead_state;
        $lead_info->customer_taluka = $request->lead_taluka;
        $lead_info->customer_pin_code = $request->lead_pin_code;
        $lead_info->customer_country = $request->lead_country;
        $lead_info->office_country = isset($request->lead_office_country) ? $request->lead_office_country : null;
        $lead_info->office_state = isset($request->lead_office_state) ? $request->lead_office_state : null;
        $lead_info->office_district = isset($request->lead_office_district) ? $request->lead_office_district : null;
        $lead_info->office_taluka = isset($request->lead_office_taluka) ? $request->lead_office_taluka : null;
        $lead_info->office_pin_code = isset($request->lead_office_pin_code) ? $request->lead_office_pin_code : null;

        $address = $request->address_line_1 . "__" . $request->address_line_2;

        if (isset($request->address_line_3)) {
            $address .= "__" . $request->address_line_3;
        }

        if (isset($request->address_line_4)) {
            $address .= "__" . $request->address_line_4;
        }

        if (isset($request->address_line_5)) {
            $address .= "__" . $request->address_line_5;
        }

        if (isset($request->address_line_6)) {
            $address .= "__" . $request->address_line_6;
        }

        $lead_info->customer_address = $address;

        //office address//

        $address_office = "";
        if (isset($request->o_address_line_1)) {
            $address_office .= "__" . $request->o_address_line_1;
        }

        if (isset($request->o_address_line_2)) {
            $address_office .= "__" . $request->o_address_line_2;
        }

        // $address_office = $request->o_address_line_1 . "__" . $request->o_address_line_2;

        if (isset($request->o_address_line_3)) {
            $address_office .= "__" . $request->o_address_line_3;
        }

        if (isset($request->o_address_line_4)) {
            $address_office .= "__" . $request->o_address_line_4;
        }

        if (isset($request->o_address_line_5)) {
            $address_office .= "__" . $request->o_address_line_5;
        }

        if (isset($request->o_address_line_6)) {
            $address_office .= "__" . $request->o_address_line_6;
        }

        $lead_info->office_address = $address_office;

        $lead_info->isActive = $request->isActive;
        $lead_info->isLead = 1;
        $lead_info->created = date("Y-m-d h:i:s");
        $lead_info->updated = date("Y-m-d h:i:s");
        $lead_info->save();

        return $lead_info;
    }


    //method to update lead
    public static function update_lead($lead_id, $request)
    {
        $lead_info = CustomerLeadProfile::findOrFail($lead_id);
        $lead_info->customer_name = isset($request->lead_name) ? $request->lead_name : $lead_info->customer_name;
        $lead_info->customer_gst_no = isset($request->lead_gst_no) ? $request->lead_gst_no : $lead_info->customer_gst_no;
        $lead_info->customer_owner_name = isset($request->lead_owner_name) ? $request->lead_owner_name : $lead_info->customer_owner_name;
        $lead_info->customer_type = isset($request->lead_type) ? $request->lead_type : $lead_info->customer_type;
        $lead_info->customer_website = $request->lead_web;
        $lead_info->customer_no1 = isset($request->lead_no_1) ? $request->lead_no_1 : $lead_info->customer_no1;
        $lead_info->customer_no2 = $request->lead_no_2;
        $lead_info->customer_mail = isset($request->lead_mail_1) ? $request->lead_mail_1 : $lead_info->customer_mail;
        $lead_info->customer_mail2 = $request->lead_mail_2;
        $lead_info->manager_name = isset($request->lead_manager_name) ? $request->lead_manager_name : $lead_info->manager_name;
        $lead_info->manager_number = isset($request->lead_manager_number) ? $request->lead_manager_number : $lead_info->manager_number;
        $lead_info->accountant_name = isset($request->lead_accountant_name) ? $request->lead_accountant_name : $lead_info->accountant_name;
        $lead_info->accountant_number = isset($request->lead_accountant_number) ? $request->lead_accountant_number : $lead_info->accountant_number;
        $lead_info->customer_district = isset($request->lead_district) ? $request->lead_district : $lead_info->customer_district;
        $lead_info->customer_state = isset($request->lead_state) ? $request->lead_state : $lead_info->customer_state;
        $lead_info->customer_taluka = isset($request->lead_taluka) ? $request->lead_taluka : $lead_info->customer_taluka;
        $lead_info->customer_pin_code = isset($request->lead_pin_code) ? $request->lead_pin_code : $lead_info->customer_pin_code;
        $lead_info->customer_country = isset($request->lead_country) ? $request->lead_country : $lead_info->customer_country;
        $lead_info->office_country = isset($request->lead_office_country) ? $request->lead_office_country : $lead_info->office_country;
        $lead_info->office_state = isset($request->lead_office_state) ? $request->lead_office_state : $lead_info->office_state;
        $lead_info->office_district = isset($request->lead_office_district) ? $request->lead_office_district : $lead_info->office_district;
        $lead_info->office_taluka = isset($request->lead_office_taluka) ? $request->lead_office_taluka : $lead_info->office_taluka;
        $lead_info->office_pin_code = isset($request->lead_office_pin_code) ? $request->lead_office_pin_code : $lead_info->office_pin_code;

        $address = $request->address_line_1 . "__" . $request->address_line_2;

        if (isset($request->address_line_3)) {
            $address .= "__" . $request->address_line_3;
        }

        if (isset($request->address_line_4)) {
            $address .= "__" . $request->address_line_4;
        }

        if (isset($request->address_line_5)) {
            $address .= "__" . $request->address_line_5;
        }

        if ($request->address_line_6) {
            $address .= "__" . $request->address_line_6;
        }

        $lead_info->customer_address = $address;

        //office address//

        $address_office = "";
        if (isset($request->o_address_line_1)) {
            $address_office .= "__" . $request->o_address_line_1;
        }

        if (isset($request->o_address_line_2)) {
            $address_office .= "__" . $request->o_address_line_2;
        }

        // $address_office = $request->o_address_line_1 . "__" . $request->o_address_line_2;

        if (isset($request->o_address_line_3)) {
            $address_office .= "__" . $request->o_address_line_3;
        }

        if (isset($request->o_address_line_4)) {
            $address_office .= "__" . $request->o_address_line_4;
        }

        if (isset($request->o_address_line_5)) {
            $address_office .= "__" . $request->o_address_line_5;
        }

        if (isset($request->o_address_line_6)) {
            $address_office .= "__" . $request->o_address_line_6;
        }

        $lead_info->office_address = ($address_office != "") ? $address_office : null;

        $lead_info->customer_assigned_to = isset($request->lead_assigned_to) ? $request->lead_assigned_to : $lead_info->customer_assigned_to;
        $lead_info->isActive = isset($request->lead_status) ? $request->lead_status : $lead_info->isActive;
        $lead_info->updated = date("Y-m-d h:i:s");
        $lead_info->save();

        return $lead_info;
    }

    public $timestamps = false;
    protected $table = 'customer_lead_profile';
}
