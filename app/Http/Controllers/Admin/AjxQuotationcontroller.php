<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerLeadProfile;
use App\Models\Firms;
use App\Models\ProductDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AjxQuotationcontroller extends Controller
{

    //ajax call to show products dropdown response for select2
    public function selectSearchProduct(Request $request)
    {
        $products = ProductDetails::where('isActive',1)->get()->sortBy('product_name');

        if($request->has('q')){
            $search = $request->q;
            $products = ProductDetails::where('isActive',1)->where('product_name', 'LIKE', "%$search%")->get()->sortBy('product_name');
        }
        return response()->json($products);
    }

    //ajax call to show leads dropdown response for select2
    public function selectSearchClient(Request $request)
    {
        if(Auth::user()->id == config("constants.director_role_id")){
            $leads = CustomerLeadProfile::where('isActive',1)->get()->sortBy('customer_name');
        }else{
            $leads = CustomerLeadProfile::where('isActive',1)->whereRaw('(employee_id = '.Auth::user()->id)->orWhereRaw('customer_assigned_to = '.Auth::user()->id.')')->get()->sortBy('customer_name');
        }

        if($request->has('q')){
            $search = $request->q;
            if(Auth::user()->id == config("constants.director_role_id")){
                $leads = CustomerLeadProfile::where('isActive',1)->where('customer_name', 'LIKE', "%$search%")->get()->sortBy('customer_name');
            }else{
                $leads = CustomerLeadProfile::where('customer_name', 'LIKE', "%$search%")->where('isActive',1)->whereRaw('(employee_id = '.Auth::user()->id)->orWhereRaw('customer_assigned_to = '.Auth::user()->id.')')->get()->sortBy('customer_name');
            }
        }

        $response = [];
        $result = [];

        foreach ($leads as $lead) {
            $response["id"] = Crypt::encrypt($lead->id);
            $response["customer_name"] = $lead->customer_name;
            // $response["customer_address"] = $lead->customer_name; // ?
            $response["customer_address"] = str_replace('__','&#13;&#10;',$lead->customer_address);
            $result[] = $response;
        }

        return response()->json($result);
    }

    //ajax call get firm details
    public static function get_firm_details(Request $request)
    {
        $validated = $request->validate([
            'firm_id' => 'required|exists:firms,id'
        ],[
            'firm_id.exists' => "Invalid Firm"
        ]);

        $firm_details = Firms::findOrFail($request->firm_id);

        $response = [];

        // $response['address'] = ucwords($firm_details->firm_owner_name).'&#13;&#10;'.str_replace('__','&#13;&#10;',$firm_details->firm_address);
        $response['address'] = str_replace('__','&#13;&#10;',$firm_details->firm_address).'&#13;&#10;GSTIN: '.$firm_details->firm_gst_no.'&#13;&#10;Contact: '.$firm_details->firm_contact_no;
        $response['bank_acc_no'] = $firm_details->firm_bank_account_no;
        $response['bank_branch_name'] = $firm_details->firm_bank_branch_name;
        $response['bank_ifsc_code'] = $firm_details->firm_bank_ifsc_code;
        $response['bank_name'] = $firm_details->firm_bank_name;
        $response['contact_no'] = $firm_details->firm_contact_no;
        $response['email'] = $firm_details->firm_email;
        $response['gst_no'] = $firm_details->firm_gst_no;
        $response['signatory_image'] = ($firm_details->firm_signatory_image) ? asset('uploads/firm_signatory_images/',$firm_details->firm_signatory_image) : '';

        return json_encode(array(
            'firm_details' => $response
        ));
    }


    //ajax call to get client address
    //API to send client address
    public function get_client_address(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required'
        ]);

        $client_id = Crypt::decrypt($request->client_id);

        if(Auth::user()->id == config("constants.director_role_id")){
            $leads = CustomerLeadProfile::where('isActive',1)->where('id',$client_id)->first();
        }else{
            $leads = CustomerLeadProfile::where('isActive',1)->where('id',$client_id)->whereRaw('(employee_id = '.Auth::user()->id)->orWhereRaw('customer_assigned_to = '.Auth::user()->id.')')->first();
        }

        $response = [];
        // $response['address'] = ucwords($leads->customer_owner_name).'&#13;&#10;'.str_replace('__','&#13;&#10;',$leads->customer_address);
        $response['address'] = str_replace('__','&#13;&#10;',$leads->customer_address);

        return json_encode($response);
    }

    // ajax call to get product details
    public function get_product_details(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required'
        ]);
        $product = ProductDetails::where('isActive',1)->where('id',$request->product_id)->first();

        $response = [];
        $response["product_packaging"] = $product->product_packaging;
        $response["product_tax"] = $product->product_tax;
        return response()->json($response);
    }
}
