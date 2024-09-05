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
            <form action="{{ route('update_announcement',$announcement_info->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card shadow">
                    <div class="d-flex justify-content-between card-header">
                        <h1 class="mb-0">Edit Annoucement</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="announcement_title" class="form-control-label">Enter Announcment Title</label>
                                    <input class="form-control @error('announcement_title')
                                        is-invalid
                                    @enderror" type="text" value="{{ $announcement_info->announcement_title }}" name="announcement_title" maxlength="255" placeholder="Enter Announcment Title " id="announcement_title">
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
                                            <label for="start_date" class="form-control-label">Start Date</label>
                                            <input class="form-control @error('start_date')
                                            is-invalid
                                                @enderror" type="date" min="{{ date("Y-m-d") }}" value="{{ old("start_date",date('Y-m-d',strtotime($announcement_info->start_date)))  }}" name="start_date" id="start_date">
                                                @error('start_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label for="end_date" class="form-control-label">End Date</label>
                                            <input class="form-control @error('end_date')
                                            is-invalid
                                                @enderror" type="date" min="{{ date("Y-m-d") }}" value="{{ old("end_date",date('Y-m-d',strtotime($announcement_info->end_date)))  }}" name="end_date" id="end_date">
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
                                <textarea id="summernote" name="announcement_description">{!! $announcement_info->announcement_description  !!}{{ old("announcement_description",$announcement_info->announcement_description) }}</textarea>
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
                            <button class="btn btn-primary" type="submit">Update</button>
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