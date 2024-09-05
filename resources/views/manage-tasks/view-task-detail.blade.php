@extends('layouts.app')

@section('title', 'View Task')

@section('content')
{{-- @dd($task_info) --}}
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
        {{-- @dd($task_info) --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    {{-- <h1 class="m-3">Page Under Construction</h1> --}}
                    <div class="d-flex justify-content-between card-header">
                        <h1 class="mb-0">Task Details</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="m-1 mt-3 mb-5">
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Task Title</span>
                                                    <h3 class="m-0 p-0"><b>{{($task_info->task_title) }}</b></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Task Assigned by </span>
                                                    <h3 class="m-0 p-0"><b>{{($task_info->assigned_by->full_name ) }}</b></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Task Assigned to </span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{($task_info->assigned_to->full_name ) }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Task Status</span>
                                                    <h3 class="m-0 p-0">
                                                        @if ($task_info->task_status == 1)
                                                            <span class="badge badge-danger px-2">Incomplete</span>
                                                        @elseif ($task_info->task_status == 2)
                                                            <span class="badge badge-warning px-2">In progress</span>
                                                        @elseif($task_info->task_status == 3)
                                                            <span class="badge badge-success px-2">Completed</span>
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
                                                    <span class="h5 mb-0">Task Description</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{!!($task_info->task_description) !!}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Task Notes</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{!! ($task_info->task_notes) ? $task_info->task_notes : 'NA' !!}</b>
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