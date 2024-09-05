<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\ProductCategories;
use App\Models\ProductDetails;
use App\Models\ProductUnit;
use App\Models\RoleModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ProductsController extends Controller
{
    //
    // initial constructor
    public function __construct()
    {
        $route_name = Route::currentRouteName();
        $this->middleware('permissioncheck:' . $route_name);

        $routeParse = explode('_', $route_name);
        if ($route_name == 'home') {
            $routeName = 'home';
        } else {
            $routeName = 'manage_' . $routeParse[1];
        }

        $this->module_info = AppModules::get_module_id_by_slug($routeName);
    }

    //getter function to module id from constructor
    public function getModuleId()
    {
        return $this->module_info->id;
    }

    //function to show products
    public function show_products()
    {
        if (isset($_GET['q'])) {
            $all_products = ProductDetails::search(trim($_GET['q']))->paginate(10)->onEachSide(1)->withQueryString();
        } else {
            $all_products = ProductDetails::get_all_products();
        }

        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('products.list-products', [
            'all_products' => $all_products,
            'app_modules' => $modules,
            'module_access' => $module_access,
        ]);
    }

    //function to show add product form
    public static function add_products()
    {
        $modules = RoleModule::get_active_modules_by_role_id();
        $active_product_categories = ProductCategories::get_all_product_categories(1);
        $product_units = ProductUnit::all();

        return view('products.add-product', [
            'app_modules' => $modules,
            'active_product_categories' => $active_product_categories,
            'product_units' => $product_units,
        ]);
    }

    //function to save product
    public static function save_products(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'product_name' => 'required|max:40',
            'product_category' => 'required',
            'product_origin' => 'required|max:30',
            'product_hsn' => 'required|alpha_num|digits:8',
            'product_packaging' => 'required|numeric|max:999',
            'product_tax' => 'required|numeric|between:0,99.99',
            'product_tds' => 'nullable|mimes:jpg,jpeg,png,pdf,docx|max:2048',
            'product_msds' => 'nullable|mimes:jpg,jpeg,png,pdf,docx|max:2048',
            'product_unit' => 'required',
            'product_status' => 'required',
        ]);

        $product_info = ProductDetails::add_product($request);

        return redirect()->route('manage_products');
    }

    //function to edit product
    public static function edit_product($product_id)
    {
        $product_info = ProductDetails::findOrFail($product_id);
        $active_product_categories = ProductCategories::get_all_product_categories(1);
        $product_units = ProductUnit::all();
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('products.edit-product', [
            'app_modules' => $modules,
            'active_product_categories' => $active_product_categories,
            'product_units' => $product_units,
            'product_info' => $product_info,
        ]);
    }

    //function to update product
    public static function update_product(Request $request, $product_id)
    {
        $validated = $request->validate([
            'product_name' => 'required|max:40',
            'product_category' => 'required',
            'product_origin' => 'required|max:30',
            'product_hsn' => 'required|alpha_num|digits:8',
            'product_packaging' => 'required|numeric|max:999',
            'product_tax' => 'required|numeric|between:0,99.99',
            'product_tds' => 'nullable|mimes:jpg,jpeg,png,pdf,docx|max:2048',
            'product_msds' => 'nullable|mimes:jpg,jpeg,png,pdf,docx|max:2048',
            'product_status' => 'required',
        ]);

        $product_info = ProductDetails::update_product($request, $product_id);

        return redirect()->route('manage_products');
    }

    //function to delete product
    public static function delete_product($product_id)
    {
        ProductDetails::where('id', $product_id)->delete();

        return redirect()->route('manage_products');
    }
}
