<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\CustomerLeadProfile;
use App\Models\CustomerLeadComplaints;
use App\Models\CustomerLeadOrders;
use App\Models\CustomerOrders;
use App\Models\CustomersCollections;
use App\Models\CustomerLeadCalls;
use App\Models\CustomerLeadAppointments;
use App\Models\RoleModule;
use App\Models\User;
use App\Exports\CustomersCollectionsExport;
use App\Exports\LeadsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Maatwebsite\Excel\Excel;

use function Psy\debug;

class ReportController extends Controller
{
    // initial constructor
    public function __construct()
    {
        $route_name = Route::currentRouteName();
        $this->middleware('permissioncheck:' . $route_name);

        $routeParse = explode('_', $route_name);
        if ($route_name == 'home') {
            $routeName = 'home';
        } else {
            $routeName = 'manage_' . $routeParse[1];
        }

        $this->module_info = AppModules::get_module_id_by_slug($routeName);
    }

    //getter function to module id from constructor
    public function getModuleId()
    {
        return $this->module_info->id;
    }


    public function show_reports()

    {

        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-reports.showreports', [
            'app_modules' => $modules,
        ]);
    }

    public function show_lead_reports(Request $request)
    {

        if (Auth::user()->id == config('constants.director_role_id')) {
            $my_employees = User::where('isActive', 1)->get();
        } else {
            $my_employees = User::where('added_by', Auth::user()->id)->where('isActive', 1)->get();
        }

        // validate the form data
        $validated = $request->validate([
            'added_by' => "nullable|integer|exists:users,id",
            'assigned_to' => "nullable|integer|exists:users,id",
            'from_date' => "nullable|date|date_format:Y-m-d",
            'to_date' => ($request->from_date) ? "required|date|after_or_equal:from_date" : "nullable",
        ],[
            'to_date.after_or_equal' => 'The Start Date must be a date after or equal to End Date.',
            'to_date.required' => 'A valid End Date must be selected with a Start Date.',
            'assigned_to.exists' => 'The selected assigned employee is invalid.',
            'added_by.exists' => 'The selected assigned employee is invalid.'
        ]);

        // dd($request);
        $all_leads = array();
        $all_leads = CustomerLeadProfile::get_leads_customers_data(1);

        //If the request is get then show all the collections else according to the filters
        $employee_assigned_filter_id = null;
        $from_filter_date = null;
        $to_filter_date = null;
        $added_by = NULL;
        
        if($request->isMethod('post')){
            $employee_assigned_filter_id = !is_null($request->assigned_to) ? $request->assigned_to : null;
            $from_filter_date = !is_null($request->from_date) ? $request->from_date : null;
            $to_filter_date = !is_null($request->to_date) ? $request->to_date : null;
            $added_by = !is_null($request->added_by) ? $request->added_by : null;
        }

        if ($from_filter_date && $to_filter_date) {
            $all_leads->whereBetween('created', [$from_filter_date, $to_filter_date]);
        }

        if ($employee_assigned_filter_id) {
            $all_leads->where('customer_assigned_to', $employee_assigned_filter_id);
        }

        if ($added_by) {
            $all_leads->where('employee_id', $added_by);
        }

        $all_leads = $all_leads->orderBy('created', 'DESC')->get();

        if (Auth::user()->id == 1) {
            $my_employees = User::where('isActive', 1)->get();
        } else {
            $my_employees = User::where('added_by', Auth::user()->id)->where('isActive', 1)->get();
        }
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-reports.leadreports', [
            'app_modules' => $modules,
            'all_leads' => $all_leads,
            'my_employees' => $my_employees,
            'assigned_to' => $employee_assigned_filter_id,
            'from_date' => $from_filter_date,
            'to_date' => $to_filter_date,
            'added_by' => $added_by
        ]);
    }

    public function export_leads_reports(Request $request)
    {
        // validate the form data
        $validated = $request->validate([
            'added_by' => "nullable|integer|exists:users,id",
            'assigned_to' => "nullable|integer|exists:users,id",
            'from_date' => "nullable|date|date_format:Y-m-d",
            'to_date' => ($request->from_date) ? "required|date|after_or_equal:from_date" : "nullable",
        ],[
            'to_date.after_or_equal' => 'The Start Date must be a date after or equal to End Date.',
            'to_date.required' => 'A valid End Date must be selected with a Start Date.',
            'assigned_to.exists' => 'The selected assigned employee is invalid.',
            'added_by.exists' => 'The selected assigned employee is invalid.'
        ]);

        // dd($request);
        $all_leads = array();
        $all_leads = CustomerLeadProfile::get_leads_customers_data(1);

        if ($request->from_date && $request->to_date) {
            $all_leads->whereBetween('created', [$request->from_date, $request->to_date]);
        }

        if ($request->assigned_to) {
            $all_leads->where('customer_assigned_to', $request->assigned_to);
        }

        if ($request->added_by) {
            $all_leads->where('employee_id', $request->added_by);
        }

        $all_leads = $all_leads->with(['firm', 'employee', 'assigned','state'])->orderBy('created', 'DESC')->get();

        $filename = date("Y-m-d")."-leads_report.csv";

        // Download the Excel file
        return (new LeadsExport($all_leads))->download($filename);
    }

    public function complaint_reports(Request $request)
    {
        // dd($request);
        $all_complaints = CustomerLeadComplaints::where('id', '>=', 1);

        $from_filter_date = is_null($request->from_date) ? Carbon::now()->startOfMonth()->format('Y-m-d') : $request->from_date;
        $to_filter_date = is_null($request->to_date) ? Carbon::now()->endOfMonth()->format('Y-m-d') : $request->to_date;

        // date converted to include higher bound values while querying counts
        $from_filter_date = Carbon::createFromFormat('Y-m-d',$from_filter_date)->startOfDay()->toDateTimeString();
        $to_filter_date = Carbon::createFromFormat('Y-m-d',$to_filter_date)->endOfDay()->toDateTimeString();

        $employee_assigned_filter_id = $request->complaint_received_by;
        if ($from_filter_date && $to_filter_date) {
            $all_complaints->whereBetween('created', [$from_filter_date, $to_filter_date]);
            // dd($from_filter_date." 00:00:00",$to_filter_date." 23:59:59");
        }
        if ($employee_assigned_filter_id) {
            $all_complaints->where('complaint_received_by', $employee_assigned_filter_id);
        }

        $all_complaints = $all_complaints->get();


        if (Auth::user()->id == 1) {
            $my_employees = User::where('isActive', 1)->get();
        } else {
            $my_employees = User::where('added_by', Auth::user()->id)->where('isActive', 1)->get();
        }
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-reports.complaintreports', [
            'app_modules' => $modules,
            'all_complaints' => $all_complaints,
            'my_employees' => $my_employees,

        ]);
    }

    public function show_collection_reports(Request $request)
    {
        if (Auth::user()->id == config('constants.director_role_id')) {
            $my_employees = User::where('isActive', 1)->get();
        } else {
            $my_employees = User::where('added_by', Auth::user()->id)->where('isActive', 1)->get();
        }

        // validate the form data
        $validated = $request->validate([
            'assigned_to' => "nullable|integer|exists:users,id",
            'from_date' => "nullable|date|date_format:Y-m-d",
            'to_date' => ($request->from_date) ? "required|date|after_or_equal:from_date" : "nullable",
        ],[
            'to_date.after_or_equal' => 'The Start Date must be a date after or equal to End Date.',
            'to_date.required' => 'A valid End Date must be selected with a Start Date.',
            'assigned_to.exists' => 'The selected assigned employee is invalid.'
        ]);

        // check if the director has logged in and show all the collections 
        // else only show the collections made by the logged in employee
        $all_collections = array();
        if(Auth::user()->role_id == config('constants.director_role_id')){
            $all_collections = CustomersCollections::where('id', '>=', 1);
        }else{
            $all_collections = CustomersCollections::where('employee_id', Auth::user()->id);
        }

        //If the request is get then show all the collections else according to the filters
        $employee_assigned_filter_id = null;
        $from_filter_date = null;
        $to_filter_date = null;

        if($request->isMethod('post')){
            $employee_assigned_filter_id = !is_null($request->assigned_to) ? $request->assigned_to : null;
            $from_filter_date = !is_null($request->from_date) ? $request->from_date : null;
            $to_filter_date = !is_null($request->to_date) ? $request->to_date : null;
        }

        if ($from_filter_date && $to_filter_date) {
            $all_collections->whereBetween('created', [$from_filter_date, $to_filter_date]);
        }

        if ($employee_assigned_filter_id) {
            $all_collections->where('employee_id', $employee_assigned_filter_id);
        }
        $all_collections = $all_collections->orderBy('money_received_date', 'DESC')->get();
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-reports.collectionreports', [
            'app_modules' => $modules,
            'all_collections' => $all_collections,
            'my_employees' => $my_employees,
            'assigned_to' => $employee_assigned_filter_id,
            'from_date' => $from_filter_date,
            'to_date' => $to_filter_date
        ]);
    }

    public function export_collection_reports(Request $request)
    {
        // validate the form data
        $validated = $request->validate([
            'assigned_to' => "nullable|integer|exists:users,id",
            'from_date' => "nullable|date|date_format:Y-m-d",
            'to_date' => ($request->from_date) ? "required|date|after_or_equal:from_date" : "nullable",
        ],[
            'to_date.after_or_equal' => 'The Start Date must be a date after or equal to End Date.',
            'to_date.required' => 'A valid End Date must be selected with a Start Date.',
            'assigned_to.exists' => 'The selected assigned employee is invalid.'
        ]);

        $all_collections = array();
        if(Auth::user()->role_id == config('constants.director_role_id')){
            $all_collections = CustomersCollections::where('id', '>=', 1);
        }else{
            $all_collections = CustomersCollections::where('employee_id', Auth::user()->id);
        }

        if ($request->from_date && $request->to_date) {
            $all_collections->whereBetween('created', [$request->from_date, $request->to_date]);
        }

        if ($request->assigned_to) {
            $all_collections->where('employee_id', $request->assigned_to);
        }

        $all_collections = $all_collections->with(['received_by', 'raised_by', 'customer'])->orderBy('money_received_date', 'DESC')->get();

        $filename = date("Y-m-d")."-collections_report.csv";

        // Instantiate the export class with custom column names and data
        // $export = new CustomersCollectionsExport($all_collections);

        // Download the Excel file
        return (new CustomersCollectionsExport($all_collections))->download($filename);

        // $file_name = date("Y-m-d")."-collections_report.csv";

        // return $all_collections->get()->downloadExcel($file_name);
    }

    public function order_reports(Request $request)
    {
        // dd($request);
        $all_orders = CustomerOrders::where('id', '>=', 1);

        $from_filter_date = is_null($request->from_date) ? Carbon::now()->startOfMonth()->format('Y-m-d') : $request->from_date;
        $to_filter_date = is_null($request->to_date) ? Carbon::now()->endOfMonth()->format('Y-m-d') : $request->to_date;

        // date converted to include higher bound values while querying counts
        $from_filter_date = Carbon::createFromFormat('Y-m-d',$from_filter_date)->startOfDay()->toDateTimeString();
        $to_filter_date = Carbon::createFromFormat('Y-m-d',$to_filter_date)->endOfDay()->toDateTimeString();

        $employee_assigned_filter_id = $request->assigned_to;
        if ($from_filter_date && $to_filter_date) {
            $all_orders->whereBetween('created', [$from_filter_date, $to_filter_date]);
        }
        if ($employee_assigned_filter_id) {
            $all_orders->where('order_made_by', $employee_assigned_filter_id);
        }

        $all_orders = $all_orders->get();

        if (Auth::user()->id == 1) {
            $my_employees = User::where('isActive', 1)->get();
        } else {
            $my_employees = User::where('added_by', Auth::user()->id)->where('isActive', 1)->get();
        }
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-reports.orderreports', [
            'app_modules' => $modules,
            'all_orders' => $all_orders,
            'my_employees' => $my_employees,
        ]);
    }


    public function call_reports(Request $request)
    {
        // dd($request);
        $all_calls = CustomerLeadCalls::where('id', '>=', 1);

        $from_filter_date = is_null($request->from_date) ? Carbon::now()->startOfMonth()->format('Y-m-d') : $request->from_date;
        $to_filter_date = is_null($request->to_date) ? Carbon::now()->endOfMonth()->format('Y-m-d') : $request->to_date;

        // date converted to include higher bound values while querying counts
        $from_filter_date = Carbon::createFromFormat('Y-m-d',$from_filter_date)->startOfDay()->toDateTimeString();
        $to_filter_date = Carbon::createFromFormat('Y-m-d',$to_filter_date)->endOfDay()->toDateTimeString();

        $employee_assigned_filter_id = $request->assigned_to;
        if ($from_filter_date && $to_filter_date) {
            $all_calls->whereBetween('created', [$from_filter_date, $to_filter_date]);
        }
        if ($employee_assigned_filter_id) {
            $all_calls->where('employee_id', $employee_assigned_filter_id);
        }
        // query should be changes to get all the records for the export -> for ALL REPORTS
        $all_calls = $all_calls->get();

        if (Auth::user()->id == 1) {
            $my_employees = User::where('isActive', 1)->get();
        } else {
            $my_employees = User::where('added_by', Auth::user()->id)->where('isActive', 1)->get();
        }
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-reports.callreports', [
            'app_modules' => $modules,
            'all_calls' => $all_calls,
            'my_employees' => $my_employees,

        ]);
    }

    public function appointment_reports(Request $request)
    {
        // dd($request);
        $all_appointments = CustomerLeadAppointments::where('id', '>=', 1);

        $from_filter_date = is_null($request->from_date) ? Carbon::now()->startOfMonth()->format('Y-m-d') : $request->from_date;
        $to_filter_date = is_null($request->to_date) ? Carbon::now()->endOfMonth()->format('Y-m-d') : $request->to_date;

        // date converted to include higher bound values while querying counts
        $from_filter_date = Carbon::createFromFormat('Y-m-d',$from_filter_date)->startOfDay()->toDateTimeString();
        $to_filter_date = Carbon::createFromFormat('Y-m-d',$to_filter_date)->endOfDay()->toDateTimeString();

        $employee_assigned_filter_id = $request->assigned_to;
        if ($from_filter_date && $to_filter_date) {
            $all_appointments->whereBetween('created', [$from_filter_date, $to_filter_date]);
        }
        if ($employee_assigned_filter_id) {
            $all_appointments->where('employee_id', $employee_assigned_filter_id);
        }

        // $all_appointments = $all_appointments->paginate(10); ok
        $all_appointments = $all_appointments->get();


        if (Auth::user()->id == 1) {
            $my_employees = User::where('isActive', 1)->get();
        } else {
            $my_employees = User::where('added_by', Auth::user()->id)->where('isActive', 1)->get();
        }
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-reports.appointmentreports', [
            'app_modules' => $modules,
            'all_appointments' => $all_appointments,
            'my_employees' => $my_employees,

        ]);
    }
}
