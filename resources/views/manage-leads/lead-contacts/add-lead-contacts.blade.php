@extends('layouts.app')

@section('title', 'Manage Leads')

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
    
    @include('layouts.partials.lead-nav-menu')

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                {{-- <h1 class="m-3">Page Under Construction</h1> --}}
                <div class="d-flex justify-content-between card-header">
                    <h1 class="mb-0">Add Lead Contact Details</h1>
                </div>
                <form action="{{ route('saveContacts_leads', $lead_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="person_name">Enter Person Name <span class="text-danger">*</span></label>
                                <input type="text" name="person_name"
                                    class="form-control @error('person_name') is-invalid @enderror" id="person_name"
                                    value="{{ old('person_name') }}" maxlength="255" placeholder="Enter Person Name">
                                @error('person_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Enter Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone_number"
                                    class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                                    value="{{ old('phone_number') }}" placeholder="Enter Phone Number">
                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="contact_image">Contact Image </label>
                                <input type="file" name="contact_image" accept=".jpeg,.jpg,.png"
                                    class="form-control @error('contact_image') is-invalid @enderror" id="contact_image"
                                    value="{{ old('contact_image') }}" placeholder="Enter Email">
                                @error('contact_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="designation">Enter Designation <span class="text-danger">*</span></label>
                                <input type="text" name="designation"
                                    class="form-control @error('designation') is-invalid @enderror" id="designation"
                                    value="{{ old('designation') }}" maxlength="30" placeholder="Enter Designation">
                                @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="person_email">Enter Email <span class="text-danger">*</span></label>
                                <input type="email" name="person_email"
                                    class="form-control @error('person_email') is-invalid @enderror" id="person_email"
                                    value="{{ old('person_email') }}" maxlength="50" placeholder="Enter Email">
                                @error('person_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="contact_status">Contact Status <span class="text-danger">*</span></label>
                                <select class="form-control @error('contact_status') is-invalid @enderror"
                                    name="contact_status" id="contact_status">
                                    <option value="1" {{ old('contact_status') == 1 ? "selected" : "" }}>Active</option>
                                    <option value="0" {{ old('contact_status') == 0 ? "selected" : "" }}>Inactive</option>
                                </select>
                                @error('contact_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes">Enter Notes </label>
                                <textarea
                                    class="form-control @error('notes') is-invalid @enderror"
                                    name="notes" id="notes" rows="5" value="{{ old('notes') }}" maxlength="1500"
                                    placeholder="Enter Notes">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
            $('.lead-menu').slick({
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
