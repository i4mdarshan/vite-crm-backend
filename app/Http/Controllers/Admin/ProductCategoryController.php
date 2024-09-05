<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\ProductCategories;
use App\Models\RoleModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ProductCategoryController extends Controller
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

    public function show_product_categories()
    {
        $product_categories = ProductCategories::get_all_product_categories();
        $modules = RoleModule::get_active_modules_by_role_id();
        // dd($product_categories);
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('product-categories.list-product-categories',[
            'product_categories' => $product_categories,
            'app_modules' => $modules,
            'module_access' => $module_access,
        ]);
    }

    public static function save_product_categories(Request $request)
    {
        $validated = $request->validate([
            'product_category_name' => "required|max:40",
            'product_category_status' => "required",
        ]);

        ProductCategories::add_product_category_name($request);

        return redirect()->route('manageCategories_products');
    }

    public static function edit_product_category($category_id)
    {
        $product_categories = ProductCategories::get_all_product_categories();
        $edit_product_category = ProductCategories::findOrFail($category_id);
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('product-categories.edit-product-category',[
            'product_categories' => $product_categories,
            'edit_product_category' => $edit_product_category,
            'app_modules' => $modules,
        ]);
    }

    public static function update_product_category(Request $request,$category_id)
    {
        $validated = $request->validate([
            'product_category_name' => "required|max:40",
            'product_category_status' => "required",
        ]);

        // dd($request);

        ProductCategories::update_product_category($request, $category_id);

        return redirect()->route('manageCategories_products');
    }

    //function to delete product product category
    public static function delete_product_category($category_id)
    {
        ProductCategories::where('id', $category_id)->delete();

        return redirect()->route('manageCategories_products');
    }
}
