@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')
    <div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ route('manage_customers') }}" class="btn btn-primary px-3">
                        <span class="text-secondary h3"><i class="ni ni-bold-left mr-2"
                                style="font-size: 14px; vertical-align: middle;"></i>Manage Customers</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <h1 class="mb-0">Edit Customer</h1>
                        @if ($errors->has('message'))
                            <span class="text-danger"></span>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $errors->first('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <form action="{{ route('update_customers', $customer_details->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="m-3">

                            <div class="row mx-2">
                                <div class="col-md-6">
                                    <h2 class="mb-3">Basic Details</h2>
                                    <div class="form-group">
                                        <label for="customer_name">Enter Customer Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="customer_name"
                                            class="form-control @error('customer_name') is-invalid @enderror"
                                            id="customer_name"
                                            value="{{ old('customer_name', $customer_details->customer_name) }}"
                                            maxlength="255" placeholder="Enter Customer Name">
                                        @error('customer_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="customer_owner_name">Enter Customer Owner Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="customer_owner_name"
                                            class="form-control @error('customer_owner_name') is-invalid @enderror"
                                            id="customer_owner_name"
                                            value="{{ old('customer_owner_name', $customer_details->customer_owner_name) }}"
                                            maxlength="255" placeholder="Enter Customer Owner Name">
                                        @error('customer_owner_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="customer_type">Customer Type <span class="text-danger">*</span></label>
                                        <select class="form-control @error('customer_type') is-invalid @enderror"
                                            name="customer_type" id="customer_type">Manufacturer, Distributor, Retailer,
                                            Dealer
                                            <option value="">Choose Type</option>
                                            <option value="manufacturer"
                                                {{ old('customer_type', $customer_details->customer_type) == 'manufacturer' ? 'selected' : '' }}>
                                                Manufacturer</option>
                                            <option value="distributor"
                                                {{ old('customer_type', $customer_details->customer_type) == 'distributor' ? 'selected' : '' }}>
                                                Distributor</option>
                                            <option value="retailer"
                                                {{ old('customer_type', $customer_details->customer_type) == 'retailer' ? 'selected' : '' }}>
                                                Retailer</option>
                                            <option value="dealer"
                                                {{ old('customer_type', $customer_details->customer_type) == 'dealer' ? 'selected' : '' }}>
                                                Dealer</option>
                                        </select>
                                        @error('customer_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    
                                    @if ($customer_details->customer_assigned_to == Auth::user()->id || count($my_employees) > 0)
                                        <div class="form-group">
                                            <label for="customer_assigned_to">Assigned To <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('customer_assigned_to') is-invalid @enderror "
                                                name="customer_assigned_to" id="customer_assigned_to">
                                                <option value="">Choose Employee</option>
                                                <option value="{{ Auth::user()->id }}"
                                                    {{ old('customer_assigned_to', $customer_details->customer_assigned_to) == Auth::user()->id ? 'selected' : '' }}>
                                                    {{ Auth::user()->full_name }}</option>
                                                @foreach ($my_employees as $my_employee)
                                                    <option value="{{ $my_employee->id }}"
                                                        {{ old('customer_assigned_to', $customer_details->customer_assigned_to) == $my_employee->id ? 'selected' : '' }}>
                                                        {{ $my_employee->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('customer_assigned_to')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label for="customer_assigned_to">Assigned To <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('customer_assigned_to') is-invalid @enderror"
                                                name="customer_assigned_to" id="customer_assigned_to" readonly>
                                                <option value="{{ $customer_details->customer_assigned_to }}" selected>
                                                    {{ $customer_details->assigned->full_name }}</option>
                                            </select>
                                            @error('customer_assigned_to')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @endif


                                    <div class="form-group">
                                        <label for="isActive">Customer Status <span class="text-danger">*</span></label>
                                        <select class="form-control @error('isActive') is-invalid @enderror" name="isActive"
                                            id="isActive">
                                            <option value="1"
                                                {{ old('isActive', $customer_details->isActive) == 1 ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="0"
                                                {{ old('isActive', $customer_details->isActive) == 0 ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                        @error('isActive')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="customer_gst_no">Enter GST NO. <span
                                                class="text-danger">*</span>&nbsp;<small>(Enter 'NA' in case GST NO. is not provided.)</small></label>
                                        <input type="text" name="customer_gst_no"
                                            pattern="^(NA|[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1})$"
                                            title="Invalid GST NO."
                                            class="form-control @error('customer_gst_no') is-invalid @enderror"
                                            id="customer_gst_no"
                                            value="{{ old('customer_gst_no', $customer_details->customer_gst_no) }}"
                                            maxlength="100" placeholder="Enter GST NO. ">
                                        @error('customer_gst_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h2 class="mb-3">Contact Details</h2>
                                    <div class="row m-0">
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="customer_no1">Enter Customer Phone 1 <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="customer_no1"
                                                    class="form-control @error('customer_no1') is-invalid @enderror"
                                                    id="customer_no1"
                                                    value="{{ old('customer_no1', $customer_details->customer_no1) }}"
                                                    placeholder="Enter Customer Phone 1">
                                                @error('customer_no1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="customer_no2">Enter Customer Phone 2</label>
                                                <input type="number" name="customer_no2"
                                                    class="form-control @error('customer_no2') is-invalid @enderror"
                                                    id="customer_no2"
                                                    value="{{ old('customer_no2', $customer_details->customer_no2) }}"
                                                    placeholder="Enter Customer Phone 2">
                                                @error('customer_no2')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-0">
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="customer_mail">Enter customer Mail 1</label>
                                                <input type="email" name="customer_mail"
                                                    class="form-control @error('customer_mail') is-invalid @enderror"
                                                    id="customer_mail"
                                                    value="{{ old('customer_mail', $customer_details->customer_mail) }}"
                                                    maxlength="50" placeholder="Enter Customer Mail 1">
                                                @error('customer_mail')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="customer_mail2">Enter customer Mail 2</label>
                                                <input type="email" name="customer_mail2"
                                                    class="form-control @error('customer_mail2') is-invalid @enderror"
                                                    id="customer_mail2"
                                                    value="{{ old('customer_mail2', $customer_details->customer_mail2) }}"
                                                    maxlength="50" placeholder="Enter Customer mail 2">
                                                @error('customer_mail2')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-0">
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="manager_name">Enter Manager's name</label>
                                                <input type="text" name="manager_name"
                                                    class="form-control @error('manager_name') is-invalid @enderror"
                                                    id="manager_name"
                                                    value="{{ old('manager_name', $customer_details->manager_name) }}"
                                                    maxlength="30" placeholder="Enter Manager name">
                                                @error('manager_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="accountant_name">Enter Accountants name </label>
                                                <input type="text" name="accountant_name"
                                                    class="form-control @error('accountant_name') is-invalid @enderror"
                                                    id="accountant_name"
                                                    value="{{ old('accountant_name', $customer_details->accountant_name) }}"
                                                    maxlength="30" placeholder="Enter accountant name">
                                                @error('accountant_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-0">
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="manager_number">Enter Manager's contact no. </label>
                                                <input type="number" name="manager_number"
                                                    class="form-control @error('manager_number') is-invalid @enderror"
                                                    id="manager_number"
                                                    value="{{ old('manager_number', $customer_details->manager_number) }}"
                                                    maxlength="30" placeholder="Enter manager number">
                                                @error('manager_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="accountant_number">Enter Accountant's contact no. </label>
                                                <input type="text" name="accountant_number"
                                                    class="form-control @error('accountant_number') is-invalid @enderror"
                                                    id="accountant_number"
                                                    value="{{ old('accountant_number', $customer_details->accountant_number) }}"
                                                    maxlength="30" placeholder="Enter Accountant number">
                                                @error('accountant_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-0">
                                        <div class="col-md-12 px-1">

                                            <div class="form-group">
                                                <label for="customer_website">Enter Customer Website</label>
                                                <input type="text" name="customer_website"
                                                    class="form-control @error('customer_website') is-invalid @enderror"
                                                    id="customer_website"
                                                    value="{{ old('customer_website', $customer_details->customer_website) }}"
                                                    maxlength="50" placeholder="Enter Customer Website ">
                                                @error('customer_website')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="customer_notes">Enter Customer Notes</label>
                                                <textarea name="customer_notes" rows="5" class="form-control @error('customer_notes') is-invalid @enderror"
                                                    id="customer_notes" maxlength="1500" placeholder="Enter Customer Notes">{{ old('customer_notes', $customer_details->customer_notes) }}</textarea>
                                                @error('customer_notes')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-12">
                                    <h2 class="mb-3">Shipping Address</h2>
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address_line_1">Address Line 1 <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control @error('address_line_1') is-invalid @enderror"
                                            name="address_line_1" id="address_line_1"
                                            value="{{ old('address_line_1', $customer_address[0]) }}" maxlength="30"
                                            placeholder="Address Line 1">
                                        @error('address_line_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="address_line_3">Address Line 3 </label>
                                        <input class="form-control @error('address_line_3') is-invalid @enderror"
                                            name="address_line_3" id="address_line_3"
                                            value="{{ old('address_line_3', count($customer_address) > 2 ? $customer_address[2] : '') }}"
                                            maxlength="30" placeholder="Address Line 3">
                                        @error('address_line_3')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="address_line_5">Address Line 5 </label>
                                        <input class="form-control @error('address_line_5') is-invalid @enderror"
                                            name="address_line_5" id="address_line_5"
                                            value="{{ old('address_line_5', count($customer_address) > 4 ? $customer_address[4] : '') }}"
                                            maxlength="30" placeholder="Address Line 5">
                                        @error('address_line_5')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="customer_country">Enter Customer Country</label>
                                        <input type="text" name="customer_country"
                                            class="form-control @error('customer_country') is-invalid @enderror"
                                            id="customer_country"
                                            value="{{ old('customer_country', $customer_details->customer_country) }}"
                                            maxlength="30" placeholder="Enter Customer Country">
                                        @error('customer_country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="customer_district">Enter Customer District <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="customer_district"
                                            class="form-control @error('customer_district') is-invalid @enderror"
                                            id="customer_district"
                                            value="{{ old('customer_district', $customer_details->customer_district) }}"
                                            maxlength="30" placeholder="Enter Customer District">
                                        @error('customer_district')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="customer_pin_code">Enter Customer Pin Code <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="customer_pin_code"
                                            class="form-control @error('customer_pin_code') is-invalid @enderror"
                                            id="customer_pin_code"
                                            value="{{ old('customer_pin_code', $customer_details->customer_pin_code) }}"
                                            maxlength="30" placeholder="Enter Customer pin_code">
                                        @error('customer_pin_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="address_line_2">Address Line 2 <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control @error('address_line_2') is-invalid @enderror"
                                            name="address_line_2" id="address_line_2"
                                            value="{{ old('address_line_2', $customer_address[1]) }}" maxlength="30"
                                            placeholder="Address Line 2">
                                        @error('address_line_2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="address_line_4">Address Line 4 </label>
                                        <input class="form-control @error('address_line_4') is-invalid @enderror"
                                            name="address_line_4" id="address_line_4"
                                            value="{{ old('address_line_4', count($customer_address) > 3 ? $customer_address[3] : '') }}"
                                            maxlength="30" placeholder="Address Line 4">
                                        @error('address_line_4')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="address_line_6">Address Line 6 </label>
                                        <input class="form-control @error('address_line_6') is-invalid @enderror"
                                            name="address_line_6" id="address_line_6"
                                            value="{{ old('address_line_6', count($customer_address) > 5 ? $customer_address[5] : '') }}"
                                            maxlength="30" placeholder="Address Line 6">
                                        @error('address_line_6')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="customer_state">State <span class="text-danger">*</span></label>
                                        <select class="form-control @error('customer_state') is-invalid @enderror"
                                            name="customer_state" id="customer_state">
                                            <option value="">Choose State</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->state_id }}"
                                                    {{ old('customer_state', $customer_details->customer_state) == $state->state_id ? 'selected' : '' }}>
                                                    {{ $state->state_title }} - {{ sprintf('%02d', $state->state_code) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('customer_state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="customer_taluka">Enter Customer Taluka <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="customer_taluka"
                                            class="form-control @error('customer_taluka') is-invalid @enderror"
                                            id="customer_taluka"
                                            value="{{ old('customer_taluka', $customer_details->customer_taluka) }}"
                                            maxlength="30" placeholder="Enter Customer Taluka">
                                        @error('customer_taluka')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-12">
                                    <h2 class="mb-3">Office Address</h2>
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="o_address_line_1">Address Line 1 </label>
                                        <input class="form-control @error('o_address_line_1') is-invalid @enderror"
                                            name="o_address_line_1" id="o_address_line_1"
                                            value="{{ old('o_address_line_1', $office_address[0]) }}" maxlength="30"
                                            placeholder="Address Line 1">
                                        @error('o_address_line_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="o_address_line_3">Address Line 3 </label>
                                        <input class="form-control @error('o_address_line_3') is-invalid @enderror"
                                            name="o_address_line_3" id="o_address_line_3"
                                            value="{{ old('o_address_line_3', count($office_address) > 2 ? $office_address[2] : '') }}"
                                            maxlength="30" placeholder="Address Line 3">
                                        @error('o_address_line_3')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="o_address_line_5">Address Line 5 </label>
                                        <input class="form-control @error('o_address_line_5') is-invalid @enderror"
                                            name="o_address_line_5" id="o_address_line_5"
                                            value="{{ old('o_address_line_5', count($office_address) > 4 ? $office_address[4] : '') }}"
                                            maxlength="30" placeholder="Address Line 5">
                                        @error('o_address_line_5')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="office_country">Enter Office's Country</label>
                                        <input type="text" name="office_country"
                                            class="form-control @error('office_country') is-invalid @enderror"
                                            id="office_country"
                                            value="{{ old('office_country', $customer_details->office_country) }}"
                                            maxlength="30" placeholder="Enter Office Country">
                                        @error('office_country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="office_district">Enter Office's District</label>
                                        <input type="text" name="office_district"
                                            class="form-control @error('office_district') is-invalid @enderror"
                                            id="office_district"
                                            value="{{ old('office_district', $customer_details->office_district) }}"
                                            maxlength="30" placeholder="Enter Office District">
                                        @error('office_district')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="office_pin_code">Enter Office's Pin Code </label>
                                        <input type="number" name="office_pin_code"
                                            class="form-control @error('office_pin_code') is-invalid @enderror"
                                            id="office_pin_code"
                                            value="{{ old('office_pin_code', $customer_details->office_pin_code) }}"
                                            maxlength="30" placeholder="Enter Office pin_code">
                                        @error('office_pin_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="o_address_line_2">Address Line 2 </label>
                                        <input class="form-control @error('o_address_line_2') is-invalid @enderror"
                                            name="o_address_line_2" id="o_address_line_2"
                                            value="{{ old('o_address_line_2', $office_address[1]) }}" maxlength="30"
                                            placeholder="Address Line 2">
                                        @error('o_address_line_2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="o_address_line_4">Address Line 4 </label>
                                        <input class="form-control @error('o_address_line_4') is-invalid @enderror"
                                            name="o_address_line_4" id="o_address_line_4"
                                            value="{{ old('o_address_line_4', count($office_address) > 3 ? $office_address[3] : '') }}"
                                            maxlength="30" placeholder="Address Line 4">
                                        @error('o_address_line_4')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="o_address_line_6">Address Line 6 </label>
                                        <input class="form-control @error('o_address_line_6') is-invalid @enderror"
                                            name="o_address_line_6" id="o_address_line_6"
                                            value="{{ old('o_address_line_6', count($office_address) > 5 ? $office_address[5] : '') }}"
                                            maxlength="30" placeholder="Address Line 6">
                                        @error('o_address_line_6')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="office_state">State </label>
                                        <select class="form-control @error('office_state') is-invalid @enderror"
                                            name="office_state" id="office_state">
                                            <option value="">Choose State</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->state_id }}"
                                                    {{ old('office_state', $customer_details->office_state) == $state->state_id ? 'selected' : '' }}>
                                                    {{ $state->state_title }} - {{ sprintf('%02d', $state->state_code) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('office_state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="office_taluka">Enter Office Taluka </label>
                                        <input type="text" name="office_taluka"
                                            class="form-control @error('office_taluka') is-invalid @enderror"
                                            id="office_taluka"
                                            value="{{ old('office_taluka', $customer_details->office_taluka) }}"
                                            maxlength="30" placeholder="Enter Office's Taluka">
                                        @error('office_taluka')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="card-footer border-0">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
