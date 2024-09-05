<?php

use App\Http\Controllers\Admin\AjaxDashboardController;
use App\Http\Controllers\Admin\AjaxLeadController;
use App\Http\Controllers\Admin\AjxQuotationcontroller;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\LeadAppointmentsController;
use App\Http\Controllers\Admin\LeadContactsController;
use App\Http\Controllers\Admin\LeadCallsController;
use App\Http\Controllers\Admin\LeadsController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomerContactsController;
use App\Http\Controllers\Admin\CustomerAppointmentsController;
use App\Http\Controllers\Admin\CustomerComplaintsController;
use App\Http\Controllers\Admin\CustomerCallsController;
use App\Http\Controllers\Admin\CustomerNotesController;
use App\Http\Controllers\Admin\CustomerOrdersController;
use App\Http\Controllers\Admin\CustomerCollectionsController;
use App\Http\Controllers\Admin\CustomerBehavioursController;
use App\Http\Controllers\Admin\FirmsController;
use App\Http\Controllers\Admin\MiddlewareController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\QuotationsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserRolesController;
use App\Http\Controllers\Admin\TaskController;
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
    return redirect()->route('login');
});



Auth::routes();

Route::group(['middleware' => ['auth', 'logRequests']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/home/stats', [AjaxDashboardController::class, 'show_stats']);

    //Manage Profile
    Route::get('/manage_profile/{user_id}', [ProfileController::class, 'show_profile'])->name('manage_profile');

    //Manage Roles
    Route::get('/manage_roles', [UserRolesController::class, 'show_roles'])->name('manage_roles');
    Route::get('/manage_roles/edit/{role_id}', [UserRolesController::class, 'edit_role'])->name('edit_roles');
    Route::put('/manage_roles/update/{role_id}', [UserRolesController::class, 'update_role'])->name('update_roles');
    Route::get('/manage_roles/add', [UserRolesController::class, 'add_role'])->name('add_roles');
    Route::post('/manage_roles/save', [UserRolesController::class, 'save_role'])->name('save_roles');

    //Manage Product Categories
    Route::get('/manage_product_category', [ProductCategoryController::class, 'show_product_categories'])->name('manageCategories_products');
    Route::post('/manage_product_category/save', [ProductCategoryController::class, 'save_product_categories'])->name('saveCategory_products');
    Route::get('/manage_product_category/edit/{category_id}', [ProductCategoryController::class, 'edit_product_category'])->name('editCategory_products');
    Route::put('/manage_product_category/update/{category_id}', [ProductCategoryController::class, 'update_product_category'])->name('updateCategory_products');
    Route::get('/manage_product_category/delete/{category_id}', [ProductCategoryController::class, 'delete_product_category'])->name('deleteCategory_products');
    Route::get('/manage_product_category/search', [ProductCategoryController::class, 'show_product_categories'])->name('searchCategory_products');

    //Manage Employee
    Route::get('/manage_employees', [EmployeesController::class, 'show_employees'])->name('manage_employee');
    Route::get('/manage_employees/view/{user_id}', [EmployeesController::class, 'view_employee'])->name('view_employee');
    Route::get('/manage_employees/add', [EmployeesController::class, 'add_employee'])->name('add_employee');
    Route::post('/manage_employees/save', [EmployeesController::class, 'save_employee'])->name('save_employee');
    Route::get('/manage_employees/search', [EmployeesController::class, 'show_employees'])->name('search_employee');
    Route::get('/manage_employees/edit/{user_id}', [EmployeesController::class, 'edit_employee'])->name('edit_employee');
    Route::post('/manage_employees/update/{user_id}', [EmployeesController::class, 'update_employee'])->name('update_employee');
    Route::get('/manage_employees/deactivate/{user_id}', [EmployeesController::class, 'deactivate_employee'])->name('deactivate_employee');

    //Manage Products
    Route::get('/manage_products', [ProductsController::class, 'show_products'])->name('manage_products');
    Route::get('/manage_products/search', [ProductsController::class, 'show_products'])->name('search_products');
    Route::get('/manage_products/add', [ProductsController::class, 'add_products'])->name('add_products');
    Route::post('/manage_products/save', [ProductsController::class, 'save_products'])->name('save_products');
    Route::get('/manage_products/edit/{product_id}', [ProductsController::class, 'edit_product'])->name('edit_products');
    Route::put('/manage_products/update/{product_id}', [ProductsController::class, 'update_product'])->name('update_products');
    Route::get('/manage_products/delete/{product_id}', [ProductsController::class, 'delete_product'])->name('delete_products');

    //Manage Firms
    //Manage Products
    Route::get('/manage_firms', [FirmsController::class, 'show_firms'])->name('manage_firms');
    Route::get('/manage_firms/edit/{firm_id}', [FirmsController::class, 'edit_firm'])->name('edit_firms');
    Route::post('/manage_firms/update', [FirmsController::class, 'update_firm'])->name('update_firms');

    //Manage Leads
    Route::get('/manage_leads', [LeadsController::class, 'show_leads'])->name('manage_leads');
    Route::get('/manage_leads/add', [LeadsController::class, 'add_lead'])->name('add_leads');
    Route::post('/manage_leads/save', [LeadsController::class, 'save_lead'])->name('save_leads');
    Route::get('/manage_leads/edit/{lead_id}', [LeadsController::class, 'edit_lead'])->name('edit_leads');
    Route::put('/manage_leads/update/{lead_id}', [LeadsController::class, 'update_lead'])->name('update_leads');
    Route::get('/manage_leads/search', [LeadsController::class, 'show_leads'])->name('search_leads');

    //Manage Lead Profile
    Route::get('/manage_leads/view/profile/{lead_id}', [LeadsController::class, 'view_lead'])->name('viewProfile_leads');
    Route::get('/manage_leads/convert/{lead_id}', [LeadsController::class, 'convert_lead'])->name('convert_leads');

    //Manage Lead Contacts
    Route::get('/manage_leads/view/contacts/{lead_id}', [LeadContactsController::class, 'view_lead_contacts'])->name('viewContacts_leads');
    Route::get('/manage_leads/view/contacts/add/{lead_id}', [LeadContactsController::class, 'add_lead_contacts'])->name('addContacts_leads');
    Route::post('/manage_leads/view/contacts/save/{lead_id}', [LeadContactsController::class, 'save_lead_contacts'])->name('saveContacts_leads');
    Route::get('/manage_leads/view/contacts/detail/{lead_id}/{contact_id}', [LeadContactsController::class, 'view_lead_contact_detail'])->name('viewContactDetails_leads');
    Route::get('/manage_leads/view/contacts/edit/{lead_id}/{contact_id}', [LeadContactsController::class, 'edit_lead_contact'])->name('editContact_leads');
    Route::post('/manage_leads/view/contacts/update/{lead_id}/{contact_id}', [LeadContactsController::class, 'update_lead_contact'])->name('updateContact_leads');
    Route::get('/manage_leads/view/contacts/{lead_id}/search', [LeadContactsController::class, 'view_lead_contacts'])->name('searchContacts_leads');

    //Manage Lead appointments
    Route::get('/manage_leads/view/appointments/{lead_id}', [LeadAppointmentsController::class, 'list_lead_appointments'])->name('viewAppointments_leads');
    Route::get('/manage_leads/view/appointments/detail/{lead_id}/{appointment_id}', [LeadAppointmentsController::class, 'view_lead_appointment'])->name('viewAppointmentDetails_leads');
    Route::get('/manage_leads/view/appointments/add/{lead_id}', [LeadAppointmentsController::class, 'add_lead_appointment'])->name('addAppointment_leads');
    Route::post('/manage_leads/view/appointments/save/{lead_id}', [LeadAppointmentsController::class, 'save_lead_appointment'])->name('saveAppointment_leads');
    Route::get('/manage_leads/view/appointments/{lead_id}/search', [LeadAppointmentsController::class, 'list_lead_appointments'])->name('searchAppointments_leads');


    //Manage Lead Calls
    Route::get('/manage_leads/view/calls/{lead_id}', [LeadCallsController::class, 'list_lead_calls'])->name('viewCalls_leads');
    Route::get('/manage_leads/view/calls/detail/{lead_id}/{call_id}', [LeadCallsController::class, 'view_lead_calls'])->name('viewCallsDetails_leads');
    Route::get('/manage_leads/view/calls/add/{lead_id}', [LeadCallsController::class, 'add_lead_calls'])->name('addCalls_leads');
    Route::post('/manage_leads/view/calls/save/{lead_id}', [LeadCallsController::class, 'save_lead_calls'])->name('saveCalls_leads');
    Route::get('/manage_filter/view/calls/{lead_id}/search', [LeadCallsController::class, 'list_lead_calls'])->name('searchCalls_leads');

    //Manage Customer
    Route::get('/manage_customers', [CustomerController::class, 'show_customers'])->name('manage_customers');
    Route::get('/manage_customers/add', [CustomerController::class, 'add_customers'])->name('add_customers');
    Route::post('/manage_customers/save', [CustomerController::class, 'save_customers'])->name('save_customers');
    Route::get('/manage_customers/edit/{customer_id}', [CustomerController::class, 'edit_customer'])->name('edit_customers');
    Route::put('/manage_customers/update/{customer_id}', [CustomerController::class, 'update_customer'])->name('update_customers');
    Route::get('/manage_customers/search', [CustomerController::class, 'show_customers'])->name('search_customers');

    //Manage Customer Profile
    Route::get('/manage_customers/view/profile/{customer_id}', [CustomerController::class, 'view_customer'])->name('viewProfile_customers');

    //Manage Customer Contacts
    Route::get('/manage_customers/view/contacts/{customer_id}', [CustomerContactsController::class, 'view_customer_contacts'])->name('viewContacts_customers');
    Route::get('/manage_customers/view/contacts/add/{customer_id}', [CustomerContactsController::class, 'add_customer_contacts'])->name('addContacts_customers');
    Route::post('/manage_customers/view/contacts/save/{customer_id}', [CustomerContactsController::class, 'save_customer_contacts'])->name('saveContacts_customers');
    Route::get('/manage_customers/view/contacts/detail/{customer_id}/{contact_id}', [CustomerContactsController::class, 'view_customer_contact_detail'])->name('viewContactDetails_customers');
    Route::get('/manage_customers/view/contacts/edit/{customer_id}/{contact_id}', [CustomerContactsController::class, 'edit_customer_contact'])->name('editContact_customers');
    Route::post('/manage_customers/view/contacts/update/{customer_id}/{contact_id}', [CustomerContactsController::class, 'update_customer_contact'])->name('updateContact_customers');
    Route::get('/manage_customers/view/contacts/{customer_id}/search', [CustomerContactsController::class, 'view_customer_contacts'])->name('searchContacts_customers');


    //Manage Customer appointments
    Route::get('/manage_customers/view/appointments/{customer_id}', [CustomerAppointmentsController::class, 'list_customer_appointments'])->name('viewAppointments_customers');
    Route::get('/manage_customers/view/appointments/detail/{customer_id}/{appointment_id}', [CustomerAppointmentsController::class, 'view_customer_appointment'])->name('viewAppointmentDetails_customers');
    Route::get('/manage_customers/view/appointments/add/{customer_id}', [CustomerAppointmentsController::class, 'add_customer_appointment'])->name('addAppointment_customers');
    Route::post('/manage_customers/view/appointments/save/{customer_id}', [CustomerAppointmentsController::class, 'save_customer_appointment'])->name('saveAppointment_customers');
    Route::get('/manage_customers/view/appointments/{customer_id}/search', [CustomerAppointmentsController::class, 'list_customer_appointments'])->name('searchAppointments_customers');

    //Manage Customer Calls
    Route::get('/manage_customers/view/calls/{customer_id}', [CustomerCallsController::class, 'list_customer_calls'])->name('viewCalls_customers');
    Route::get('/manage_customers/view/calls/detail/{customer_id}/{call_id}', [CustomerCallsController::class, 'view_customer_calls'])->name('viewCallsDetails_customers');
    Route::get('/manage_customers/view/calls/add/{customer_id}', [CustomerCallsController::class, 'add_customer_calls'])->name('addCalls_customers');
    Route::post('/manage_customers/view/calls/save/{customer_id}', [CustomerCallsController::class, 'save_customer_calls'])->name('saveCalls_customers');
    Route::get('/manage_filter/view/calls/{customer_id}', [AjaxCustomerController::class, 'filter_date'])->name('filter_customer_calls');
    Route::get('/manage_customers/view/calls/{customer_id}/search', [CustomerCallsController::class, 'list_customer_calls'])->name('searchCalls_customers');


    //Manage Customer notes
    Route::get('/manage_customers/view/notes/{customer_id}', [CustomerNotesController::class, 'list_customer_notes'])->name('viewNotes_customers');
    Route::get('/manage_customers/view/notes/detail/{customer_id}/{note_id}', [CustomerNotesController::class, 'view_customer_note'])->name('viewNoteDetails_customers');
    Route::get('/manage_customers/view/notes/add/{customer_id}', [CustomerNotesController::class, 'add_customer_note'])->name('addNote_customers');
    Route::post('/manage_customers/view/notes/save/{customer_id}', [CustomerNotesController::class, 'save_customer_note'])->name('saveNote_customers');
    Route::get('/manage_customers/view/notes/{customer_id}/search', [CustomerNotesController::class, 'list_customer_notes'])->name('searchNotes_customers');


    //Manage Customer Complaints
    Route::get('/manage_customers/view/complaints/{customer_id}', [CustomerComplaintsController::class, 'list_customer_complaints'])->name('viewComplaints_customers');
    Route::get('/manage_customers/view/complaints/detail/{customer_id}/{complaint_id}', [CustomerComplaintsController::class, 'view_customer_complaints'])->name('viewComplaintDetails_customers');
    Route::get('/manage_customers/view/complaints/add/{customer_id}', [CustomerComplaintsController::class, 'add_customer_Complaints'])->name('addComplaints_customers');
    Route::post('/manage_customers/view/complaints/save/{customer_id}', [CustomerComplaintsController::class, 'save_customer_complaints'])->name('saveComplaints_customers');
    Route::post('/manage_customers/view/complaints/status/update/{customer_id}/{complaint_id}', [CustomerComplaintsController::class, 'update_complaint_status'])->name('updateComplaintsStatus_customers');
    Route::get('/manage_customers/view/complaints/edit/{customer_id}/{complaint_id}', [CustomerComplaintsController::class, 'edit_customer_complaints'])->name('editComplaints_customers');
    Route::post('/manage_customers/view/complaints/update/{customer_id}/{complaint_id}', [CustomerComplaintsController::class, 'update_customer_complaints'])->name('updateComplaints_customers');
    Route::post('/manage_customers/view/complaints_photo/delete', [CustomerComplaintsController::class, 'delete_complaint_photo'])->name('deleteComplaintPhotos_customers');

    //Manage Customer Orders
    // check if order is getting sved succesfully
    // check if the order details are visible 
    // check if the pdf is getting generated
    // check validations
    // check page navigations
    Route::get('/manage_customers/view/orders/{customer_id}', [CustomerOrdersController::class, 'list_customer_orders'])->name('viewOrders_customers');
    Route::get('/manage_customers/view/orders/detail/{customer_id}/{order_id}', [CustomerOrdersController::class, 'view_customer_order'])->name('viewOrderDetails_customers');
    Route::get('/manage_customers/view/orders/{customer_id}/search', [CustomerOrdersController::class, 'list_customer_orders'])->name('searchOrder_customers');
    Route::get('/manage_customers/view/orders/add/{customer_id}', [CustomerOrdersController::class, 'add_customer_order'])->name('addOrder_customers');
    Route::post('/manage_customers/view/orders/save/{customer_id}', [CustomerOrdersController::class, 'save_customer_order'])->name('saveOrder_customers');
    Route::get('/manage_customers/view/orders/download/{customer_id}', [CustomerOrdersController::class, 'download_pdf'])->name('downloadOrderPdf_customers');
    Route::get('/manage_customers/view/orders/delete/{customer_id}/{order_id}', [CustomerOrdersController::class, 'delete_order'])->name('deleteOrder_customers');

    //Manage Customer Collection
    Route::get('/manage_customers/view/collections/{customer_id}', [CustomerCollectionsController::class, 'list_customer_collections'])->name('viewCollections_customers');
    Route::get('/manage_customers/view/collections/{customer_id}/search', [CustomerCollectionsController::class, 'list_customer_collections'])->name('searchCollections_customers');
    Route::get('/manage_customers/view/collections/add/{customer_id}', [CustomerCollectionsController::class, 'add_customer_collections'])->name('addCollections_customers');
    Route::post('/manage_customers/view/collections/save/{customer_id}', [CustomerCollectionsController::class, 'save_customer_collections'])->name('saveCollections_customers');
    Route::get('/manage_customers/view/collections/detail/{customer_id}/{collection_id}', [CustomerCollectionsController::class, 'view_customer_collection_detail'])->name('viewCollectionDetails_customers');
    Route::get('/manage_customers/view/collections/edit/{customer_id}/{collection_id}', [CustomerCollectionsController::class, 'edit_customer_collection'])->name('editCollection_customers');
    Route::post('/manage_customers/view/collections/update/{customer_id}/{collection_id}', [CustomerCollectionsController::class, 'update_customer_collection'])->name('updateCollection_customers');
    Route::get('/manage_customers/view/collections/delete/{customer_id}/{collection_id}', [CustomerCollectionsController::class, 'delete_collection'])->name('deleteCollection_customers');

    //Manage Customer Behaviour
    Route::get('/manage_customers/view/behaviours/{customer_id}', [CustomerBehavioursController::class, 'view_customer_behaviour_detail'])->name('viewBehaviourDetails_customers');
    Route::get('/manage_customers/view/behaviours/edit/{customer_id}', [CustomerBehavioursController::class, 'edit_customer_behaviour'])->name('editBehaviours_customers');
    Route::post('/manage_customers/view/behaviours/update/{customer_id}', [CustomerBehavioursController::class, 'update_customer_behaviour'])->name('updateBehaviour_customers');


    //Manage Quotations
    Route::get('/manage_quotations', [QuotationsController::class, 'list_quotations'])->name('manage_quotations');
    Route::get('/manage_quotations/search', [QuotationsController::class, 'list_quotations'])->name('search_quotations');
    Route::get('/manage_quotations/add', [QuotationsController::class, 'add_quotations'])->name('add_quotations');
    Route::post('/manage_quotations/save', [QuotationsController::class, 'save_quotation'])->name('save_quotations');
    Route::get('/manage_quotations/delete/{quotation_id}', [QuotationsController::class, 'delete_quotation'])->name('delete_quotations');
    Route::get('/manage_quotations/detail/{quotation_id}', [QuotationsController::class, 'view_quotation'])->name('view_quotations');
    Route::get('/manage_quotations/edit/{quotation_id}', [QuotationsController::class, 'edit_quotation'])->name('edit_quotations');
    Route::post('/manage_quotations/update/{quotation_id}', [QuotationsController::class, 'update_quotation'])->name('update_quotations');
    // Route::post('/manage_quotations/preview', [QuotationsController::class,'stream_quotations'])->name('stream_quotations');
    Route::get('/manage_quotations/download/{quotation_id}/{old}', [QuotationsController::class, 'download_pdf'])->name('downloadPdf_quotations');

    // Ajax Calls for details
    Route::get('/ajax_autocomplete_search_product', [AjxQuotationcontroller::class, 'selectSearchProduct'])->name('select2SearchProduct');
    Route::get('/ajax_autocomplete_search_lead', [AjxQuotationcontroller::class, 'selectSearchClient'])->name('select2SearchClient');
    Route::post('/get_firm_details', [AjxQuotationcontroller::class, 'get_firm_details']);
    Route::post('/get_client_address', [AjxQuotationcontroller::class, 'get_client_address']);
    Route::post('/get_product_details', [AjxQuotationcontroller::class, 'get_product_details']);

    //Manage Announcement
    Route::group(['prefix' => 'manage_announcement'], function () {
        Route::get('/', [AnnouncementController::class, 'show_announcements'])->name('manage_announcement');
        Route::get('/add', [AnnouncementController::class, 'add_announcements'])->name('add_announcement');
        Route::post('/save', [AnnouncementController::class, 'save_announcement'])->name('save_announcement');
        Route::get('/view/{id}', [AnnouncementController::class, 'view_announcement'])->name('view_announcement');
        Route::get('/edit/{id}', [AnnouncementController::class, 'edit_announcement'])->name('edit_announcement');
        Route::put('/update/{id}', [AnnouncementController::class, 'update_announcement'])->name('update_announcement');
        Route::get('/delete/{id}', [AnnouncementController::class, 'delete_announcement'])->name('delete_announcement');
        Route::get('/search', [AnnouncementController::class, 'show_announcements'])->name('search_announcement');
    });

    //Manage Task
    Route::group(['prefix' => 'manage_tasks'], function () {
        Route::get('/', [TaskController::class, 'getMyTask'])->name('manage_tasks');
        Route::get('/my_task/view/{id}', [TaskController::class, 'view_tasks'])->name('view_tasks');
        Route::get('/my_task/forward/{id}', [TaskController::class, 'forward_tasks'])->name('forward_tasks');
        Route::get('/my_task/edit/{id}', [TaskController::class, 'edit_mytasks'])->name('editMy_tasks');
        Route::put('/my_task/update/{id}', [TaskController::class, 'update_mytask'])->name('update_mytasks');
        Route::get('/assigned_task', [TaskController::class, 'getAssginedTask'])->name('assigned_tasks');
        Route::get('/assigned_task/add', [TaskController::class, 'addtask'])->name('add_tasks');
        Route::post('/assigned_task/save', [TaskController::class, 'save_tasks'])->name('save_tasks');
        Route::get('/assigned_task/edit/{id}', [TaskController::class, 'edit_task'])->name('edit_tasks');
        Route::get('/assigned_task/delete/{id}', [TaskController::class, 'delete_tasks'])->name('delete_tasks');
        Route::put('/assigned_task/update/{id}', [TaskController::class, 'update_task'])->name('update_tasks');
        Route::get('/search_task', [TaskController::class, 'getAssginedTask'])->name('search_tasks');
    });

    //Manage Reports
    Route::group(['prefix' => 'manage_reports'], function () {
        Route::get('/', [ReportController::class, 'show_reports'])->name('manage_reports');
        Route::get('/lead', [ReportController::class, 'show_lead_reports'])->name('lead_reports');
        Route::post('/lead', [ReportController::class, 'show_lead_reports'])->name('lead_reports');
        Route::post('/lead/export', [ReportController::class, 'export_leads_reports'])->name('exportLead_reports');
        Route::get('/complaint', [ReportController::class, 'complaint_reports'])->name('complaint_reports');
        Route::get('/complaint/filter', [ReportController::class, 'complaint_reports'])->name('complaintFilter_reports');
        Route::get('/collection', [ReportController::class, 'show_collection_reports'])->name('collection_reports');
        Route::post('/collection', [ReportController::class, 'show_collection_reports'])->name('collection_reports');
        Route::post('/collection/export', [ReportController::class, 'export_collection_reports'])->name('exportCollection_reports');
        Route::get('/order', [ReportController::class, 'order_reports'])->name('order_reports');
        Route::get('/order/filter', [ReportController::class, 'order_reports'])->name('orderFilter_reports');
        Route::get('/call', [ReportController::class, 'call_reports'])->name('call_reports');
        Route::get('/call/filter', [ReportController::class, 'call_reports'])->name('callFilter_reports');
        Route::get('/appointment', [ReportController::class, 'appointment_reports'])->name('appointment_reports');
        Route::get('/appointment/filter', [ReportController::class, 'appointment_reports'])->name('appointmentFilter_reports');
    });

});

Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/access_forbidden', [MiddlewareController::class, 'access_forbidden'])->name('access_forbidden');
