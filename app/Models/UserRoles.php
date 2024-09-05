<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserRoles extends Model
{
    use HasFactory;

    //method to get modules for user role
    public function modules()
    {
        return $this->hasMany(RoleModule::class,'role_id');
    }

    //method to get all user roles
    public static function get_all_user_roles()
    {
        $user = Auth::user();
        return UserRoles::get();
    }

    //Method to add user roles
    public static function add_user_roles($request){

        $user = Auth::user();

        $user_roles = new UserRoles;
        $user_roles->role_name = $request->role_name;
        $user_roles->user_id = $user->id;
        $user_roles->isActive = $request->role_status;
        $user_roles->created = date("Y-m-d h:i:s");
        $user_roles->save();
        return $user_roles;
    }

    //method to get user role details by id
    public static function get_user_role_details($id)
    {
        return UserRoles::findOrFail($id);
    }

    //method to update user role
    public static function update_user_role($request, $role_id)
    {
        $user_roles = UserRoles::get_user_role_details($role_id);
        $user_roles->role_name = isset($request->role_name) ? $request->role_name : $user_roles->role_name;
        $user_roles->isActive = isset($request->role_status) ? $request->role_status : $user_roles->isActive;
        $user_roles->updated = date("Y-m-d h:i:s");
        $user_roles->save();
        return $user_roles;
    }

    public $timestamps = false;
    protected $table = 'user_roles';
}
