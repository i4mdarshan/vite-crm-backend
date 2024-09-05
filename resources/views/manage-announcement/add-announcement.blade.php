@extends('layouts.app')

@section('title', 'Manage Announcements')

@section('summernote_css')
    {{-- Summernote  --}}
    <link href="{{ asset('assets/summernote2/summernote.min.css') }}" rel="stylesheet">
@endsection

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
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('save_announcement') }}" method="POST">
                @csrf
                <div class="card shadow">
                    <div class="d-flex justify-content-between card-header">
                        <h1 class="mb-0">Add Annoucement</h1>
                    </div>
                    <div class="card-body">
                        <div class="row mx-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="announcement_title" class="form-control-label">Enter Announcment Title</label>
                                    <input class="form-control @error('announcement_title')
                                        is-invalid
                                    @enderror" type="text" maxlength="255" value="{{ old('announcement_title') }}" name="announcement_title" placeholder="Enter Announcment Title " id="announcement_title">
                                    @error('announcement_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row px-2">
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label for="start_date">Start Date<span
                                                    class="text-danger">*</span></label>
                                            <input type="date" min="{{ date("Y-m-d") }}" name="start_date"
                                                class="form-control @error('start_date') is-invalid @enderror"
                                                id="start_date" value="{{ old('start_date') }}"
                                                placeholder="Enter Customer Phone 1">
                                            @error('start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label for="end_date">End Date<span
                                                class="text-danger">*</span></label>
                                            <input type="date" min="{{ date("Y-m-d") }}" name="end_date"
                                                class="form-control @error('end_date') is-invalid @enderror"
                                                id="end_date" value="{{ old('end_date') }}"
                                                placeholder="Enter Customer Phone 2">
                                            @error('end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="announcement_description" class="form-control-label">Enter Announcement Description</label>
                                <textarea id="summernote" maxlength="4000" name="announcement_description">{{ old('announcement_description') }}</textarea>
                                @error('announcement_description')
                                    <span class="invalid-feedback" role="alert" style="display: block !important">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0">
                        <div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom_scripts')
<script src="{{ asset('assets/summernote2/summernote.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Start here...',
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: true,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
    });
</script>
    
@endsection