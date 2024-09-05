@extends('layouts.app')

@section('title', 'Announcement')

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
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="d-flex justify-content-between card-header border-0">
                        {{-- <h1 class="mb-0">{{ ucwords($notice_info->type) }}</h1> --}}
                        <div>
                        </div>
                    </div>

                    <div class="m-3">
                        <div class="row mx-3">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <h3><strong>Start Date </strong>
                                        {{ date("jS F, Y",strtotime($announcement_info->start_date)) }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-3">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <h3><strong>End Date </strong>
                                        {{ date("jS F, Y",strtotime($announcement_info->end_date)) }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-3">
                            <div class="col-md-12">
                                <h3><strong>Title: </strong> {{ $announcement_info->announcement_title }}</h3>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-md-12">
                                <div class="card-body border border-dark">
                                    <div>
                                        {!! htmlspecialchars_decode($announcement_info->announcement_description) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection