<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppModules extends Model
{
    use HasFactory;

    //method to get sub modules 
    // public function sub_module()
    // {
    //     return $this->hasMany(SubModules::class,'parent_module_id');
    // }

    public static function get_module_id_by_slug($slug)
    {
        return AppModules::where('slug','LIKE','%'.$slug.'%')->first();
    }

    public static function get_active_modules()
    {
        $manage_firms_id = config('constants.manage_firms');
        
        return AppModules::whereNotIn('id',[14])->get();
    }


    public $timestamps = false;
    protected $table = 'modules';
}
