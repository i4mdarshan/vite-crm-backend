<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\RoleModule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProfileController extends Controller
{   
    //method to view user profile
    public static function show_profile($user_id)
    {
        $user_data = User::get_user_by_id($user_id);
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-profile.show-profile', [
            'app_modules'=> $modules,
            'user_data' => $user_data]);
    }
}
