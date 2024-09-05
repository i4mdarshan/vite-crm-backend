<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'role_id',
        'added_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //method to get employee details
    public function user_detail()
    {
        return $this->hasOne(UserDetails::class,'employee_id');
    }

    //method to get role details
    public function role_detail()
    {
        return $this->belongsTo(UserRoles::class, 'role_id');
    }

    //get parent_employee details (self-reference)
    public function parent_employee()
    {
        return $this->belongsTo(static::class, 'added_by');
    }

    //get child employees 
    public function child_employees()
    {
        return $this->hasMany(static::class,'added_by');
    }

    //relation to get firm details
    public function firm()
    {
        return $this->belongsTo(Firms::class,'firm_id');
    }

    //relation to get all leads and customers count
    public function get_leads_customers_count($user_id)
    {
        return $this->hasMany(CustomerLeadProfile::class, 'employee_id')->orWhere('customer_assigned_to', $user_id)->count();
    }

    //relation to get all leads and customers on emp_id
    public function get_leads_customers_emp_id()
    {
        return $this->hasMany(CustomerLeadProfile::class, 'employee_id');
    }

    //relation to get all leads and customers on assigned to id
    public function get_leads_customers_assigned_to_id()
    {
        return $this->hasMany(CustomerLeadProfile::class, 'customer_assigned_to');
    }

    //relation to get all leads and customers
    public function get_leads_customers_assigned()
    {
        return $this->get_leads_customers_emp_id->merge($this->get_leads_customers_assigned_to_id);
    }
    
     //method to search employees
     public function scopeSearch($query, $term)
     {
         $term = "%$term%";
         $query->where(function ($query) use($term){
             $query->where('email','LIKE',$term)
             ->orWhere('full_name','LIKE',$term)
             ->orWhereHas('parent_employee',function($query) use($term){
                 $query->where('full_name', 'LIKE', $term);
             })
             ->orWhereHas('role_detail',function($query) use($term){
                $query->where('role_name', 'LIKE', $term);
            });
         });
     }

    //method to get user
    public static function get_user($user_id)
    {
        return User::where('id', $user_id)->where('isActive', 1)->get();
    }

    //method to get user by id
    public static function get_user_by_id($user_id)
    {
        return User::where('id', $user_id)->where('isActive', 1)->first();
    }

    //method to add user
    public static function add_user(Request $request)
    {
        $user_info = new User();
        $user_info->role_id = $request->user_role;
        $user_info->firm_id = $request->user_firm;
        $user_info->full_name = $request->full_name;
        $user_info->email = $request->email;
        $user_info->password = Hash::make($request->password);
        $user_info->added_by = $request->added_by;
        $user_info->isActive = $request->employee_status;
        $user_info->created = date('Y-m-d h:i:s');
        $user_info->updated = date('Y-m-d h:i:s');
        $user_info->save();

        return $user_info;
    }

    //method to update user
    public static function update_employees($user_id, $request)
    {
        $employees_info = User::findOrFail($user_id);
        $employees_info->full_name = isset($request->full_name) ? $request->full_name : $employees_info->full_name ;
        $employees_info->email = isset($request->email) ? $request->email : $employees_info->email;
        $employees_info->role_id = isset($request->user_role) ? $request->user_role : $employees_info->role_id;
        $employees_info->firm_id = isset($request->user_firm) ? $request->user_firm : $employees_info->firm_id;
        $employees_info->password = isset($request->password) ? Hash::make($request->password) : $employees_info->password;
        $employees_info->added_by = isset($request->added_by) ? $request->added_by : $employees_info->added_by;
        $employees_info->isActive = isset($request->isActive) ? $request->isActive : $employees_info->isActive;
        $employees_info->updated = date("Y-m-d h:i:s");
        $employees_info->save();

        return $employees_info;
    }

    //method to deactivate_employee
    public static function deactivate_employee($user_id)
    {
        $employee = User::findOrFail($user_id);
        // Toggling for is_active
        if ($employee->isActive) {
            $isActive = 0;
        } else {
            $isActive = 1;
        }

        $employee->isActive = $isActive;
        $employee->updated = date('Y-m-d h:i:s');
        $employee->save();

        return $employee;
    }

    public $timestamps = false;
    protected $table = 'users';

}
