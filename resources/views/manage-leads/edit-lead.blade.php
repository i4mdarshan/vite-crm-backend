@extends('layouts.app')

@section('title', 'Manage Leads')

@section('content')
    <div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ route('manage_leads') }}" class="btn btn-primary px-3">
                        <span class="text-secondary h3"><i class="ni ni-bold-left mr-2" style="font-size: 14px; vertical-align: middle;"></i>Manage Leads</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <h1 class="mb-0">Edit Lead</h1>
                        @if ($errors->has('message'))
                            <span class="text-danger"></span>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $errors->first('message'); }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                        @endif
                    </div>
                    <form action="{{ route('update_leads',$lead_details->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="m-3">

                            <div class="row mx-0">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lead_name">Enter Lead Name <span class="text-danger">*</span></label>
                                        <input type="text" name="lead_name"
                                            class="form-control @error('lead_name') is-invalid @enderror" id="lead_name"
                                            value="{{ old("lead_name",$lead_details->customer_name) }}"  maxlength="255" placeholder="Enter Lead Name">
                                        @error('lead_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="lead_type">Lead Type <span class="text-danger">*</span></label>
                                        <select class="form-control @error('lead_type') is-invalid @enderror"
                                            name="lead_type" id="lead_type">
                                            <option value="">Choose Type</option>
                                            <option value="manufacturer" {{ old("lead_type",$lead_details->customer_type) == "manufacturer" ? 'selected' : '' }}>Manufacturer</option>
                                            <option value="distributor" {{ old("lead_type",$lead_details->customer_type) == "distributor" ? 'selected' : '' }}>Distributor</option>
                                            <option value="retailer" {{ old("lead_type",$lead_details->customer_type) == "retailer" ? 'selected' : '' }}>Retailer</option>
                                            <option value="dealer" {{ old("lead_type",$lead_details->customer_type) == "dealer" ? 'selected' : '' }}>Dealer</option>
                                        </select>
                                        @error('lead_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    @if ($lead_details->customer_assigned_to == Auth::user()->id || count($my_employees) > 0 )
                                        <div class="form-group">
                                            <label for="lead_assigned_to">Assigned To <span class="text-danger">*</span></label>
                                            <select class="form-control @error('lead_assigned_to') is-invalid @enderror " name="lead_assigned_to"
                                                id="lead_assigned_to">
                                                <option value="">Choose Employee</option>
                                                <option value="{{ Auth::user()->id }}" {{ (old("lead_assigned_to",$lead_details->customer_assigned_to) == Auth::user()->id) ? "selected" : "" }} >{{ Auth::user()->full_name }}</option>
                                                @foreach ($my_employees as $my_employee)
                                                    <option value="{{ $my_employee->id }}" {{ (old("lead_assigned_to",$lead_details->customer_assigned_to) == $my_employee->id) ? "selected" : "" }} >{{ $my_employee->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('lead_assigned_to')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label for="lead_assigned_to">Assigned To <span class="text-danger">*</span></label>
                                            <select class="form-control @error('lead_assigned_to') is-invalid @enderror" name="lead_assigned_to"
                                                id="lead_assigned_to" readonly>
                                                <option value="{{ $lead_details->customer_assigned_to }}" selected>{{ $lead_details->assigned->full_name }}</option>
                                            </select>
                                            @error('lead_assigned_to')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="lead_gst_no">Enter GST NO. <span class="text-danger">*</span>&nbsp;<small>(Enter 'NA' in case GST NO. is not provided.)</small></label>
                                        <input type="text" name="lead_gst_no" pattern="^(NA|[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1})$"
                                            title="Invalid GST NO." class="form-control @error('lead_gst_no') is-invalid @enderror" id="lead_gst_no"
                                            value="{{ old('lead_gst_no', $lead_details->customer_gst_no) }}" maxlength="100" placeholder="Enter GST NO. ">
                                        @error('lead_gst_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lead_owner_name">Enter Lead Owner Name <span class="text-danger">*</span></label>
                                        <input type="text" name="lead_owner_name"
                                            class="form-control @error('lead_owner_name') is-invalid @enderror" id="lead_owner_name"
                                            value="{{ old("lead_owner_name",$lead_details->customer_owner_name) }}"  maxlength="255" placeholder="Enter Lead Owner Name">
                                        @error('lead_owner_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="lead_web">Enter Lead Website</label>
                                        <input type="text" name="lead_web"
                                            class="form-control @error('lead_web') is-invalid @enderror" id="lead_web"
                                            value="{{ old('lead_web',$lead_details->customer_website) }}"  maxlength="100" placeholder="Enter Lead Website ">
                                        @error('lead_web')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="lead_status">Lead Status <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control @error('lead_status') is-invalid @enderror"
                                            name="lead_status" id="lead_status">
                                            <option value="1" {{ old("lead_status",$lead_details->isActive) == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old("lead_status",$lead_details->isActive) == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('lead_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mx-0">
                                <div class="col-md-12">
                                    <h2 class="mb-3">Contact Details</h2>
                                </div>
                            </div>

                            <div class="row mx-0">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lead_no_1">Enter Lead Phone 1 <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="lead_no_1"
                                            class="form-control @error('lead_no_1') is-invalid @enderror"
                                            id="lead_no_1" value="{{ old("lead_no_1",$lead_details->customer_no1) }}"
                                            placeholder="Enter Lead Phone 1">
                                        @error('lead_no_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="lead_no_2">Enter Lead Phone 2</label>
                                        <input type="number" name="lead_no_2"
                                            class="form-control @error('lead_no_2') is-invalid @enderror"
                                            id="lead_no_2" value="{{ old("lead_no_2",$lead_details->customer_no2) }}"
                                            placeholder="Enter Lead Phone 2">
                                        @error('lead_no_2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lead_mail_1">Enter Lead Mail 1 </label>
                                        <input type="email" name="lead_mail_1"
                                            class="form-control @error('lead_mail_1') is-invalid @enderror"
                                            id="lead_mail_1" value="{{ old("lead_mail_1",$lead_details->customer_mail) }}"  maxlength="50"
                                            placeholder="Enter Lead Mail 1">
                                        @error('lead_mail_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="lead_mail_2">Enter Lead Mail 2</label>
                                        <input type="email" name="lead_mail_2"
                                            class="form-control @error('lead_mail_2') is-invalid @enderror"
                                            id="lead_mail_2" value="{{ old("lead_mail_2",$lead_details->customer_mail2) }}"  maxlength="50"
                                            placeholder="Enter Lead Mail 2">
                                        @error('lead_mail_2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row m-0">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lead_manager_name">Enter Manager's name </label>
                                        <input type="text" name="lead_manager_name"
                                            class="form-control @error('lead_manager_name') is-invalid @enderror"
                                            id="lead_manager_name" value="{{  old("lead_manager_name",$lead_details->manager_name) }}" maxlength="30"
                                            placeholder="Enter Manager name">
                                        @error('lead_manager_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lead_accountant_name">Enter Accountants name </label>
                                        <input type="text" name="lead_accountant_name"
                                            class="form-control @error('lead_accountant_name') is-invalid @enderror"
                                            id="lead_accountant_name" value="{{  old("lead_accountant_name",$lead_details->accountant_name) }}" maxlength="30"
                                            placeholder="Enter accountant name">
                                        @error('lead_accountant_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row m-0">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lead_manager_number">Enter Manager's contact no. </label>
                                        <input type="number" name="lead_manager_number"
                                            class="form-control @error('lead_manager_number') is-invalid @enderror"
                                            id="lead_manager_number" value="{{  old("lead_manager_number",$lead_details->manager_number) }}" maxlength="30"
                                            placeholder="Enter manager number">
                                        @error('lead_manager_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lead_accountant_number">Enter Accountant's contact no. </label>
                                        <input type="text" name="lead_accountant_number"
                                            class="form-control @error('lead_accountant_number') is-invalid @enderror"
                                            id="lead_accountant_number" value="{{  old("lead_accountant_number",$lead_details->accountant_number) }}" maxlength="30"
                                            placeholder="Enter Accountant number">
                                        @error('lead_accountant_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row mx-0">
                                <div class="col-md-12">
                                    <h2 class="mb-3">Shipping Details</h2>
                                </div>
                            </div>

                            <div class="row mx-0">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address_line_1">Address Line 1 <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control @error('address_line_1') is-invalid @enderror"
                                            name="address_line_1" value="{{ old("address_line_1",$lead_address[0]) }}" id="address_line_1"  maxlength="30" placeholder="Address Line 1">
                                        @error('address_line_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="address_line_3">Address Line 3</label>
                                        <input class="form-control @error('address_line_3') is-invalid @enderror"
                                            name="address_line_3" value="{{ old("address_line_3",count($lead_address) > 2 ? $lead_address[2] : "") }}" id="address_line_3" maxlength="30" placeholder="Address Line 3">
                                        @error('address_line_3')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="address_line_5">Address Line 5</label>
                                        <input class="form-control @error('address_line_5') is-invalid @enderror"
                                            name="address_line_5" value="{{ old("address_line_5",count($lead_address) > 4 ? $lead_address[4] : "") }}" id="address_line_5" maxlength="30" placeholder="Address Line 5">
                                        @error('address_line_5')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="lead_state">State <span class="text-danger">*</span></label>
                                        <select class="form-control @error('lead_state') is-invalid @enderror" name="lead_state" id="lead_state">
                                                <option value="">Choose State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->state_id }}" {{ (old("lead_state",$lead_details->customer_state) == $state->state_id) ? "selected" : '' }}> {{ $state->state_title }} - {{ sprintf("%02d",$state->state_code) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('lead_state')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="lead_taluka">Enter Lead Taluka <span class="text-danger">*</span></label>
                                        <input type="text" name="lead_taluka"
                                            class="form-control @error('lead_taluka') is-invalid @enderror"
                                            id="lead_taluka" value="{{ old("lead_taluka",$lead_details->customer_taluka) }}" maxlength="30"
                                            placeholder="Enter Lead Taluka">
                                        @error('lead_taluka')
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
                                            name="address_line_2" value="{{ old("address_line_2",$lead_address[1]) }}" id="address_line_2" maxlength="30" placeholder="Address Line 2">
                                        @error('address_line_2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="address_line_4">Address Line 4</label>
                                        <input class="form-control @error('address_line_4') is-invalid @enderror"
                                            name="address_line_4" value="{{ old("address_line_2",count($lead_address) > 3 ? $lead_address[3] : "") }}" id="address_line_4" maxlength="30" placeholder="Address Line 4">
                                        @error('address_line_4')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="address_line_6">Address Line 6</label>
                                        <input class="form-control @error('address_line_6') is-invalid @enderror"
                                            name="address_line_6" value="{{ old("address_line_6",count($lead_address) > 5 ? $lead_address[5] : "") }}" id="address_line_6" maxlength="30" placeholder="Address Line 6">
                                        @error('address_line_6')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="lead_district">Enter Lead District <span class="text-danger">*</span></label>
                                        <input type="text" name="lead_district"
                                            class="form-control @error('lead_district') is-invalid @enderror"
                                            id="lead_district" value="{{ old("lead_district",$lead_details->customer_district) }}" maxlength="30"
                                            placeholder="Enter Lead District">
                                        @error('lead_district')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="lead_pin_code">Enter Pin Code <span class="text-danger">*</span></label>
                                        <input type="number" name="lead_pin_code"
                                            class="form-control @error('lead_pin_code') is-invalid @enderror"
                                            id="lead_pin_code" value="{{ old("lead_pin_code",$lead_details->customer_pin_code) }}" maxlength="30"
                                            placeholder="Enter Pin Code">
                                        @error('lead_pin_code')
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
                                            name="o_address_line_1" id="o_address_line_1"  value="{{ old("o_address_line_1",$office_address[0]) }}" maxlength="30" placeholder="Address Line 1">
                                        @error('o_address_line_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="o_address_line_3">Address Line 3 </label>
                                        <input class="form-control @error('o_address_line_3') is-invalid @enderror"
                                            name="o_address_line_3" id="o_address_line_3"  value="{{ old("o_address_line_3",count($office_address) > 2 ? $office_address[2] : "") }}" maxlength="30" placeholder="Address Line 3">
                                        @error('o_address_line_3')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="o_address_line_5">Address Line 5 </label>
                                        <input class="form-control @error('o_address_line_5') is-invalid @enderror"
                                            name="o_address_line_5" id="o_address_line_5"  value="{{ old("o_address_line_5",count($office_address) > 4 ? $office_address[4] : "") }}" maxlength="30" placeholder="Address Line 5">
                                        @error('o_address_line_5')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="lead_office_country">Enter Office's Country</label>
                                        <input type="text" name="lead_office_country"
                                            class="form-control @error('lead_office_country') is-invalid @enderror"
                                            id="lead_office_country" value="{{  old("lead_office_country",$lead_details->lead_office_country) }}" maxlength="30"
                                            placeholder="Enter Office Country">
                                        @error('lead_office_country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="lead_office_district">Enter Office's District </label>
                                        <input type="text" name="lead_office_district"
                                            class="form-control @error('lead_office_district') is-invalid @enderror"
                                            id="lead_office_district" value="{{ old("lead_office_district",$lead_details->lead_office_district) }}" maxlength="30"
                                            placeholder="Enter Office District">
                                        @error('lead_office_district')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="lead_office_pin_code">Enter Office's Pin Code </label>
                                        <input type="number" name="lead_office_pin_code"
                                            class="form-control @error('lead_office_pin_code') is-invalid @enderror"
                                            id="lead_office_pin_code" value="{{ old("lead_office_pin_code",$lead_details->lead_office_pin_code) }}" maxlength="30"
                                            placeholder="Enter Office Pin Code">
                                        @error('lead_office_pin_code')
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
                                            name="o_address_line_2" id="o_address_line_2"  value="{{ old("o_address_line_2",$office_address[1]) }}" maxlength="30" placeholder="Address Line 2">
                                        @error('o_address_line_2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="o_address_line_4">Address Line 4 </label>
                                        <input class="form-control @error('o_address_line_4') is-invalid @enderror"
                                            name="o_address_line_4" id="o_address_line_4"  value="{{ old("o_address_line_4",count($office_address) > 3 ? $office_address[3] : "") }}" maxlength="30" placeholder="Address Line 4">
                                        @error('o_address_line_4')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="o_address_line_6">Address Line 6 </label>
                                        <input class="form-control @error('o_address_line_6') is-invalid @enderror"
                                            name="o_address_line_6" id="o_address_line_6" value="{{ old("o_address_line_6",count($office_address) > 5 ? $office_address[5] : "") }}" maxlength="30" placeholder="Address Line 6">
                                        @error('o_address_line_6')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="lead_office_state">State </label>
                                        <select class="form-control @error('lead_office_state') is-invalid @enderror" name="lead_office_state" id="lead_office_state">
                                                <option value="">Choose State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->state_id }}" {{ (old("lead_office_state",$lead_details->office_state) == $state->state_id) ? "selected" : '' }} >{{ $state->state_title }} - {{ sprintf("%02d",$state->state_code) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('lead_office_state')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="lead_office_taluka">Enter Office Taluka </label>
                                        <input type="text" name="lead_office_taluka"
                                            class="form-control @error('lead_office_taluka') is-invalid @enderror"
                                            id="lead_office_taluka" value="{{ old("lead_office_taluka",$lead_details->lead_office_taluka) }}" maxlength="30"
                                            placeholder="Enter Office Taluka">
                                        @error('lead_office_taluka')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

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
