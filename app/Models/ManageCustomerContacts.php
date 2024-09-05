<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ManageCustomerContacts extends Model
{
    use HasFactory;

    //method to add contact
    public static function add_contact($customer_id,$employee_id,$request)
    {
        $contact_info = new ManageCustomerContacts;
        $contact_info->employee_id = $employee_id;
        $contact_info->customer_id = $customer_id;
        $contact_info->contact_person_name = $request->person_name;
        $contact_info->contact_number = $request->phone_number;
        $contact_info->contact_designation = $request->designation;
        $contact_info->contact_email = $request->person_email;
        $contact_info->contact_notes = $request->notes;
        $contact_info->isActive = $request->contact_status;

        if(request()->hasFile('contact_image')){
            $name = $request->file('contact_image')->getClientOriginalName();
            $request->file('contact_image')->move(public_path().'/uploads/customers/contact-person-images/', $name);
            $contact_info->contact_person_image = $name;
        }

        $contact_info->created = date('y-m-d h:i:s');
        $contact_info->updated = date('y-m-d h:i:s');
        $contact_info->save();

        return $contact_info;
    }

    //method to update contact
    public static function update_contact($contact_id, $request)
    {
        // dd($request);
        $contact_info = ManageCustomerContacts::findOrFail($contact_id);
        $contact_info->contact_person_name = isset($request->person_name) ? $request->person_name : $contact_info->contact_person_name ;
        $contact_info->contact_number = isset($request->phone_number) ? $request->phone_number : $contact_info->contact_number;
        $contact_info->contact_designation = isset($request->designation) ? $request->designation : $contact_info->contact_designation ;
        $contact_info->contact_email = isset($request->person_email) ? $request->person_email : $contact_info->contact_email;
        $contact_info->contact_notes = isset($request->notes) ? $request->notes : $contact_info->contact_notes;
        $contact_info->isActive = isset($request->contact_status) ? $request->contact_status : $contact_info->isActive;


        if(request()->hasFile('contact_image')){
            if($contact_info->contact_person_image){
                $imagePath = public_path().'/uploads/customers/contact-person-images/'.$contact_info->contact_person_image;
                if(File::exists($imagePath)){
                    unlink($imagePath);
                }
            }
            $name = request()->file('contact_image')->getClientOriginalName();
            request()->file('contact_image')->move(public_path().'/uploads/customers/contact-person-images/', $name);
            $contact_info->contact_person_image = $name;
        }

        $contact_info->updated = date('y-m-d h:i:s');
        $contact_info->save();
        return $contact_info;
    }

    public $timestamps = false;
    protected $table = 'customer_contacts';
}
