<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\AppSettings;
use App\Models\CustomerLeadProfile;
use App\Models\Firms;
use App\Models\ProductDetails;
use App\Models\QuotationParticulars;
use App\Models\Quotations;
use App\Models\RoleModule;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
// use Illuminate\Support\Facades\App;
// use Dompdf\Dompdf;
// use \PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;

class QuotationsController extends Controller
{
    // initial constructor
    public function __construct()
    {
        $route_name = Route::currentRouteName();
        // dd($route_name != "livewire.message" && $route_name != "select2SearchProduct");
        if ($route_name != "livewire.message" && $route_name != "select2SearchProduct" && $route_name != "select2SearchClient") {
            $this->middleware('permissioncheck:' . $route_name);

            $routeParse = explode('_', $route_name);
            if ($route_name == 'home') {
                $routeName = 'home';
            } else {
                $routeName = 'manage_' . $routeParse[1];
            }

            $this->module_info = AppModules::get_module_id_by_slug($routeName);
        }
    }

    //getter function to module id from constructor
    public function getModuleId()
    {
        return $this->module_info->id;
    }

    public function list_quotations()
    {
        // $quotations = Quotations::orderBy('created','desc')->paginate(10);

        if (isset($_GET['q'])) {
            $quotations = Quotations::search(trim($_GET['q']))->orderBy('created', 'asc')->paginate(10)->onEachSide(1)->withQueryString();
        } else {
            if (Auth::user()->role_id == config('constants.director_role_id')) {
                $quotations = Quotations::orderBy('created', 'desc')->paginate(10)->onEachSide(1)->withQueryString();
            } else {
                $quotations = Quotations::where('employee_id', Auth::user()->id)->orderBy('created', 'desc')->paginate(10)->onEachSide(1)->withQueryString();
            }
        }

        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-quotations.list-quotations', [
            'app_modules' => $modules,
            'module_access' => $module_access,
            'quotations' => $quotations,
        ]);
    }

    public function add_quotations()
    {
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        $modules = RoleModule::get_active_modules_by_role_id();
        $active_products = ProductDetails::where('isActive', 1)->get();
        if (Auth::user()->id == 1) {
            $all_leads = CustomerLeadProfile::where('isLead', 1)->where('isActive', 1)->get();
        } else {
            $all_leads = CustomerLeadProfile::where('isLead', 1)->where('isActive', 1)->whereRaw('(employee_id = ' . Auth::user()->id)->orWhereRaw('customer_assigned_to = ' . Auth::user()->id . ')')->get();
        }
        $firms = Firms::all();
        return view('manage-quotations.add-quotation-jquery', [
            'app_modules' => $modules,
            'module_access' => $module_access,
            'active_products' => $active_products,
            'all_leads' => $all_leads,
            'firms' => $firms,
        ]);
    }

    public function save_quotation(Request $request)
    {

        $validated = $request->validate([
            "quotation_type" => "required",
            "quotation_date" => "required|date_equals:" . date('Y-m-d'),
            "client_name" => "required",
            "client_address" => "required|max:150",
            "firm_name" => "required",
            "firm_address" => "required|max:255",
            "sales_person_name" => "required|in:" . ucwords(auth()->user()->full_name),
            "dispatch_date" => "required|after_or_equal:" . date('Y-m-d'),
            "dispatch_status" => "required",
            "transport" => "nullable|max:50",
            "booking_destination" => "nullable|max:50",
            "quotation_product_ids" => "required|array",
            "quotation_product_nos" => "required|array",
            "quotation_product_packaging" => "required|array",
            "quotation_product_quantity" => "required|array",
            "quotation_product_price" => "required|array",
            "quotation_product_amount" => "required|array",
            "quotation_product_tax" => "required|array",
            "term_of_supply" => "required",
            // "quotation_sub_total" => "required",
            // "quotation_tax" => "required",
            "quotation_total" => "required",
            "payment_condition" => "required|numeric",
            "payment_time" => "required",
            "payment_type" => "required",
            "remarks" => "nullable|max:1500",
        ]);

        if (count($request->quotation_product_ids) == 0 || intval($request->quotation_total) == 0) {
            return redirect()->route('add_quotations')->with('error', "Please select atleast one product to generate quotation.");
        }

        // $tax_percent = 0.18;

        //verify quotation sub total
        $product_price_array = $request->quotation_product_amount;
        // $received_quotation_sub_total = $request->quotation_sub_total;
        // $calculated_quotation_sub_total = number_format(floatval(array_sum($product_price_array)),2,'.','');

        //verify quotation tax
        // $received_quotation_tax = $request->quotation_tax;
        // $calculated_quotation_tax = number_format(floatval($calculated_quotation_sub_total * $tax_percent),2,'.','');

        //verify quotation total
        $received_quotation_total = $request->quotation_total;
        $calculated_quotation_total = number_format(floatval(array_sum($product_price_array)), 2, '.', '');
        // $calculated_quotation_total = number_format(floatval($calculated_quotation_sub_total + $calculated_quotation_tax),2,'.','');

        // dd($received_quotation_sub_total ,$calculated_quotation_sub_total ,$received_quotation_tax ,$calculated_quotation_tax ,$received_quotation_total ,$calculated_quotation_total);
        // if ($received_quotation_sub_total != $calculated_quotation_sub_total || $received_quotation_tax != $calculated_quotation_tax || $received_quotation_total != $calculated_quotation_total) {
        //     return redirect()->route('add_quotations')->with('error',"There seems to be mismatch in calculations.");
        // }
        if ($received_quotation_total != $calculated_quotation_total) {
            return redirect()->route('add_quotations')->with('error', "There seems to be mismatch in calculations.");
        }

        $employee_id = Auth::user()->id;
        $firm_details = Firms::findOrFail($request->firm_name);

        // $quotation = Quotations::add_quotation($request,$employee_id,$calculated_quotation_sub_total,$calculated_quotation_total,$calculated_quotation_tax,$tax_percent,$firm_details);
        $quotation = Quotations::add_quotation($request, $employee_id, 0, $calculated_quotation_total, 0, 0, $firm_details);
        // dd($quotation);

        $received_product_ids_array = $request->quotation_product_ids;
        $received_product_nos_array = $request->quotation_product_nos;
        $received_product_packaging_array = $request->quotation_product_packaging;
        $received_product_quantity_array = $request->quotation_product_quantity;
        $received_product_price_array = $request->quotation_product_price;
        $received_product_amount_array = $request->quotation_product_amount;
        $received_product_tax_array = $request->quotation_product_tax;
        // dd($request,$products_collection);

        for ($i = 0; $i < count($received_product_ids_array); $i++) {
            $particular = new QuotationParticulars();
            $product_id =  $received_product_ids_array[$i];
            $product_details = ProductDetails::where('id', $product_id)->first();

            // skip the entry if the product details are not available
            if (is_null($product_details))
                continue;

            $particular->quotation_id = $quotation->id;
            $particular->product_id = $product_id;
            $particular->product_category_id = $product_details->product_category;
            $particular->product_category_name = $product_details->category->category_name;
            $particular->product_name = $product_details->product_name;
            $particular->product_nos = $received_product_nos_array[$i];
            $particular->product_packaging = $received_product_packaging_array[$i];
            $particular->product_unit = $product_details->product_unit;
            $particular->product_hsn = $product_details->product_hsn;
            $particular->product_quantity = $received_product_quantity_array[$i];
            $particular->product_price = $received_product_price_array[$i];
            $particular->product_gst = $received_product_tax_array[$i];
            $particular->product_amount = $received_product_amount_array[$i];
            $particular->created = date('Y-m-d h:i:s');
            $particular->updated = date('Y-m-d h:i:s');
            $particular->save();
        }


        // $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        // $modules = RoleModule::get_active_modules_by_role_id();

        return redirect()->route('view_quotations', $quotation->id);
    }

    //method to view quotation detail
    public function view_quotation($quotation_id)
    {
        $quotation_details = Quotations::where('id', $quotation_id)->first();
        // dd($quotation_details);
        $app_settings = AppSettings::first();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);

        $number = $quotation_details->quotation_total;
        // $no = floor($number);
        // $point = round($number - $no, 2) * 100;
        // $hundred = null;
        // $digits_1 = strlen($no);
        // $i = 0;
        // $str = array();
        // $words = array('0' => '', '1' => 'one', '2' => 'two',
        //     '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        //     '7' => 'seven', '8' => 'eight', '9' => 'nine',
        //     '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        //     '13' => 'thirteen', '14' => 'fourteen',
        //     '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        //     '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
        //     '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        //     '60' => 'sixty', '70' => 'seventy',
        //     '80' => 'eighty', '90' => 'ninety');
        // $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        // while ($i < $digits_1) {
        //     $divider = ($i == 2) ? 10 : 100;
        //     $number = floor($no % $divider);
        //     $no = floor($no / $divider);
        //     $i += ($divider == 10) ? 1 : 2;
        //     if ($number) {
        //         $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        //         $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        //         $str [] = ($number < 21) ? $words[$number] .
        //             " " . $digits[$counter] . $plural . " " . $hundred
        //             :
        //             $words[floor($number / 10) * 10]
        //             . " " . $words[$number % 10] . " "
        //             . $digits[$counter] . $plural . " " . $hundred;
        //     } else $str[] = null;
        // }
        // $str = array_reverse($str);
        // $result = implode('', $str);
        // $points = ($point) ?
        //     "." . $words[$point / 10] . " " . 
        //         $words[$point = $point % 10] : 'zero';
        // $amount_chargeable_in_words =  $result . "Rupees  " . $points . " Paise";
        $amount_chargeable_in_words =  Helper::amount_to_words($number);

        return view('manage-quotations.view-quotations', [
            'app_modules' => $modules,
            'module_access' => $module_access,
            'quotation_details' => $quotation_details,
            'app_settings' => $app_settings,
            'amount_chargeable_in_words' => $amount_chargeable_in_words,
        ]);
    }

    //method ot edit quotation details
    public function edit_quotation($quotation_id)
    {
        $quotation_details = Quotations::where('id', $quotation_id)->first();
        // dd($quotation_details);
        $app_settings = AppSettings::first();
        $active_products = ProductDetails::where('isActive', 1)->get();
        if (Auth::user()->id == 1) {
            $all_leads = CustomerLeadProfile::where('isLead', 1)->where('isActive', 1)->get();
        } else {
            $all_leads = CustomerLeadProfile::where('isLead', 1)->where('isActive', 1)->whereRaw('(employee_id = ' . Auth::user()->id)->orWhereRaw('customer_assigned_to = ' . Auth::user()->id . ')')->get();
        }
        $firms = Firms::all();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);

        return view('manage-quotations.edit-quotation-jquery', [
            'app_modules' => $modules,
            'module_access' => $module_access,
            'quotation_details' => $quotation_details,
            'app_settings' => $app_settings,
            'active_products' => $active_products,
            'all_leads' => $all_leads,
            'firms' => $firms,
        ]);
    }


    //method to update quotation
    public function update_quotation(Request $request, $quotation_id)
    {
        # code...
        // dd($request);

        $validated = $request->validate([
            "quotation_date" => "required|date_equals:" . date('Y-m-d'),
            "client_name" => "required",
            "client_address" => "required|max:150",
            "firm_name" => "required",
            "firm_address" => "required|max:255",
            "sales_person_name" => "required|in:" . ucwords(auth()->user()->full_name),
            "dispatch_date" => "required|after_or_equal:" . date('Y-m-d'),
            "dispatch_status" => "required",
            "transport" => "nullable|max:50",
            "booking_destination" => "nullable|max:50",
            "quotation_product_ids" => "required|array",
            "quotation_product_nos" => "required|array",
            "quotation_product_packaging" => "required|array",
            "quotation_product_quantity" => "required|array",
            "quotation_product_price" => "required|array",
            "quotation_product_amount" => "required|array",
            "quotation_product_tax" => "required|array",
            "term_of_supply" => "required",
            // "quotation_sub_total" => "required",
            // "quotation_tax" => "required",
            "quotation_total" => "required",
            "payment_condition" => "required|numeric",
            "payment_time" => "required",
            "payment_type" => "required",
            "remarks" => "nullable|max:1500",
        ]);

        if (count($request->quotation_product_ids) == 0 || intval($request->quotation_total) == 0) {
            return redirect()->route('edit_quotations', $quotation_id)->with('error', "Please select atleast one product to generate quotation.");
        }

        // $tax_percent = 0.18;

        //verify quotation sub total
        $product_price_array = $request->quotation_product_amount;
        // $received_quotation_sub_total = $request->quotation_sub_total;
        // $calculated_quotation_sub_total = number_format(floatval(array_sum($product_price_array)),2,'.','');

        //verify quotation tax
        // $received_quotation_tax = $request->quotation_tax;
        // $calculated_quotation_tax = number_format(floatval($calculated_quotation_sub_total * $tax_percent),2,'.','');

        //verify quotation total
        $received_quotation_total = $request->quotation_total;
        $calculated_quotation_total = number_format(floatval(array_sum($product_price_array)), 2, '.', '');
        // $calculated_quotation_total = number_format(floatval($calculated_quotation_sub_total + $calculated_quotation_tax),2,'.','');

        // dd($received_quotation_sub_total ,$calculated_quotation_sub_total ,$received_quotation_tax ,$calculated_quotation_tax ,$received_quotation_total ,$calculated_quotation_total);
        // if ($received_quotation_sub_total != $calculated_quotation_sub_total || $received_quotation_tax != $calculated_quotation_tax || $received_quotation_total != $calculated_quotation_total) {
        //     return redirect()->route('add_quotations')->with('error',"There seems to be mismatch in calculations.");
        // }
        if ($received_quotation_total != $calculated_quotation_total) {
            return redirect()->route('edit_quotations', $quotation_id)->with('error', "There seems to be mismatch in transaction calculations. Please check the calculations manually.");
        }

        $employee_id = Auth::user()->id;
        $firm_details = Firms::findOrFail($request->firm_name);
        
        // $quotation = Quotations::add_quotation($request,$employee_id,$calculated_quotation_sub_total,$calculated_quotation_total,$calculated_quotation_tax,$tax_percent,$firm_details);
        $quotation = Quotations::update_quotation($request, $quotation_id, $employee_id, 0, $calculated_quotation_total, 0, 0, $firm_details);
        // dd($quotation);

        $received_product_ids_array = $request->quotation_product_ids;
        $received_product_nos_array = $request->quotation_product_nos;
        $received_product_packaging_array = $request->quotation_product_packaging;
        $received_product_quantity_array = $request->quotation_product_quantity;
        $received_product_price_array = $request->quotation_product_price;
        $received_product_amount_array = $request->quotation_product_amount;
        $received_product_tax_array = $request->quotation_product_tax;
        // dd($request,$products_collection);

        $quotation_particulars = QuotationParticulars::where('quotation_id', $quotation_id);
        // delete old quotation particulars 
        if (count($quotation_particulars->get()) > 0) {
            $quotation_particulars = QuotationParticulars::where('quotation_id', $quotation_id)->delete();
        }

        for ($i = 1; $i < count($received_product_ids_array); $i++) {
            $particular = new QuotationParticulars();
            $product_id =  $received_product_ids_array[$i];
            $product_details = ProductDetails::where('id', $product_id)->first();

            // skip the entry if the product details are not available
            if (is_null($product_details))
                continue;
            
            $particular->quotation_id = $quotation->id;
            $particular->product_id = $product_id;
            $particular->product_category_id = $product_details->product_category;
            $particular->product_category_name = $product_details->category->category_name;
            $particular->product_name = $product_details->product_name;
            $particular->product_nos = $received_product_nos_array[$i];
            $particular->product_packaging = $received_product_packaging_array[$i];
            $particular->product_unit = $product_details->product_unit;
            $particular->product_hsn = $product_details->product_hsn;
            $particular->product_quantity = $received_product_quantity_array[$i];
            $particular->product_price = $received_product_price_array[$i];
            $particular->product_gst = $received_product_tax_array[$i];
            $particular->product_amount = $received_product_amount_array[$i];
            $particular->created = date('Y-m-d h:i:s');
            $particular->updated = date('Y-m-d h:i:s');
            $particular->save();
        }


        // $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        // $modules = RoleModule::get_active_modules_by_role_id();

        return redirect()->route('view_quotations', $quotation_id);
    }

    //method to delete quotation
    public static function delete_quotation($quotation_id)
    {
        $quotation_id = $quotation_id;


        $delete_quotation_particular = QuotationParticulars::where('quotation_id', $quotation_id)->delete();
        $delete_quotation = Quotations::where('id', $quotation_id)->delete();

        return redirect()->route('manage_quotations');
    }

    //method to print quotation
    public function download_pdf($quotation_id, $old = 0)
    {
        $quotation_details = Quotations::where('id', $quotation_id)->first();
        if ($old == 1) {
            $pdf_filename = strtoupper("old_".$quotation_details->client_name . "_" . str_replace('/', '_', $quotation_details->quotation_no));
        } else {
            $pdf_filename = strtoupper($quotation_details->client_name . "_" . str_replace('/', '_', $quotation_details->quotation_no));
        }
        
        $number = $quotation_details->quotation_total;
        $amount_chargeable_in_words =  Helper::amount_to_words($number);
        $data = [
            'quotation_details' => $quotation_details,
            'amount_chargeable_in_words' => $amount_chargeable_in_words
        ];

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf-templates.quotation-template', $data);
        $pdf->setPaper('A4', 'potrait');
        $pdf->setOptions([
            'dpi' => 300,
            'isPhpEnabled' => true
        ]);
        $pdf->addInfo(['Title' => $pdf_filename]);
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $x = 500;
        $y = 800;
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 10;
        $color = array(0, 0, 0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $canvas->page_text($x, $y, $text, $font, $size, $color);
        return $pdf->stream($pdf_filename . '.pdf');
    }
}
