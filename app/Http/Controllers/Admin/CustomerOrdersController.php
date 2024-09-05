<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Models\AppModules;
use App\Models\AppSettings;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\App;
use App\Models\RoleModule;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerLeadOrders;
use App\Models\CustomerLeadProfile;
use App\Models\CustomerOrderParticulars;
use App\Models\CustomerOrders;
use App\Models\Firms;
use App\Models\ProductDetails;

class CustomerOrdersController extends Controller
{
    // initial constructor
    public function __construct()
    {
        $route_name = Route::currentRouteName();

        if($route_name != "livewire.message"){
            $this->middleware('permissioncheck:'.$route_name);
    
            $routeParse = explode('_',$route_name);
            if($route_name == 'home'){
                $routeName = 'home';
            }else{
                $routeName = 'manage_'.$routeParse[1];
            }
    
            $this->module_info = AppModules::get_module_id_by_slug($routeName);
        }
    }

    //getter function to module id from constructor
    public function getModuleId()
    {
        return $this->module_info->id;
    }


    //method to list orders 
    public function list_customer_orders($customer_id)
    {
        if(isset($_GET['q'])){
            $all_orders = CustomerLeadOrders::search(trim($_GET['q']),$customer_id)->paginate(10)->onEachSide(1)->withQueryString(); 
        }else{
            $all_orders = CustomerOrders::get_all_orders($customer_id);
        }

        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-orders.list-orders',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'all_orders' => $all_orders,
        ]);
    }

    public function add_customer_order($customer_id)
    {
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        $modules = RoleModule::get_active_modules_by_role_id();
        $active_products = ProductDetails::where('isActive',1)->get();
        $customer_details = CustomerLeadProfile::where('id',$customer_id)->where('isActive',1)->first();
        $firm = Firms::where('id',$customer_details->firm_id)->first();

        return view('manage-customers.customer-orders.add-order',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'active_products' => $active_products,
            'customer_details' => $customer_details,
            'firm' => $firm,
        ]);
    }

    public function save_customer_order(Request $request,$customer_id)
    {
        $validated = $request->validate([
            "order_date" => "required|date_equals:today",
            "client_name" => "required",
            "client_address" => "required",
            "firm_name" => "required",
            "firm_address" => "required",
            "sales_person_name" => "required|in:".ucwords(auth()->user()->full_name),
            "dispatch_date" => "required|after_or_equal:".date('Y-m-d'),
            "dispatch_status" => "required",
            "transport" => "required|max:255",
            "booking_destination" => "required|max:255",
            "term_of_supply" => "required",
            "order_total" => "required",
            "payment_condition" => "required",
            "payment_time" => "required",
            "payment_type" => "required",
            "remarks" => "nullable|max:1500",
            "order_product_ids" => "required|array",
            "order_product_nos" => "required|array",
            "order_product_packaging"=> "required|array",
            "order_product_quantity" => "required|array",
            "order_product_price" => "required|array",
            "order_product_amount" => "required|array",
            "order_product_tax" => "required|array",
            "term_of_supply" => "required",
            // "order_sub_total" => "required",
            // "order_tax" => "required",
        ]);
       
        if(count($request->order_product_ids) == 0 || intval($request->order_total) == 0){
            return redirect()->route('addOrder_customers',$customer_id)->with('error',"Please select atleast one product to generate order.");
        }

        // $tax_percent = 0.18;

        //verify order sub total
        $product_price_array = $request->order_product_amount;
        // $received_order_sub_total = $request->order_sub_total;
        // $calculated_order_sub_total = number_format(floatval(array_sum($product_price_array)),2,'.','');

        //verify order tax
        // $received_order_tax = $request->order_tax;
        // $calculated_order_tax = number_format(floatval($calculated_order_sub_total * $tax_percent),2,'.','');

        //verify order total
        $received_order_total = $request->order_total;
        $calculated_order_total = number_format(floatval(array_sum($product_price_array)), 2, '.', '');

        // dd($received_order_sub_total ,$calculated_order_sub_total ,$received_order_tax ,$calculated_order_tax ,$received_order_total ,$calculated_order_total);
        if ($received_order_total != $calculated_order_total) {
            return redirect()->route('add_orders')->with('error', "There seems to be mismatch in calculations.");
        }

        $employee_id = Auth::user()->id;
        $firm_details = Firms::findOrFail($request->firm_name);

        $order = CustomerOrders::add_order($request,$employee_id,$customer_id,0,$calculated_order_total, 0, 0,$firm_details);

        $received_product_ids_array = $request->order_product_ids;
        $received_product_nos_array = $request->order_product_nos;
        $received_product_packaging_array = $request->order_product_packaging;
        $received_product_quantity_array = $request->order_product_quantity;
        $received_product_price_array = $request->order_product_price;
        $received_product_amount_array = $request->order_product_amount;
        $received_product_tax_array = $request->order_product_tax;
        // $product_names_array = ProductDetails::whereIn('id',$received_product_ids_array)->get();

        for ($i=0; $i < count($received_product_ids_array); $i++) { 
            $particular = new CustomerOrderParticulars();
            $product_id =  $received_product_ids_array[$i];
            $product_details = ProductDetails::where('id', $product_id)->first();

            // skip the entry if the product details are not available
            if (is_null($product_details))
                continue;

            $particular->customer_order_id  = $order->id;
            $particular->product_id = $received_product_ids_array[$i];
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

        return redirect()->route('viewOrderDetails_customers',["customer_id"=>$customer_id,"order_id"=>$order->id]);
    }

    // method to view customer order
    public function view_customer_order($customer_id,$order_id)
    {
        $order_details = CustomerOrders::where('id',$order_id)->first();
        $app_settings = AppSettings::first();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        $number = $order_details->order_total;
        $amount_chargeable_in_words =  Helper::amount_to_words($number);

        return view('manage-customers.customer-orders.view-order',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'order_details' => $order_details,
            'app_settings' => $app_settings,
            'customer_id' => $customer_id,
            'amount_chargeable_in_words' => $amount_chargeable_in_words,
        ]);
    }

    //method to delete customer order
    public static function delete_order($customer_id,$order_id)
    {
        $order_id = $order_id;
        $delete_order_particular = CustomerOrderParticulars::where('customer_order_id',$order_id)->delete();
        $delete_order = CustomerOrders::where('id',$order_id)->delete();

        return redirect()->route('viewOrders_customers',$customer_id);
    }

    //method to print customer order
    public function download_pdf($order_id)
    {
        // dd(order_id);
        $order_details = CustomerOrders::where('id',$order_id)->first();
        $pdf_filename = strtoupper($order_details->client_name."_".str_replace('/','_',$order_details->quotation_no));
        $app_settings = AppSettings::first();
        $number = $order_details->order_total;
        $amount_chargeable_in_words =  Helper::amount_to_words($number);
        $data = [
            'order_details' => $order_details,
            'amount_chargeable_in_words' => $amount_chargeable_in_words
        ];

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf-templates.order-template', $data);
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
