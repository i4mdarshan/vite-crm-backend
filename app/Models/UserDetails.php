<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class UserDetails extends Model
{
    use HasFactory;

    //method to add employee details
    public static function add_user_details($user_id,Request $request)
    {
        $user_details = new UserDetails();
        $user_details->employee_id = $user_id;
        $user_details->personal_phone_no_1 = $request->personal_phone_no_1;
        $user_details->personal_phone_no_2 = $request->personal_phone_no_2;
        $user_details->father_phone_no = $request->father_phone_no;
        $user_details->mother_phone_no = $request->mother_phone_no;
        $user_details->wife_phone_no = $request->wife_phone_no;
        $user_details->others_phone_no = $request->others_phone_no;
        $user_details->current_address = $request->current_address;
        $user_details->permanent_address = $request->permanent_address;
        // $user_details->accessories = $request->accessories;
        $user_details->date_of_joining = $request->joining_date;
        $user_details->isActive = $request->employee_status;

        if($request->hasFile('profile_image')){
            $name = date("Y_m_d_h_i_s_").$request->file('profile_image')->getClientOriginalName();
            $move_file = $request->file('profile_image')->move(public_path().'/uploads/users/profile_images/', $name);
            $user_details->employee_image = $name;
        }

        
        if($request->hasFile('joining_letter')){
            $name = date("Y_m_d_h_i_s_").$request->file('joining_letter')->getClientOriginalName();
            $request->file('joining_letter')->move(public_path().'/uploads/users/joining_letters/', $name);
            $user_details->joining_letter = $name;
        }

        if($request->hasFile('accessories')){
            $name = date("Y_m_d_h_i_s_").$request->file('accessories')->getClientOriginalName();
            $request->file('accessories')->move(public_path().'/uploads/users/accessories/', $name);
            $user_details->accessories = $name;
        }
        
        $user_details->created = date('Y-m-d h:i:s');
        $user_details->updated = date('Y-m-d h:i:s');
        $user_details->save();
        
        return $user_details;

    }

    public static function update_user_details($user_id,Request $request)
    {
        $update_employee_details = UserDetails::where('employee_id',$user_id)->first();
        $update_employee_details->personal_phone_no_1 = isset($request->personal_phone_no_1) ? $request->personal_phone_no_1 : $update_employee_details->personal_phone_no_1;
        $update_employee_details->personal_phone_no_2 = $request->personal_phone_no_2;
        $update_employee_details->father_phone_no = $request->father_phone_no;
        $update_employee_details->mother_phone_no = $request->mother_phone_no;
        $update_employee_details->wife_phone_no = $request->wife_phone_no;
        $update_employee_details->others_phone_no = $request->others_phone_no;
        $update_employee_details->current_address = isset($request->current_address) ? $request->current_address : $update_employee_details->current_address;
        $update_employee_details->permanent_address = isset($request->permanent_address) ? $request->permanent_address : $update_employee_details->permanent_address;
        // $update_employee_details->accessories = isset($request->accessories) ? $request->accessories : $update_employee_details->accessories;
        $update_employee_details->date_of_joining = isset($request->joining_date) ? $request->joining_date : $update_employee_details->date_of_joining;
        // $update_employee_details->joining_letter = isset($request->joining_letter) ? $request->joining_letter : $update_employee_details->joining_letter;
    
        if(request()->hasFile('profile_image')){
            if($update_employee_details->employee_image){
                $imagePath = public_path().'/uploads/users/profile_images/'.$update_employee_details->employee_image;
                if(File::exists($imagePath)){
                    unlink($imagePath);
                }
            }
            $name = date("Y_m_d_h_i_s_").request()->file('profile_image')->getClientOriginalName();
            request()->file('profile_image')->move(public_path().'/uploads/users/profile_images/', $name);
            $update_employee_details->employee_image = $name;
        }

        if(request()->hasFile('joining_letter')){
            if($update_employee_details->joining_letter){
                $imagePath = public_path().'/uploads/users/joining_letters/'.$update_employee_details->joining_letter;
                if(File::exists($imagePath)){
                    unlink($imagePath);
                }
            }
            $name = date("Y_m_d_h_i_s_").request()->file('joining_letter')->getClientOriginalName();
            request()->file('joining_letter')->move(public_path().'/uploads/users/joining_letters/', $name);
            $update_employee_details->joining_letter = $name;
        }

        if(request()->hasFile('accessories')){
            if($update_employee_details->accessories){
                $imagePath = public_path().'/uploads/users/accessories/'.$update_employee_details->accessories;
                if(File::exists($imagePath)){
                    unlink($imagePath);
                }
            }
            $name = date("Y_m_d_h_i_s_").request()->file('accessories')->getClientOriginalName();
            request()->file('accessories')->move(public_path().'/uploads/users/accessories/', $name);
            $update_employee_details->accessories = $name;
        }
        $update_employee_details->updated = date("Y-m-d h:i:s");
        $update_employee_details->save();

        return $update_employee_details;
    }


    // protected $keepRevisionOf = ['personal_phone_no_1'];
    public $timestamps = false;
    protected $table = 'user_details';
}
