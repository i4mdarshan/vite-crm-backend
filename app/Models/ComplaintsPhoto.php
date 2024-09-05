<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class ComplaintsPhoto extends Model
{
    use HasFactory;
    
    public static function delete_complaint_photo($complaint_photo_id)
    {
        $complaint_photo_info = ComplaintsPhoto::findOrFail($complaint_photo_id);
        if(File::exists(public_path('/uploads/customers/complaint-image/'.$complaint_photo_info->image_name))){
            File::delete(public_path('/uploads/customers/complaint-image/'.$complaint_photo_info->image_name));
            return ComplaintsPhoto::where('id', $complaint_photo_id)->delete();
        }else{
            return false;
        }
    }

    public $timestamps = false;
    protected $table = 'complaint_images';
}
