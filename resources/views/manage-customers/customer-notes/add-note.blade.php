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
                    <h1 class="mb-0">Add Customer Notes</h1>
                </div>
                <form action="{{ route('saveNote_customers', $customer_id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="notes_date">Date <span class="text-danger">*</span></label>
                                    <input type="date" min="{{ date('Y-m-d') }}" name="notes_date"
                                        class="form-control @error('notes_date') is-invalid @enderror" id="notes_date"
                                        value="{{ old('notes_date') }}">
                                    @error('notes_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="notes_time"> Time <span class="text-danger">*</span></label>
                                    <input type="text" name="notes_time"
                                        class="form-control CallTimePicker @error('notes_time') is-invalid @enderror" id="notes_time"
                                        value="{{ old('notes_time') }} ">
                                    @error('notes_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="notes_description">Enter Description <span class="text-danger">*</span></label>
                                    <textarea
                                        class="form-control @error('notes_description') is-invalid @enderror"
                                        name="notes_description" id="notes_description" rows="5" maxlength="1500"
                                        placeholder="Enter Description">{{old('notes_description')}}</textarea>
                                    @error('notes_description')
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
            $('input.CallTimePicker').timepicker({
                timeFormat: 'h:mm p',
                interval: 15,
                minTime: '{{ Carbon::now()->startOfDay()->format("H:i:m") }}',
                maxTime: '{{ Carbon::now()->format("H:i:m") }}',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
        });
    </script>
    
@endsection
