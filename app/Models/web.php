<?php

use App\Http\Controllers\Admin\AjaxLeadController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\LeadAppointmentsController;
use App\Http\Controllers\Admin\LeadContactsController;
use App\Http\Controllers\Admin\LeadCallsController;
use App\Http\Controllers\Admin\LeadsController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\MiddlewareController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\QuotationsController;
use App\Http\Controllers\Admin\UserRolesController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!

    install node js -> https://nodejs.org/dist/v16.13.1/node-v16.13.1-x64.msi
    npm install
    composer update
    setup .env file

    Commands to be used

    1) Make model -> php artisan make:model  (ModelName)->shouldAlways be in CamelCase model will be created in app/Http/Models
    2) Make controller -> php artisan make:controller folder_Name/Controller_NameController controller will be created in app/Http/Controllers/Admin
    3) To run application -> start xampp and run command -> php artisan serve
    4) Create views(html) inside -> resources/views/module_name_folder/name-of-file.blade.php 

|
*/

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::middleware('auth')->group(function(){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Manage Roles
    Route::get('/manage_roles',[UserRolesController::class, 'show_roles'])->name('manage_roles');
    Route::get('/manage_roles/edit/{role_id}',[UserRolesController::class, 'edit_role'])->name('edit_roles');
    Route::put('/manage_roles/update/{role_id}',[UserRolesController::class, 'update_role'])->name('update_roles');
    Route::get('/manage_roles/add',[UserRolesController::class, 'add_role'])->name('add_roles');
    Route::post('/manage_roles/save',[UserRolesController::class, 'save_role'])->name('save_roles');

    //Manage Product Categories
    Route::get('/manage_product_category', [ProductCategoryController::class, 'show_product_categories'])->name('manageCategories_products');
    Route::post('/manage_product_category/save', [ProductCategoryController::class, 'save_product_categories'])->name('saveCategory_products');
    Route::get('/manage_product_category/edit/{category_id}', [ProductCategoryController::class, 'edit_product_category'])->name('editCategory_products');
    Route::put('/manage_product_category/update/{category_id}', [ProductCategoryController::class, 'update_product_category'])->name('updateCategory_products');
    Route::get('/manage_product_category/delete/{category_id}', [ProductCategoryController::class, 'delete_product_category'])->name('deleteCategory_products');

    //Manage Employee
    Route::get('/manage_employees',[EmployeesController::class, 'show_employees'])->name('manage_employee');
    Route::get('/manage_employees/view/{user_id}',[EmployeesController::class, 'view_employee'])->name('view_employee');
    Route::get('/manage_employees/add',[EmployeesController::class, 'add_employee'])->name('add_employee');
    Route::post('/manage_employees/save',[EmployeesController::class, 'save_employee'])->name('save_employee');

    //Manage Products
    Route::get('/manage_products', [ProductsController::class, 'show_products'])->name('manage_products');
    // Route with method                Controller to be used  function to be used from controller   route name/slug
    Route::get('/manage_products/add', [ProductsController::class, 'add_products'])->name('add_products');
    Route::post('/manage_products/save', [ProductsController::class, 'save_products'])->name('save_products');
    Route::get('/manage_products/edit/{product_id}', [ProductsController::class, 'edit_product'])->name('edit_products');
    Route::put('/manage_products/update/{product_id}', [ProductsController::class, 'update_product'])->name('update_products');
    Route::get('/manage_products/delete/{product_id}', [ProductsController::class, 'delete_product'])->name('delete_products');
    
    //Manage Leads
    Route::get('/manage_leads', [LeadsController::class, 'show_leads'])->name('manage_leads');
    Route::get('/manage_leads/add', [LeadsController::class, 'add_lead'])->name('add_leads');
    Route::post('/manage_leads/save', [LeadsController::class, 'save_lead'])->name('save_leads');
    Route::get('/manage_leads/edit/{lead_id}', [LeadsController::class, 'edit_lead'])->name('edit_leads');
    Route::put('/manage_leads/update/{lead_id}', [LeadsController::class, 'update_lead'])->name('update_leads');

    //Manage Lead Profile
    Route::get('/manage_leads/view/profile/{lead_id}', [LeadsController::class, 'view_lead'])->name('viewProfile_leads');
 

    //Manage Lead Contacts
    Route::get('/manage_leads/view/contacts/{lead_id}', [LeadContactsController::class, 'view_lead_contacts'])->name('viewContacts_leads');
    Route::get('/manage_leads/view/contacts/add/{lead_id}', [LeadContactsController::class, 'add_lead_contacts'])->name('addContacts_leads');
    Route::post('/manage_leads/view/contacts/save/{lead_id}', [LeadContactsController::class, 'save_lead_contacts'])->name('saveContacts_leads');
    Route::get('/manage_leads/view/contacts/detail/{lead_id}/{contact_id}', [LeadContactsController::class, 'view_lead_contact_detail'])->name('viewContactDetails_leads');
    Route::get('/manage_leads/view/contacts/edit/{lead_id}/{contact_id}', [LeadContactsController::class, 'edit_lead_contact'])->name('editContact_leads');
    Route::post('/manage_leads/view/contacts/update/{lead_id}/{contact_id}', [LeadContactsController::class, 'update_lead_contact'])->name('updateContact_leads');

    //Manage Lead appointments
    Route::get('/manage_leads/view/appointments/{lead_id}', [LeadAppointmentsController::class, 'list_lead_appointments'])->name('viewAppointments_leads');
    Route::get('/manage_leads/view/appointments/detail/{lead_id}/{appointment_id}', [LeadAppointmentsController::class, 'view_lead_appointment'])->name('viewAppointmentDetails_leads');
    Route::get('/manage_leads/view/appointments/add/{lead_id}', [LeadAppointmentsController::class, 'add_lead_appointment'])->name('addAppointment_leads');
    Route::post('/manage_leads/view/appointments/save/{lead_id}', [LeadAppointmentsController::class, 'save_lead_appointment'])->name('saveAppointment_leads');


    //Manage Calls
    Route::get('/manage_leads/view/calls/{lead_id}', [LeadCallsController::class, 'list_lead_calls'])->name('viewCalls_leads');
    Route::get('/manage_leads/view/calls/detail/{lead_id}/{call_id}', [LeadCallsController::class, 'view_lead_calls'])->name('viewCallsDetails_leads');
    Route::get('/manage_leads/view/calls/add/{lead_id}', [LeadCallsController::class, 'add_lead_calls'])->name('addCalls_leads');
    Route::post('/manage_leads/view/calls/save/{lead_id}', [LeadCallsController::class, 'save_lead_calls'])->name('saveCalls_leads');
    Route::get('/manage_filter/view/calls/{lead_id}', [AjaxLeadController::class, 'filter_date'])->name('filter_lead_calls');

    //Manage Customer
    Route::get('/manage_customers', [CustomerController::class, 'show_customers'])->name('manage_customers');
    Route::get('/manage_customers/add', [CustomerController::class, 'add_customers'])->name('add_customers');
    Route::post('/manage_customers/save', [CustomerController::class, 'save_customers'])->name('save_customers');
    Route::get('/manage_customers/edit/{customer_id}', [CustomerController::class, 'edit_customer'])->name('edit_customers');
    Route::put('/manage_customers/update/{customer_id}', [CustomerController::class, 'update_customer'])->name('update_customers');

    //Manage Customer Profile
    Route::get('/manage_customers/view/profile/{customer_id}', [CustomerController::class, 'view_customer'])->name('viewProfile_customers');



    //Manage Quotations
    Route::get('/manage_quotations', [QuotationsController::class,'list_quotations'])->name('manage_quotations');
    

    //Manage Announcement
    Route::get('/manage_announcement', [AnnouncementController::class, 'show_announcements'])->name('manage_announcement');
    Route::get('/manage_announcement/add', [AnnouncementController::class, 'add_announcements'])->name('add_announcement');
    Route::post('/manage_announcement/save', [AnnouncementController::class, 'save_announcement'])->name('save_announcement');
    Route::get('/manage_announcement/view/{id}', [AnnouncementController::class, 'view_announcement'])->name('view_announcement');
    Route::get('/manage_announcement/edit/{id}', [AnnouncementController::class, 'edit_announcement'])->name('edit_announcement');
    Route::put('/manage_announcement/update/{id}', [AnnouncementController::class, 'update_announcement'])->name('update_announcement');
    Route::get('/manage_announcement/delete/{id}', [AnnouncementController::class, 'delete_announcement'])->name('delete_announcement');

    //Manage Task
    Route::get('/manage_tasks', [TaskController::class, 'getMyTask'])->name('manage_tasks');
    Route::get('/manage_tasks/assigned', [TaskController::class, 'getAssginedTask'])->name('assigned_tasks');
    Route::get('/manage_tasks/add', [TaskController::class, 'addtask'])->name('add_tasks');
    Route::post('/manage_tasks/save', [TaskController::class, 'save_tasks'])->name('save_tasks');
    Route::get('/manage_tasks/view/{id}', [TaskController::class, 'view_tasks'])->name('view_tasks');
    Route::get('/manage_tasks/edit/{id}', [TaskController::class, 'edit_task'])->name('edit_tasks');
    Route::get('/manage_tasks/myedit/{id}', [TaskController::class, 'edit_mytasks'])->name('edit_mytasks');
    Route::put('/manage_tasks/update/{id}', [TaskController::class, 'update_task'])->name('update_tasks');
    Route::put('/manage_tasks/updatemytask/{id}', [TaskController::class, 'update_mytask'])->name('update_mytasks');
    Route::get('/manage_tasks/delete/{id}', [TaskController::class, 'delete_tasks'])->name('delete_tasks');

    //Manage Reports
    Route::get('/manage_reports', [ReportController::class, 'show_reports'])->name('manage_reports');
    Route::get('/manage_reports/lead', [ReportController::class, 'lead_reports'])->name('lead_reports');

});

Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/access_forbidden', [MiddlewareController::class, 'access_forbidden'])->name('access_forbidden');
