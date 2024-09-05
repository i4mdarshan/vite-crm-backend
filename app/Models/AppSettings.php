<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSettings extends Model
{
    use HasFactory;

    //method to get app settings
    public static function get_app_settings()
    {
        return AppSettings::first();
    }
}
