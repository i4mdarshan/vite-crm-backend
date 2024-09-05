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

        @include('layouts.partials.customer-nav-menu')

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    {{-- <h1 class="m-3">Page Under Construction</h1> --}}
                    <div class="d-flex justify-content-between card-header">
                        <h1 class="mb-0">Behaviour Details</h1>
                        <div>
                            {{-- @dd($behaviour_details) --}}
                            @if ($module_access[0] == 1)

                                @if (!is_null($behaviour_details))
                                    <a href="{{ route('editBehaviours_customers', $behaviour_details->customer_id) }}"
                                        class="btn btn-secondary float-right mx-1 my-2 my-md-0">
                                        <span class="p" style="font-size: 15px;">Edit</span>
                                        <i class="fas fa-pencil-ruler"></i>
                                    </a>
                                @else
                                    <a href="{{ route('editBehaviours_customers', $customer_id) }}"
                                        class="btn btn-secondary float-right mx-1 my-2 my-md-0">
                                        <span class="p" style="font-size: 15px;">Edit</span>
                                        <i class="fas fa-pencil-ruler"></i>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                    @if (is_null($behaviour_details))
                        <h4 class="m-4 text-muted">Please add customer behaviour using Edit button.</h4>
                    @else
                        <div class="row">
                            <div class="col-md-12">
                                <div class="m-1 mt-3 mb-5">
                                    <h2 class="mb-3 ml-2"><strong>Basic Details</strong></h2>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Nature of client</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ ucwords($behaviour_details->nature ? $behaviour_details->nature : 'NA') }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Is client a price cross checker?</span>
                                                    <h3 class="m-0 p-0">
                                                        @if ($behaviour_details->price_cross_checker == 'yes')
                                                            <b>Yes</b>
                                                        @else
                                                            @if ($behaviour_details->price_cross_checker == 'no')
                                                                <b>No</b>
                                                            @else
                                                                <b>NA</b>
                                                            @endif
                                                        @endif
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Is client friendly to provide market and
                                                        compitator information</span>
                                                    <h3 class="m-0 p-0">
                                                        @if ($behaviour_details->friendly == 'yes')
                                                            <b>Yes</b>
                                                        @else
                                                            @if ($behaviour_details->friendly == 'no')
                                                                <b>No</b>
                                                            @else
                                                                <b>NA</b>
                                                            @endif
                                                        @endif
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Any special condition or soft corner for
                                                        the client</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ ucwords($behaviour_details->soft_corner ? $behaviour_details->soft_corner : 'NA') }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Is the client very technical and helping in
                                                        nature</span>
                                                    <h3 class="m-0 p-0">
                                                        @if ($behaviour_details->technical_helping == 'yes')
                                                            <b>Yes</b>
                                                        @else
                                                            @if ($behaviour_details->technical_helping == 'no')
                                                                <b>No</b>
                                                            @else
                                                                <b>NA</b>
                                                            @endif
                                                        @endif
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Is the client educated</span>
                                                    <h3 class="m-0 p-0">
                                                        @if ($behaviour_details->educated == 'yes')
                                                            <b>Yes</b>
                                                        @else
                                                            @if ($behaviour_details->educated == 'no')
                                                                <b>No</b>
                                                            @else
                                                                <b>NA</b>
                                                            @endif
                                                        @endif
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="m-1 mt-3 mb-5">
                                    <h2 class="mb-3 ml-2"><strong>Order Details</strong></h2>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Whom to contact for order</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ ucwords($behaviour_details->order_contact ? $behaviour_details->order_contact : 'NA') }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Is party requires followup regarding
                                                        order</span>
                                                    <h3 class="m-0 p-0">
                                                        @if ($behaviour_details->order_followups_required == 'yes')
                                                            <b>Yes</b>
                                                        @else
                                                            @if ($behaviour_details->order_followups_required == 'no')
                                                                <b>No</b>
                                                            @else
                                                                <b>NA</b>
                                                            @endif
                                                        @endif
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-1 mt-3 mb-5">
                                    <h2 class="mb-3 ml-2"><strong>Payment Details</strong></h2>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Whom to contact for payment</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ ucwords($behaviour_details->payment_contact ? $behaviour_details->payment_contact : 'NA') }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">How is payment condition of client</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ ucwords($behaviour_details->payment_condition ? $behaviour_details->payment_condition : 'NA') }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Is the client a past payment defaulter? If
                                                        Yes then please specify.</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ ucwords($behaviour_details->past_payment_defaulter ? $behaviour_details->past_payment_defaulter : 'NA') }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Is client safe regarding payment?</span>
                                                    <h3 class="m-0 p-0">
                                                        @if ($behaviour_details->payment_safety == 'yes')
                                                            <b>Yes</b>
                                                        @else
                                                            @if ($behaviour_details->payment_safety == 'no')
                                                                <b>No</b>
                                                            @else
                                                                <b>NA</b>
                                                            @endif
                                                        @endif
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-12 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Does party require followup regarding
                                                        payment or paying on time regarding due date</span>
                                                    <h3 class="m-0 p-0">
                                                        @if ($behaviour_details->payment_followups_required == 'yes')
                                                            <b>Yes</b>
                                                        @else
                                                            @if ($behaviour_details->payment_followups_required == 'no')
                                                                <b>No</b>
                                                            @else
                                                                <b>NA</b>
                                                            @endif
                                                        @endif
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-1 mt-3 mb-5">
                                    <h2 class="mb-3 ml-2"><strong>Other Details</strong></h2>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Is the client brand lover or price lover
                                                    </span>
                                                    <h3 class="m-0 p-0">
                                                            @if ($behaviour_details->brand_price_lover == 'brand_lover')
                                                                <b>Brand Lover</b>
                                                            @else
                                                            @if ($behaviour_details->brand_price_lover == 'price_lover')
                                                                <b>Price Lover</b>
                                                            @else
                                                                <b>NA</b>
                                                            @endif
                                                        @endif
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Is the client loyal to us reagrding all
                                                        difficulties,price,rise,complaints,trials?</span>
                                                    <h3 class="m-0 p-0">
                                                        @if ($behaviour_details->loyal == 'yes')
                                                            <b>Yes</b>
                                                        @else
                                                            @if ($behaviour_details->loyal == 'no')
                                                                <b>No</b>
                                                            @else
                                                                <b>NA</b>
                                                            @endif
                                                        @endif
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">How many years does the client take for
                                                        manufacturing and generation for it?</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ ucwords($behaviour_details->years_for_generation ? $behaviour_details->years_for_generation : 'NA') }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Does the client have any sample and trial
                                                        done before? If yes then specific about the details</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ ucwords($behaviour_details->trail_done_before ? $behaviour_details->trail_done_before : 'NA') }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Duration of joining in our firm.</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $behaviour_details->duration_of_joining ? $behaviour_details->duration_of_joining : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Is client having any another business than
                                                        paving and specified?</span>
                                                    <h3 class="m-0 p-0">
                                                        @if ($behaviour_details->another_business == 'yes')
                                                            <b>Yes</b>
                                                        @else
                                                            @if ($behaviour_details->another_business == 'no')
                                                                <b>No</b>
                                                            @else
                                                                <b>NA</b>
                                                            @endif
                                                        @endif
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">Is it Partnership /Proprietorship or Pvt
                                                        ltd company & their owner names ?</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ ucwords($behaviour_details->partnership ? $behaviour_details->partnership : 'NA') }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h3 mb-0">How many competitor is client in
                                                        connection with?</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $behaviour_details->competitor_conn ? $behaviour_details->competitor_conn : 'NA' }}</b>
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
            @endif
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
