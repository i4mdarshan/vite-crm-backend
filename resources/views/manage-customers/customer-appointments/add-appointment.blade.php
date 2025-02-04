@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')

    @php
    use Carbon\Carbon;
    @endphp

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
                        <h1 class="mb-0">Add Customer Appointment</h1>
                    </div>
                    <form action="{{ route('saveAppointment_customers', $customer_id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="appointment_date">Date <span class="text-danger">*</span></label>
                                        <input type="date" min="{{ date('Y-m-d') }}" name="appointment_date"
                                            class="form-control @error('appointment_date') is-invalid @enderror"
                                            id="appointment_date" value="{{ old('appointment_date') }}">
                                        @error('appointment_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="appointment_time">Appointment Time <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="appointment_time"
                                            class="form-control CallTimePicker @error('appointment_time') is-invalid @enderror"
                                            id="appointment_time" value="{{ old('appointment_time') }} ">
                                        @error('appointment_time')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="appointment_with">Appointment With <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control @error('appointment_with') is-invalid @enderror"
                                            name="appointment_with" id="appointment_with">
                                            @if (count($customer_contacts) == 0)
                                                <option class="form-control" value="">Please add contact first.</option>
                                            @else
                                                <option class="form-control" value="">Select Contact</option>
                                                @foreach ($customer_contacts as $customer_contact)
                                                    <option class="form-control" value="{{ $customer_contact->id }}" {{ (old("appointment_with") == $customer_contact->id) ? "selected" : "" }}>
                                                        {{ ucwords($customer_contact->contact_person_name) }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('appointment_with')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="appointment_description">Enter Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('appointment_description') is-invalid @enderror" name="appointment_description"
                                            id="appointment_description" rows="5" maxlength="1500" placeholder="Enter Description">{{old('appointment_description')}}</textarea>
                                        @error('appointment_description')
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
        $(document).ready(function() {
            $('.customer-menu').slick({
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
            $('input.CallTimePicker').timepicker({
                timeFormat: 'h:mm p',
                interval: 15,
                minTime: '{{ Carbon::now()->startOfDay()->format('H:i:m') }}',
                maxTime: '{{ Carbon::now()->format('H:i:m') }}',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
        });
    </script>

@endsection
