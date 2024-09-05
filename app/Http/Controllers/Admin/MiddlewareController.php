<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MiddlewareController extends Controller
{
    //
    //access forbidden page
    public function access_forbidden()
    {
        return view('access-forbidden');
    }

}
