<?php

namespace App\Models;

use App\Helper\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class CustomerOrders extends Model
{
    use HasFactory;

    //relation to get customer order particulars
    public function particulars()
    {
        return $this->hasMany(CustomerOrderParticulars::class,'customer_order_id');
    }

    //relation to get user details
    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    }

    //method to list customer orders
    public static function get_all_orders($customer_id)
    {
        return CustomerOrders::where('customer_id',$customer_id)->orderBy('created','desc')->paginate(10)->onEachSide(1)->withQueryString();
    }

    //method to search customer orders
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use($term){
            $query->where('order_no','LIKE',$term)
            ->orwhere('order_total','LIKE',$term);
        });
    }

    // function to generate order no
    public static function generate_order_no($last_order_no,$request)
    {
        $order_type = "SO";
        $order_month = strtoupper(date("M",strtotime($request->order_date)));
        $carbon_date = Carbon::createFromDate($request->order_date);
        $order_year = $carbon_date->format('y').'-'.$carbon_date->addYear()->format('y');
        $order_no = $order_type.'\\'.$order_month.'\\'.$last_order_no.'\\'.$order_year;
        return $order_no;
    }

    //method to add customer order
    public static function add_order($request,$employee_id,$customer_id,$calculated_order_sub_total,$calculated_order_total,$calculated_order_tax,$tax_percent,$firm_details)
    {
        $order = new CustomerOrders();
        $order->employee_id = $employee_id;
        $order->customer_id = $customer_id;
        $order->order_made_by = $request->sales_person_name;
        $last_order = CustomerOrders::orderBy('order_no','desc')->first();
        if(is_null($last_order)){
            $last_order_no = '0001';
        }else{
            $dbValue = explode('\\',$last_order->order_no);
            $last_order_no = sprintf("%04d",(intval($dbValue[2]) + 1));
        }
        $order_no = self::generate_order_no($last_order_no, $request);
        $order->order_no = $order_no;
        $order->order_date = $request->order_date;
        // client name should be added 
        $client_id = Crypt::decrypt($request->client_name);
        $client = CustomerLeadProfile::findOrFail($client_id);
        $order->client_name = $client->customer_name;
        $order->client_address = $request->client_address;
        $order->firm_id = $firm_details->id;
        $order->firm_name = $firm_details->firm_name;
        $order->firm_gst_no = $firm_details->firm_gst_no;
        $order->firm_bank_name = $firm_details->firm_bank_name;
        $order->firm_bank_account_no = $firm_details->firm_bank_account_no;
        $order->firm_branch_name = $firm_details->firm_bank_branch_name;
        $order->firm_bank_ifsc = $firm_details->firm_bank_ifsc_code;
        $order->firm_address = $request->firm_address;
        $order->dispatch_date = $request->dispatch_date;
        $order->dispatch_status = $request->dispatch_status;
        $order->transport = $request->transport;
        $order->booking_destination = $request->booking_destination;
        $order->term_of_supply = $request->term_of_supply;
        // $order->order_sub_total = $calculated_order_sub_total;
        // $order->order_tax = $calculated_order_tax;
        // $order->order_tax_percent = floatval($tax_percent)*100;
        $order->order_total = $calculated_order_total;
        $order->payment_condition = $request->payment_condition;
        $order->payment_time = $request->payment_time;
        $order->payment_type = $request->payment_type;
        $order->remarks = $request->remarks;
        $order->created = date('Y-m-d h:i:s');
        $order->updated = date('Y-m-d h:i:s');
        $order->save();

        return $order;
    }

    public $timestamps = false;
    protected $table = "customer_orders";
}
