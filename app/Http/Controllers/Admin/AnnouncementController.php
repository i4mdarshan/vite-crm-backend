<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\ManageAnnouncements;
use App\Models\RoleModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AnnouncementController extends Controller
{
    //
    // initial constructor
    public function __construct()
    {
        $route_name = Route::currentRouteName();
        $this->middleware('permissioncheck:'.$route_name);

        $routeParse = explode('_',$route_name);
        if($route_name == 'home'){
            $routeName = 'home';
        }else{
            $routeName = 'manage_'.$routeParse[1];
        }

        $this->module_info = AppModules::get_module_id_by_slug($routeName);
    }

     //getter function to module id from constructor
     public function getModuleId()
     {
         return $this->module_info->id;
     }

     //function to show announcement
     public function show_announcements()
     {
        if(isset($_GET['q'])){
            $all_announcements = ManageAnnouncements::search(trim($_GET['q']))->orderBy('created','DESC')->paginate(10)->onEachSide(1)->withQueryString(); 
        }else{
            $all_announcements = ManageAnnouncements::get_all_announcements();
        }
         $modules = RoleModule::get_active_modules_by_role_id();
         $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
         return view('manage-announcement.list-announcement',[
             'app_modules' => $modules,
             'all_announcements' => $all_announcements,
             'module_access' => $module_access,
         ]);
     }
 
     public function add_announcements()
     {
         $modules = RoleModule::get_active_modules_by_role_id();
         return view('manage-announcement.add-announcement',[
             'app_modules' => $modules,
         ]);
     }
 
     public function save_announcement(Request $request)
     {
         $validated = $request->validate([
             "announcement_title" => "required|max:255",
            //  "announcement_date" => "required|min:date('Y-m-d')",
             "start_date" => "required|min:date('Y-m-d')",
             "end_date" => "required|min:date('Y-m-d')",
             "announcement_description" => "required|max:4000",
         ]);
 
         ManageAnnouncements::add_announcement($request);
 
         return redirect()->route('manage_announcement');
 
     }
 
     public function view_announcement($id)
     {
         $announcement_info = ManageAnnouncements::findOrFail($id);
         $modules = RoleModule::get_active_modules_by_role_id();
         return view('manage-announcement.view-announcement',[
             'app_modules' => $modules,
             'announcement_info' => $announcement_info,
         ]);
 
     }

     //function to edit announcemement
     public static function edit_announcement($id)
     {
        $announcement_info = ManageAnnouncements::findOrFail($id);
         $modules = RoleModule::get_active_modules_by_role_id();
         return view('manage-announcement.edit-announcement',[
             'app_modules' => $modules,
             'announcement_info' => $announcement_info,
         ]);
     }

     //function to update announcemement
     public static function update_announcement(request $request,$id)
     {
        $validated = $request->validate([
            "announcement_title" => "required|max:255",
            // "announcement_date" => "required|min:date('Y-m-d')",
            "start_date" => "required|min:date('Y-m-d')",
            "end_date" => "required|min:date('Y-m-d')",
            "announcement_description" => "required|max:4000",
        ]);

        ManageAnnouncements::update_announcement($request, $id);

        return redirect()->route('manage_announcement');
     }


     public static function delete_announcement($id)
     {
        ManageAnnouncements::where('id', $id)->delete();

        return redirect()->route('manage_announcement');
     }

}
