<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Firms extends Model
{
    use HasFactory;

    //method to get all firms
    public static function get_all_firms()
    {
        return Firms::all();
    }

    //method to update firm details
    public static function update_firm($request)
    {
        $firm_id = $request->firm_id;
        $firm = Firms::findOrFail($firm_id);
        $firm->firm_name = isset($request->firm_name) ? $request->firm_name : $firm->firm_name;
        $firm->firm_owner_name = isset($request->firm_owner_name) ? $request->firm_owner_name : $firm->firm_owner_name;

        $firm_address = $request->firm_address_line_1."__".$request->firm_address_line_2."__".$request->firm_address_line_3."__".$request->firm_address_line_4."__".$request->firm_address_line_5."__".$request->firm_address_line_6;

        $firm->firm_address = ($firm_address != $firm->firm_address) ? $firm_address : $firm->firm_address;

        //delete old image and update new 
        // if($request->hasFile('signatory_image')) {
        //     if(File::exists(public_path('uploads/firm_signatory_images/'.$firm->firm_signatory_image))){
        //         File::delete(public_path('uploads/firm_signatory_images/'.$firm->firm_signatory_image));
        //     }
        //     $fileName = date("Y_m_d_h_i_s_").$request->signatory_image->getClientOriginalName();
        //     $request->file('signatory_image')->move(public_path().'/uploads/firm_signatory_images/',$fileName);
        //     $firm->firm_signatory_image = $fileName;
        // }

        $firm->firm_email = isset($request->firm_email) ? $request->firm_email : $firm->firm_email;
        $firm->firm_gst_no = isset($request->firm_gst_no) ? $request->firm_gst_no : $firm->firm_gst_no;
        $firm->firm_contact_no = isset($request->firm_contact_no) ? $request->firm_contact_no : $firm->firm_contact_no;
        $firm->firm_bank_name = isset($request->firm_bank_name) ? $request->firm_bank_name : $firm->firm_bank_name;
        $firm->firm_bank_account_no = isset($request->firm_bank_account_no) ? $request->firm_bank_account_no : $firm->firm_bank_account_no;
        $firm->firm_bank_ifsc_code = isset($request->firm_bank_ifsc_code) ? $request->firm_bank_ifsc_code : $firm->firm_bank_ifsc_code;
        $firm->firm_bank_branch_name = isset($request->firm_bank_branch_name) ? $request->firm_bank_branch_name : $firm->firm_bank_branch_name;
        $firm->updated = date("Y-m-d h:i:s");

        $firm->save();

        return $firm;
    }

    public $timestamps = false;
    protected $table = "firms";
}
