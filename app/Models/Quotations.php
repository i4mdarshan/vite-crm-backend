<?php

namespace App\Models;

use App\Helper\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Quotations extends Model
{
    use HasFactory;

    //relation to get quotation particulars
    public function particulars()
    {
        return $this->hasMany(QuotationParticulars::class,'quotation_id');
    }

    //relation to get user details
    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    }

    //method to list quotations
    public static function get_all_quotations()
    {
        return Quotations::orderBy('created','desc')->paginate(10)->onEachSide(1)->withQueryString();
    }

    //method to search quotation
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use($term){
            $query->where('quotation_no','LIKE',$term)
            ->orwhere('quotation_type','LIKE',$term)
            ->orwhere('quotation_total','LIKE',$term);
        });
    }

    // function to generate quotation no
    public static function generate_quotation_no($new_quotation_no,$request)
    {
        $quotation_type = Helper::abbreviate($request->quotation_type);
        $quotation_month = strtoupper(date("M",strtotime($request->quotation_date)));
        $carbon_date = Carbon::createFromDate($request->quotation_date);
        $quotation_year = $carbon_date->format('y').'-'.$carbon_date->addYear()->format('y');
        $quotation_no = $quotation_type.'/'.$quotation_month.'/'.$new_quotation_no.'/'.$quotation_year;
        return $quotation_no;
    }

    //method to add quotation
    public static function add_quotation($request,$employee_id,$quotation_sub_total,$quotation_total,$quotation_tax,$quotation_tax_percent,$firm_details)
    {

        // $last_quotation = Quotations::where('quotation_type',$request->quotation_type)->orderBy('created','desc')->first();
        // if(is_null($last_quotation) || date("m",strtotime($last_quotation->quotation_date)) < date("m",strtotime($request->quotation_date))){ 
        //     $new_quotation_no = '0001';
        // }else{;
        //     $dbValue = explode('/',$last_quotation->quotation_no);
        //     $new_quotation_no = sprintf("%04d",(intval($dbValue[2]) + 1));
        //     var_dump($dbValue);
        //     var_dump($new_quotation_no);
        // }
        // die();

        //Get Client Details from DB
        $client_id = Crypt::decrypt($request->client_name);
        $client = CustomerLeadProfile::findOrFail($client_id);
        
        $quotation = new Quotations();
        $quotation->employee_id = $employee_id;
        $quotation->quotation_made_by = $request->sales_person_name;
        $quotation->quotation_type = $request->quotation_type;
        $last_quotation = Quotations::where('quotation_type',$request->quotation_type)->orderBy('created','desc')->first();
        if(is_null($last_quotation) || date("m",strtotime($last_quotation->quotation_date)) < date("m",strtotime($request->quotation_date))){ 
            $new_quotation_no = '0001';
        }else{;
            $dbValue = explode('/',$last_quotation->quotation_no);
            $new_quotation_no = sprintf("%04d",(intval($dbValue[2]) + 1));
        }
        $quotation_no = self::generate_quotation_no($new_quotation_no, $request);
        $quotation->quotation_no = $quotation_no;
        $quotation->quotation_date = $request->quotation_date;
        $quotation->customer_id = $client->id;
        $quotation->client_name = $client->customer_name;
        $quotation->client_address = $request->client_address;
        $quotation->firm_id = $firm_details->id;
        $quotation->firm_name = $firm_details->firm_name;
        $quotation->firm_bank_name = $firm_details->firm_bank_name;
        $quotation->firm_bank_account_no = $firm_details->firm_bank_account_no;
        $quotation->firm_branch_name = $firm_details->firm_bank_branch_name;
        $quotation->firm_bank_ifsc = $firm_details->firm_bank_ifsc_code;
        $quotation->firm_address = $request->firm_address;
        $quotation->dispatch_date = $request->dispatch_date;
        $quotation->dispatch_status = $request->dispatch_status;
        $quotation->transport = $request->transport;
        $quotation->booking_destination = $request->booking_destination;
        $quotation->term_of_supply = $request->term_of_supply;
        // $quotation->quotation_sub_total = $quotation_sub_total;
        // $quotation->quotation_tax = $quotation_tax;
        // $quotation->quotation_tax_percent = floatval($quotation_tax_percent)*100;
        $quotation->quotation_total = $quotation_total;
        $quotation->payment_condition = $request->payment_condition;
        $quotation->payment_time = $request->payment_time;
        $quotation->payment_type = $request->payment_type;
        $quotation->remarks = $request->remarks;
        $quotation->created = date('Y-m-d h:i:s');
        $quotation->updated = date('Y-m-d h:i:s');
        $quotation->save();

        return $quotation;
    }

    // method to update quotation
    public static function update_quotation($request,$quotation_id,$employee_id,$quotation_sub_total,$quotation_total,$quotation_tax,$quotation_tax_percent,$firm_details)
    {
        $quotation = Quotations::findOrFail($quotation_id);
        $quotation->employee_id = $employee_id;
        $quotation->quotation_made_by = $request->sales_person_name;
        $quotation->quotation_type = isset($request->quotation_type) ? $request->quotation_type : $quotation->quotation_type;
        // $last_quotation = Quotations::where('quotation_type',$request->quotation_type)->orderBy('quotation_no','desc')->first();
        // if(is_null($last_quotation)){
        //     $last_quotation_no = '0001';
        // }else{;
        //     $dbValue = explode('/',$last_quotation->quotation_no);
        //     $last_quotation_no = sprintf("%04d",(intval($dbValue[2]) + 1));
        // }
        // $quotation_no = self::generate_quotation_no($last_quotation_no, $request);
        // $quotation->quotation_no = $quotation_no;
        $quotation->quotation_date = $request->quotation_date;
        // client name should be added 
        $client_id = isset($request->client_name) ? Crypt::decrypt($request->client_name) : $quotation->customer_id;
        $client = CustomerLeadProfile::findOrFail($client_id);
        $quotation->client_name = $client->customer_name;
        $quotation->client_address = $request->client_address;
        $quotation->firm_id = $firm_details->id;
        $quotation->firm_name = $firm_details->firm_name;
        $quotation->firm_bank_name = $firm_details->firm_bank_name;
        $quotation->firm_bank_account_no = $firm_details->firm_bank_account_no;
        $quotation->firm_branch_name = $firm_details->firm_bank_branch_name;
        $quotation->firm_bank_ifsc = $firm_details->firm_bank_ifsc_code;
        $quotation->firm_address = $request->firm_address;
        $quotation->dispatch_date = $request->dispatch_date;
        $quotation->dispatch_status = $request->dispatch_status;
        $quotation->transport = $request->transport;
        $quotation->booking_destination = $request->booking_destination;
        $quotation->term_of_supply = isset($request->term_of_supply) ? $request->term_of_supply : $quotation->term_of_supply;
        // $quotation->quotation_sub_total = $quotation_sub_total;
        // $quotation->quotation_tax = $quotation_tax;
        // $quotation->quotation_tax_percent = floatval($quotation_tax_percent)*100;
        $quotation->quotation_total = $quotation_total;
        $quotation->payment_condition = $request->payment_condition;
        $quotation->payment_time = $request->payment_time;
        $quotation->payment_type = $request->payment_type;
        $quotation->remarks = $request->remarks;
        $quotation->updated = date('Y-m-d h:i:s');
        $quotation->save();

        return $quotation;
    }

    public $timestamps = false;
    protected $table="quotations";
}
