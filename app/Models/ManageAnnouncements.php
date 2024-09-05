<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageAnnouncements extends Model
{
    use HasFactory;

    //method to search announcement
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use($term){
            $query->where('announcement_title','LIKE',$term);
        });
    }


    //method to get all announcements
    public static function get_all_announcements()
    {
        return ManageAnnouncements::orderBy('created','DESC')->paginate(10)->onEachSide(1)->withQueryString();
    }

    //method to add annnouncement
    public static function add_announcement($request)
    {
        $announcement_info = new ManageAnnouncements();
        $announcement_info->announcement_title = $request->announcement_title;
        $announcement_info->announcement_description = htmlspecialchars($request->announcement_description);
        // $announcement_info->announcement_date = $request->announcement_date;
        $announcement_info->start_date = $request->start_date;
        $announcement_info->end_date = $request->end_date;
        $announcement_info->created = date("Y-m-d h:i:s");
        $announcement_info->updated = date("Y-m-d h:i:s");
        $announcement_info->save();

        return $announcement_info;
    }

    //method to update announcemement
    public static function update_announcement($request, $id)
    {
        $announcement_info = ManageAnnouncements::findOrFail($id);
        $announcement_info->announcement_title = isset($request->announcement_title) ? $request->announcement_title : $announcement_info->announcement_title;
        $announcement_info->announcement_description = isset($request->announcement_description) ? htmlspecialchars($request->announcement_description) : $announcement_info->announcement_description;
        $announcement_info->start_date = isset($request->start_date) ? $request->start_date : $announcement_info->start_date;
        $announcement_info->end_date = isset($request->end_date) ? $request->end_date : $announcement_info->end_date; 
        $announcement_info->updated = date("Y-m-d h:i:s");
        $announcement_info->save();

        return $announcement_info;
    }

    public $timestamps = false;
    protected $table = 'announcement';
}
