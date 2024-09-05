@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')

<div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="m-1">
                <a href="{{ route('manage_customers') }}" class="btn btn-primary px-3">
                    <span class="text-secondary h3"><i class="ni ni-bold-left mr-2" style="font-size: 14px; vertical-align: middle;"></i>Manage Customers</span>
                </a>
            </div>
        </div>
    </div>
    
    @include('layouts.partials.customer-nav-menu')

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                {{-- <h1 class="m-3">Page Under Construction</h1> --}}
                <div class="d-flex justify-content-between card-header">
                    <h1 class="mb-0">Customer Profile Details</h1>
                    <div>
                        @if ($module_access[0] == 1)
                            <a href="{{ route('edit_customers',$customer_details->id) }}" class="btn btn-secondary float-right mx-1 my-2 my-md-0">
                                <span class="p" style="font-size: 15px;">Edit</span>
                                <i class="fas fa-pencil-ruler"></i>
                            </a>
                        @endif

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 border-right">
                            <div class="text-center m-3">
                                <img class="rounded-circle-image img-fluid"
                                    src="{{ asset('uploads/users/default_user.png') }}" height="250px">
                                <h2 class="mt-3"><strong>{{ $customer_details->customer_name }}</strong></h2>
                                <span class="badge badge-pill badge-lg {{ ($customer_details->isActive) ? "badge-success" : "badge-danger"}}"> {{ ($customer_details->isActive) ? "Active" : "Inactive" }}</span>
                            </div>
                            <div class="mt-5 m-2">
                                <h5>Added By : </h5>
                                <h4><strong>{{ $customer_details->employee->full_name }}</strong></h4>
                                <h5>Assigned To : </h5>
                                <h4><strong>{{ $customer_details->assigned->full_name }}</strong></h4>
                                <h5>Added On : </h5>
                                <h4><strong>{{ date('d M Y h:iA',strtotime($customer_details->created)) }}</strong></h4>
                                <h5>Converted On : </h5>
                                <h4><strong>{{ ($customer_details->lead_convert_date) ? date('d M Y h:iA',strtotime($customer_details->lead_convert_date)) : "Added as Customer" }}</strong></h4>
                                <h5>Website : </h5>
                                <h4><strong>
                                    @if ($customer_details->customer_website)
                                        <a href="{{ $customer_details->customer_website }}" target="_blank" rel="noopener noreferrer">{{ $customer_details->customer_website }}</a>
                                    @else
                                        NA
                                    @endif
                                </strong></h4>
                                <h5>Under Firm : </h5>
                                <h4><strong>{{ $customer_details->firm->firm_name }}</strong></h4>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="m-1 mt-3 mb-5">
                                <h2 class="mb-3"><strong>Customer Details</strong></h2>
                                <div class="row">
                                    <div class="col-md-6 mt-2">
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Customer Firm Name</span>
                                                <h3 class="m-0 p-0"><b>{{ ucwords($customer_details->customer_name) }}</b></h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Customer Phone No. 1</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ($customer_details->customer_no1) ? $customer_details->customer_no1 : 'NA' }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Primary Mail</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ $customer_details->customer_mail }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Manager name</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ isset($customer_details->manager_name) ? $customer_details->manager_name : "NA" }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Manager Contact no.</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ isset($customer_details->manager_number) ? $customer_details->manager_number : "NA" }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Country</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ($customer_details->customer_country) ? ucwords($customer_details->customer_country) : "NA" }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">District</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ucwords($customer_details->customer_district) }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Notes</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ($customer_details->customer_notes) ? $customer_details->customer_notes : "NA" }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Address</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{!! str_replace('__',', ',$customer_details->customer_address); !!}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Office Address</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{!! isset($customer_details->office_address) ? str_replace('__',', ',$customer_details->office_address) : "NA" !!}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Office State</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ isset($customer_details->state_office) ? ucwords($customer_details->state_office->state_title) : "NA" }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Office Taluka</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ isset($customer_details->office_taluka) ? ucwords($customer_details->office_taluka) : "NA" }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">GST NO.</span>
                                                <h3 class="m-0 p-0"><b>{{ isset($customer_details->customer_gst_no) ? ucwords($customer_details->customer_gst_no) : "NA" }}</b></h3>
                                            </div>
                                        </div>

                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Customer Owner Name</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ($customer_details->customer_owner_name) ? $customer_details->customer_owner_name : "NA" }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Type</span>
                                                <h3 class="m-0 p-0"><b>{{ ucwords($customer_details->customer_type) }}</b></h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Customer Phone No. 2</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ($customer_details->customer_no2) ? $customer_details->customer_no2 : 'NA' }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Other Mail</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ($customer_details->customer_mail2) ? $customer_details->customer_mail2 : 'NA' }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Accountant name</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ isset($customer_details->accountant_name) ? $customer_details->accountant_name : "NA" }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Accountant contact no.</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ isset($customer_details->accountant_number) ? $customer_details->accountant_number : "NA" }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">State</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ucwords($customer_details->state->state_title) }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Taluka</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ucwords($customer_details->customer_taluka) }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Pin Code</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ucwords($customer_details->customer_pin_code) }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Ofiice District</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ isset($customer_details->office_district) ? ucwords($customer_details->office_district) : "NA" }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Office Pin Code</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ isset($customer_details->office_pin_code) ? ucwords($customer_details->office_pin_code) : "NA" }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary mb-3">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Office Country</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ($customer_details->office_country) ? ucwords($customer_details->office_country) : "NA" }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
