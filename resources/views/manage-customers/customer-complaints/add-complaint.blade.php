@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')

{{-- @dd(request()->is('manage_leads/view/profile*')) --}}
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
                    <h1 class="mb-0">Add Customer Complaint Details</h1>
                </div>
                <form action="{{ route('saveComplaints_customers', $customer_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="complaints_received_by">Complaint received by <span class="text-danger">*</span></label>
                                <input type="text" name="complaints_received_by"
                                    class="form-control @error('complaints_received_by') is-invalid @enderror" id="complaints_received_by" value="{{ ucwords(Auth::user()->full_name) }}" readonly>
                                @error('complaints_received_by')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="complaints_raised_by">Complaint raised by <span class="text-danger">*</span></label>
                                <select class="form-control @error('complaints_raised_by') is-invalid @enderror" name="complaints_raised_by" id="complaints_raised_by">
                                    <option value="">Choose Contact</option>
                                    @foreach ($customer_contacts as $customer_contact)
                                        <option value="{{ $customer_contact->id }}" {{ old('complaints_raised_by') == $customer_contact->id ? "selected" : ""}}>{{ ucwords($customer_contact->contact_person_name) }}</option>
                                    @endforeach
                                </select>
                                @error('complaints_raised_by')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="complaints_subject">Complaint subject <span class="text-danger">*</span></label>
                                <input type="text" name="complaints_subject"
                                    class="form-control @error('complaints_subject') is-invalid @enderror" id="complaints_subject"
                                    value="{{ old('complaints_subject') }}" maxlength="100" placeholder="Enter Complaint Subject">
                                @error('complaints_subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="complaints_description">Enter Complaint Description <span class="text-danger">*</span></label>
                                <textarea name="complaints_description" rows="6"
                                    class="form-control @error('complaints_description') is-invalid @enderror" id="complaints_description" maxlength="4000" placeholder="Enter complaint description">{{ old('complaints_description') }}</textarea>
                                @error('complaints_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="m-1">
                                <label class="mb-2">Complaint Photos
                                    <small>(File size should be less than 2Mb)</small></label>
                                <div class="input-group parent-input mb-3 increment">
                                    <input type="file" name="complaint_photos[]" accept=".jpg,.png,.jpeg"
                                        class="form-control @error('complaint_photos.*')
                                    is-invalid
                                @enderror"
                                        aria-label="Complaint Photos" aria-describedby="button-addon2">

                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" type="button"
                                            id="button-add">Add</button>
                                    </div>

                                    @error('complaint_photos.*')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                                <div class="clone" style="display: none;">
                                    <div class="input-group parent-input mb-3">
                                        <input type="file" accept=".jpg,.png,.jpeg"
                                            class="form-control @error('complaint_photos')
                                        is-invalid
                                    @enderror"
                                            name="complaint_photos[]" aria-label="Complaint Photos"
                                            aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-icon btn-danger" type="button" id="button-add">
                                                    <span class="btn-inner--icon"><i class="fas fa-trash" style="font-size: 14px;"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
                </form>
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

            //function to clone file input on add
            $("#button-add").click(function() {
                var lsthmtl = $(".clone").html();
                $(".increment").after(lsthmtl);
            });
            $("body").on("click", ".btn-danger", function() {
                $(this).parents(".parent-input").remove();
            });
        });
    </script>
    
@endsection
