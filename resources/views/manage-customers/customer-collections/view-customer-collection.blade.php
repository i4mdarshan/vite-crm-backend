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
                    <h1 class="mb-0">Customer Collection Details</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="m-1 mt-3 mb-5">
                                <div class="row">
                                    <div class="col-md-6 mt-2">
                                        <div class="text-secondary border bg-secondary my-2">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Collected By Person Name</span>
                                                <h3 class="m-0 p-0"><b>{{ ($collection_details->collected_by_person_name) }}</b></h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary my-2">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Money Recieved</span>
                                                <h3 class="m-0 p-0"><b>Rs. {{ number_format($collection_details->money_received) }} /-</b></h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary my-2">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Money Pending</span>
                                                <h3 class="m-0 p-0">
                                                    <b>Rs. {{ number_format($collection_details->money_pending) }} /-</b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary my-2">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Collection Status</span>
                                                <h3 class="m-0 p-0">
                                                    @if ($collection_details->status == "received")
                                                        <span class="badge badge-pill badge-lg badge-success">Recieved</span>
                                                    @else
                                                        <span class="badge badge-pill badge-lg badge-danger">Pending</span>
                                                    @endif
                                                </h3>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="text-secondary border bg-secondary my-2">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Collected From Person Name</span>
                                                <h3 class="m-0 p-0"><b>{{ ucwords($collection_details->raised_by->contact_person_name) }}</b></h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary my-2">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Money Received Date</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ($collection_details->money_received_date) ? date('jS F, Y',strtotime($collection_details->money_received_date)) : "NA" }} </b>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-secondary border bg-secondary my-2">
                                            <div class="p-2">
                                                <span class="h5 mb-0">Money Pending Date</span>
                                                <h3 class="m-0 p-0">
                                                    <b>{{ ($collection_details->money_pending_date) ? date('jS F, Y',strtotime($collection_details->money_pending_date)) : "NA" }} </b>
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
