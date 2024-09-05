@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')

<div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="m-1">
                <a href="{{ url()->previous() }}" class="btn btn-primary px-3">
                    <span class="text-secondary h3"><i class="ni ni-bold-left mr-2" style="font-size: 14px; vertical-align: middle;"></i>Back</span>
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
                    <h1 class="mb-0">Customer Contact Details</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 border-right">
                            <div class="text-center m-3">
                                
                                @if ($contact_details->contact_person_image)
                                    <img class="rounded-circle-image img-fluid"
                                    src="{{ asset('uploads/customers/contact-person-images/'.$contact_details->contact_person_image) }}" height="250px">
                                @else
                                    <img class="rounded-circle-image img-fluid"
                                    src="{{ asset('uploads/users/default_user.png') }}" height="250px">
                                @endif
                                <h2 class="mt-3"><strong>{{ $contact_details->contact_person_name }}</strong></h2>
                                @if ($contact_details->isActive == 1)
                                    <span class="badge badge-pill badge-lg badge-success">Active</span>
                                @else
                                    <span class="badge badge-pill badge-lg badge-danger">Inactive</span>
                                @endif
                            </div>
                            <div class="mt-5 m-2">
                                {{-- <h4><strong>Added By : </strong>{{ $contact_details->employee->full_name }}</h4> --}}
                                <h4><strong>Added On : </strong>{{ date("jS F, Y",strtotime($contact_details->created)) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="m-1 mt-3 mb-5">
                                <h2 class="mb-3"><strong>Details</strong></h2>
                                <div class="row">
                                    <div class="col-md-6 mt-2">
                                        <div class="text-secondary border bg-secondary">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Name</span>
                                                <h3 class="m-0 p-0"><b>{{ ucwords($contact_details->contact_person_name) }}</b></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="text-secondary border bg-secondary">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Designation</span>
                                                <h3 class="m-0 p-0"><b>{{ ucwords($contact_details->contact_designation) }}</b></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-6 mt-2">
                                        <div class="text-secondary border bg-secondary">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Contact No.</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ($contact_details->contact_number) ? $contact_details->contact_number : 'NA' }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="text-secondary border bg-secondary">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Email</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ($contact_details->contact_email) ? $contact_details->contact_email : 'NA' }}</b>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-12 mt-2">
                                        <div class="text-secondary border bg-secondary">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Notes</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ($contact_details->contact_notes) ? $contact_details->contact_notes : 'NA' }}</b>
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
        $(document).ready(function(){
            $('.customer-menu').slick({
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
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
