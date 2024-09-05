@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')
    <div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ route("viewBehaviourDetails_customers",['customer_id' => $customer_id]) }}" class="btn btn-primary px-3">
                        <span class="text-secondary h3"><i class="ni ni-bold-left mr-2" style="font-size: 14px; vertical-align: middle;"></i>Back</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <h1 class="mb-0">Edit Behaviour</h1>
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
                    {{-- @dd($customer_id,$behaviour_details); --}}
                    <form action="{{ route('updateBehaviour_customers',['customer_id' => $customer_id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- @method('POST') --}}
                        <div class="m-3">
                            <div class="row mx-2">
                                <div class="col-md-6">
                                    <h2 class="mb-3">Basic Details</h2>
                                        <div class="form-group">
                                            <label for="customer_nature">Nature of Client</label>
                                            <input type="text" name="customer_nature"
                                                class="form-control @error('customer_nature') is-invalid @enderror" id="customer_nature"
                                                value="{{(($behaviour_details) ? $behaviour_details->nature : '')}}" maxlength="40" placeholder="Enter Nature of Client">
                                            @error('customer_nature')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="price_checker">Is client a price cross checker? </label>
                                            <select class="form-control @error('price_checker') is-invalid @enderror"
                                                name="price_checker" id="price_checker">
                                                <option value="">Choose Yes or No</option>
                                                @if ($behaviour_details)
                                                    <option value="yes" {{ old("price_checker",$behaviour_details->price_cross_checker) == "yes" ? 'selected' : '' }}>Yes</option>
                                                    <option value="no" {{ old("price_checker",$behaviour_details->price_cross_checker) == "no" ? 'selected' : '' }}>No</option>
                                                @else
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                @endif
                                            </select>
                                            @error('price_checker')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_friendly">Is client friendly to provide market and compitator infrmation? </label>
                                            <select class="form-control @error('customer_friendly') is-invalid @enderror"
                                                name="customer_friendly" id="customer_friendly">
                                                <option value="">Choose Yes or No</option>

                                                @if ($behaviour_details)
                                                    <option value="yes" {{ old("customer_friendly",$behaviour_details->friendly) == "yes" ? 'selected' : '' }}>Yes</option>
                                                    <option value="no" {{ old("customer_friendly",$behaviour_details->friendly) == "no" ? 'selected' : '' }}>No</option>
                                                @else
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                @endif
                                            </select>
                                            @error('customer_friendly')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_soft_corner">Any special condition or soft corner for the client?</label>

                                            @if ($behaviour_details)
                                                <input type="text" name="customer_soft_corner"
                                                class="form-control @error('customer_soft_corner') is-invalid @enderror" id="customer_soft_corner"
                                                value="{{ $behaviour_details->soft_corner }}" maxlength="40" placeholder="Enter if yes  ">
                                            @else
                                                <input type="text" name="customer_soft_corner"
                                                class="form-control @error('customer_soft_corner') is-invalid @enderror" id="customer_soft_corner" placeholder="Enter if yes  ">
                                            @endif

                                            @error('customer_soft_corner')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="technical_help">Is the client very technical and helping in nature? </label>
                                            <select class="form-control @error('technical_help') is-invalid @enderror"
                                                name="technical_help" id="technical_help">
                                                <option value="">Choose Yes or No</option>

                                                @if ($behaviour_details)
                                                    <option value="yes" {{ $behaviour_details->technical_helping == "yes" ? 'selected' : '' }}>Yes</option>
                                                    <option value="no" {{ $behaviour_details->technical_helping == "no" ? 'selected' : '' }}>No</option>
                                                @else
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                @endif

                                            </select>
                                            @error('technical_help')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_education">Is the client educated? </label>
                                            <select class="form-control @error('customer_education') is-invalid @enderror"
                                                name="customer_education" id="customer_education">
                                                <option value="">Choose Yes or No</option>

                                                @if ($behaviour_details)
                                                    <option value="yes" {{ $behaviour_details->educated == "yes" ? 'selected' : '' }}>Yes</option>
                                                    <option value="no" {{ $behaviour_details->educated == "no" ? 'selected' : '' }}>No</option>
                                                @else
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                @endif

                                            </select>
                                            @error('customer_education')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    <h2 class="mb-3">Payment Details</h2>
                                        <div class="form-group">
                                            <label for="contact_payment">Whom to contact for payment?</label>

                                            @if ($behaviour_details)
                                                <input type="text" name="contact_payment"
                                                class="form-control @error('contact_payment') is-invalid @enderror" id="contact_payment"
                                                value="{{ $behaviour_details->payment_contact }}" maxlength="40" placeholder="Enter Contact person's name">
                                            @else
                                                <input type="text" name="contact_payment"
                                                class="form-control @error('contact_payment') is-invalid @enderror" id="contact_payment" placeholder="Enter Contact person's name">
                                            @endif

                                            @error('contact_payment')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="pay_condition">How is payment condition of client?</label>

                                            @if ($behaviour_details)
                                                <input type="text" name="pay_condition"
                                                class="form-control @error('pay_condition') is-invalid @enderror" id="pay_condition"
                                                value="{{ $behaviour_details->payment_condition }}" maxlength="40" placeholder="Enter Payment condition">
                                            @else
                                                <input type="text" name="pay_condition"
                                                class="form-control @error('pay_condition') is-invalid @enderror" id="pay_condition" placeholder="Enter Payment condition">
                                            @endif

                                            @error('pay_condition')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="payment_safety">Is client safe regarding payment?</label>
                                            <select class="form-control @error('payment_safety') is-invalid @enderror"
                                                name="payment_safety" id="payment_safety">
                                                <option value="">Choose Yes or No</option>

                                                @if ($behaviour_details)
                                                    <option value="yes" {{ $behaviour_details->payment_safety == "yes" ? 'selected' : '' }}>Yes</option>
                                                    <option value="no" {{ $behaviour_details->payment_safety == "no" ? 'selected' : '' }}>No</option>
                                                @else
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                @endif

                                            </select>
                                            @error('payment_safety')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="past_defaulter">Is the client a past payment defaulter? If Yes then please specify.</label>

                                            @if ($behaviour_details)
                                                <input type="text" name="past_defaulter"
                                                class="form-control @error('past_defaulter') is-invalid @enderror" id="past_defaulter"
                                                value="{{ $behaviour_details->past_payment_defaulter }}" maxlength="40" placeholder="Enter if Yes">
                                            @else
                                                <input type="text" name="past_defaulter"
                                                class="form-control @error('past_defaulter') is-invalid @enderror" id="past_defaulter" placeholder="Enter if Yes">
                                            @endif

                                            @error('past_defaulter')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="payment_followups">Does party require followup regarding payment or paying on time regarding due date?</label>
                                            <select class="form-control @error('payment_followups') is-invalid @enderror"
                                                name="payment_followups" id="payment_followups">
                                                <option value="">Choose Yes or No</option>

                                                @if ($behaviour_details)
                                                    <option value="yes" {{ $behaviour_details->payment_followups_required == "yes" ? 'selected' : '' }}>Yes</option>
                                                    <option value="no" {{ $behaviour_details->payment_followups_required == "no" ? 'selected' : '' }}>No</option>
                                                @else
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                @endif

                                            </select>
                                            @error('payment_followups')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    <h2 class="mb-3">Other Details</h2>
                                            <div class="form-group">
                                                <label for="brand_lover">Is the client brand lover or price lover? </label>
                                                <select class="form-control @error('brand_lover') is-invalid @enderror"
                                                    name="brand_lover" id="brand_lover">
                                                    <option value="">Choose</option>

                                                    @if ($behaviour_details)
                                                        <option value="brand_lover" {{ $behaviour_details->brand_price_lover == "brand_lover" ? 'selected' : '' }}>Brand Lover</option>
                                                        <option value="price_lover" {{ $behaviour_details->brand_price_lover == "price_lover" ? 'selected' : '' }}>Price Lover</option>
                                                    @else
                                                        <option value="brand_lover">Brand Lover</option>
                                                        <option value="price_lover">Price Lover</option>
                                                    @endif

                                                </select>
                                                @error('brand_lover')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="other_business">Is client having any another business than paving and specified? </label>
                                                <select class="form-control @error('other_business') is-invalid @enderror"
                                                    name="other_business" id="other_business">
                                                    <option value="">Choose Yes or No</option>

                                                    @if ($behaviour_details)
                                                        <option value="yes" {{ $behaviour_details->another_business == "yes" ? 'selected' : '' }}>Yes</option>
                                                        <option value="no" {{ $behaviour_details->another_business == "no" ? 'selected' : '' }}>No</option>
                                                    @else
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    @endif

                                                </select>
                                                @error('other_business')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="joining_duration">Duration of joining in our firm </label>

                                                @if ($behaviour_details)
                                                    <input type="text" name="joining_duration"
                                                    class="form-control @error('joining_duration') is-invalid @enderror"
                                                    id="joining_duration" value="{{  $behaviour_details->duration_of_joining }}" maxlength="40"
                                                    placeholder="Enter joining duration">
                                                @else
                                                    <input type="text" name="joining_duration"
                                                    class="form-control @error('joining_duration') is-invalid @enderror"
                                                    id="joining_duration" placeholder="Enter joining duration">
                                                @endif
                                                
                                                @error('joining_duration')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="conn_competitor">How many competitor is client in connection with? </label>

                                                @if ($behaviour_details)
                                                    <input type="text" name="conn_competitor"
                                                    class="form-control @error('conn_competitor') is-invalid @enderror"
                                                    id="conn_competitor" value="{{  $behaviour_details->competitor_conn }}" maxlength="40"
                                                    placeholder="Enter count of competitor in connection">
                                                @else
                                                    <input type="text" name="conn_competitor"
                                                    class="form-control @error('conn_competitor') is-invalid @enderror"
                                                    id="conn_competitor" placeholder="Enter count of competitor in connection">
                                                @endif

                                                @error('conn_competitor')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="loyalty">Is the client loyal to us reagrding all difficulties, price, rise, complaints, trials?</label>
                                                <select class="form-control @error('loyalty') is-invalid @enderror"
                                                    name="loyalty" id="loyalty">
                                                    <option value="">Choose Yes or No</option>

                                                    @if ($behaviour_details)
                                                        <option value="yes" {{ $behaviour_details->loyal == "yes" ? 'selected' : '' }}>Yes</option>
                                                        <option value="no" {{ $behaviour_details->loyal == "no" ? 'selected' : '' }}>No</option>
                                                    @else
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    @endif

                                                </select>
                                                @error('loyalty')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="years_generation">How many years does the client take for manufacturing and generation for it?</label>

                                                @if ($behaviour_details)
                                                    <input type="text" name="years_generation"
                                                    class="form-control @error('years_generation') is-invalid @enderror"
                                                    id="years_generation" value="{{ $behaviour_details->years_for_generation }}" maxlength="40"
                                                    placeholder="Enter number of years">
                                                @else
                                                    <input type="text" name="years_generation"
                                                    class="form-control @error('years_generation') is-invalid @enderror"
                                                    id="years_generation" placeholder="Enter number of years">
                                                @endif

                                                @error('years_generation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="trail_before">Does the client have any sample and trial done before? If yes then specific about the details. </label>

                                                @if ($behaviour_details)
                                                    <input type="text" name="trail_before"
                                                    class="form-control @error('trail_before') is-invalid @enderror"
                                                    id="trail_before" value="{{  $behaviour_details->trail_done_before }}" maxlength="40"
                                                    placeholder="Enter if yes">
                                                @else
                                                    <input type="text" name="trail_before"
                                                    class="form-control @error('trail_before') is-invalid @enderror"
                                                    id="trail_before" placeholder="Enter if yes">
                                                @endif

                                                @error('trail_before')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="customer_partnership">Is it Partnership /Proprietorship or Pvt ltd company & their owner names ?</label>
                                                @if ($behaviour_details)
                                                    <input type="text" name="customer_partnership"
                                                    class="form-control @error('customer_partnership') is-invalid @enderror"
                                                    id="customer_partnership" value="{{  $behaviour_details->partnership }}" maxlength="40"
                                                    placeholder="Enter here">
                                                @else
                                                    <input type="text" name="customer_partnership"
                                                    class="form-control @error('customer_partnership') is-invalid @enderror"
                                                    id="customer_partnership"placeholder="Enter here">
                                                @endif
                                                
                                                @error('customer_partnership')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <h2 class="mb-3">Order Details</h2>
                                            <div class="form-group">
                                                <label for="contact_order">Whom to contact for order?</label>

                                                @if ($behaviour_details)
                                                    <input type="text" name="contact_order"
                                                    class="form-control @error('contact_order') is-invalid @enderror" id="contact_order"
                                                    value="{{ $behaviour_details->order_contact }}" maxlength="40" placeholder="Enter contact person's name  ">
                                                @else
                                                    <input type="text" name="contact_order"
                                                    class="form-control @error('contact_order') is-invalid @enderror" id="contact_order" placeholder="Enter contact person's name  ">
                                                @endif

                                                @error('contact_order')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="order_followups">Is party requires followup regarding order? </label>
                                                <select class="form-control @error('order_followups') is-invalid @enderror"
                                                    name="order_followups" id="order_followups">
                                                    <option value="">Choose Yes or No</option>

                                                    @if ($behaviour_details)
                                                        <option value="yes" {{ $behaviour_details->order_followups_required == "yes" ? 'selected' : '' }}>Yes</option>
                                                        <option value="no" {{ $behaviour_details->order_followups_required == "no" ? 'selected' : '' }}>No</option>
                                                    @else
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    @endif

                                                </select>
                                                @error('order_followups')
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
