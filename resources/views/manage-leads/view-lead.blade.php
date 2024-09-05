@extends('layouts.app')

@section('title', 'Manage Leads')

@section('content')

    {{-- @dd(request()->is('manage_leads/view/profile*')) --}}
    <div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ route('manage_leads') }}" class="btn btn-primary px-3">
                        <span class="text-secondary h3"><i class="ni ni-bold-left mr-2"
                                style="font-size: 14px; vertical-align: middle;"></i>Manage Leads</span>
                    </a>
                </div>
            </div>
        </div>

        @include('layouts.partials.lead-nav-menu')

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    {{-- <h1 class="m-3">Page Under Construction</h1> --}}
                    <div class="d-flex justify-content-between card-header">
                        <h1 class="mb-0">Lead Profile Details</h1>
                        <div>
                            @if ($module_access[0] == 1)
                                <a href="{{ route('edit_leads', $lead_details->id) }}"
                                    class="btn btn-secondary float-right mx-1 my-2 my-md-0">
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
                                    <h2 class="mt-3"><strong>{{ $lead_details->customer_name }}</strong></h2>
                                    <span
                                        class="badge badge-pill badge-lg {{ $lead_details->isActive ? 'badge-success' : 'badge-danger' }}">
                                        {{ $lead_details->isActive ? 'Active' : 'Inactive' }}</span>
                                </div>
                                <div class="mt-5 m-2">
                                    <h5>Added By : </h5>
                                    <h4><strong>{{ $lead_details->employee->full_name }}</strong></h4>
                                    <h5>Assigned To : </h5>
                                    <h4><strong>{{ $lead_details->assigned->full_name }}</strong></h4>
                                    <h5>Added On : </h5>
                                    <h4><strong>{{ date('d M Y h:iA', strtotime($lead_details->created)) }}</strong></h4>
                                    <h5>Website : </h5>
                                    <h4><strong>
                                            @if ($lead_details->customer_website)
                                                <a href="{{ $lead_details->customer_website }}" target="_blank"
                                                    rel="noopener noreferrer">{{ $lead_details->customer_website }}</a>
                                            @else
                                                NA
                                            @endif
                                        </strong></h4>
                                    <h5>Under Firm : </h5>
                                    <h4><strong>{{ $lead_details->firm->firm_name }}</strong></h4>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="m-1 mt-3 mb-5">
                                    <h2 class="mb-3"><strong>Lead Details</strong></h2>
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Lead Firm Name</span>
                                                    <h3 class="m-0 p-0"><b>{{ ucwords($lead_details->customer_name) }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Lead Phone No. 1</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $lead_details->customer_no1 ? $lead_details->customer_no1 : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Primary Mail</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ isset($lead_details->customer_mail) ? $lead_details->customer_mail : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Manager name</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ isset($lead_details->manager_name) ? $lead_details->manager_name : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Manager Contact no.</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ isset($lead_details->manager_number) ? $lead_details->manager_number : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">State</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ ucwords($lead_details->state->state_title) }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Taluka</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ ucwords($lead_details->customer_taluka) }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Address</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{!! str_replace('__', ', ', $lead_details->customer_address) !!}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Office Address</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{!! isset($lead_details->office_address) ? str_replace('__', ', ', $lead_details->office_address) : 'NA' !!}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Office State</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ isset($lead_details->state_office) ? ucwords($lead_details->state_office->state_title) : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Office Taluka</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ isset($lead_details->office_taluka) ? ucwords($lead_details->office_taluka) : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">GST NO.</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ isset($lead_details->customer_gst_no) ? ucwords($lead_details->customer_gst_no) : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Owner Name</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ ucwords($lead_details->customer_owner_name) }}</b></h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Type</span>
                                                    <h3 class="m-0 p-0"><b>{{ ucwords($lead_details->customer_type) }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Lead Phone No. 2</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $lead_details->customer_no2 ? $lead_details->customer_no2 : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Other Mail</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $lead_details->customer_mail2 ? $lead_details->customer_mail2 : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Accountant name</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ isset($lead_details->accountant_name) ? $lead_details->accountant_name : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Accountant contact no.</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ isset($lead_details->accountant_number) ? $lead_details->accountant_number : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">District</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ isset($lead_details->customer_district) ? ucwords($lead_details->customer_district) : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Pin Code</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ isset($lead_details->customer_pin_code) ? ucwords($lead_details->customer_pin_code) : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Ofiice District</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ isset($lead_details->office_district) ? ucwords($lead_details->office_district) : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Office Pin Code</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ isset($lead_details->office_pin_code) ? ucwords($lead_details->office_pin_code) : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="text-secondary border bg-secondary mb-3">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Office Country</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $lead_details->office_country ? ucwords($lead_details->office_country) : 'NA' }}</b>
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

@section('custom_scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.lead-menu').slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });
        });
    </script>

@endsection
