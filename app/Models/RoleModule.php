<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RoleModule extends Model
{
    use HasFactory;

    //method to get module details from module_id
    public function module()
    {
        return $this->belongsTo(AppModules::class,'module_id');
    }

    public static function get_active_modules_by_role_id()
    {
        $modules = RoleModule::where('role_id',Auth::user()->role_id)->get();
        return $modules;
    }

    //delete role module rows
    public static function delete_role_module($role_id, $module_id)
    {
        return RoleModule::where('role_id', $role_id)->where('module_id',$module_id)->delete();
    }

    public static function add_role_module($role_id, $module_id, $modify_access)
    {
        $role_modules = new RoleModule;
        $role_modules->role_id = $role_id;
        $role_modules->module_id = $module_id;
        $role_modules->modify_access = $modify_access;
        $role_modules->save();
        return $role_modules;
    }

    public $timestamps = false;
    protected $table = 'modules_roles';
}
