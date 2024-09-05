@extends('layouts.app')

@section('title', 'Add Task')

@section('content')
<div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="m-1">
                <a href="{{ route('assigned_tasks') }}" class="btn btn-primary px-3">
                    <span class="text-secondary h3"><i class="ni ni-bold-left mr-2" style="font-size: 14px; vertical-align: middle;"></i>Assigned Tasks</span>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h1 class="mb-0">Add Task</h1>
                </div>
                <form action="{{ route('save_tasks') }}" method="POST">
                    @csrf
                    <div class="m-3">
                        <div class="row mx-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="task_title">Enter Task Title<span
                                        class="text-danger">*</span></label>
                                    <input type="text" name="task_title"
                                        class="form-control @error('task_title') is-invalid @enderror" id="task_title"
                                        value="{{ old('task_title') }}" maxlength="255" placeholder="Enter Task Title">
                                    @error('task_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="task_assigned_by">Task Assigned By<span
                                        class="text-danger">*</span></label>
                                        <select class="form-control @error('task_assigned_by') is-invalid @enderror"
                                        name="task_assigned_by" id="task_assigned_by">
                                        <option value="{{ Auth::user()->id }}" {{ (old("task_assigned_by") == Auth::user()->id) ? "selected" : "" }} >{{Auth::user()->full_name}}</option>
                                    </select>
                                    
                                    @error('task_assigned_by')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="task_assigned_to">Task Assign to<span
                                        class="text-danger">*</span></label>
                                    <select class="form-control @error('task_assigned_to') is-invalid @enderror"
                                        name="task_assigned_to" id="task_assigned_to">
                                        <option value="">Choose Type</option>
                                        @if (Auth::user()->parent_employee && Auth::user()->parent_employee->role_id != config('constants.director_role_id'))
                                            <option value="{{Auth::user()->parent_employee->id}}" {{ (old("task_assigned_to") == Auth::user()->parent_employee->id) ? "selected" : "" }} >{{ Auth::user()->parent_employee->full_name }}</option>
                                        @endif
                                        @foreach (Auth::user()->child_employees as $child_employee )
                                            <option value="{{$child_employee->id}}" {{ (old("task_assigned_to") == $child_employee->id) ? "selected" : "" }} >{{ $child_employee->full_name }}</option>
                                        @endforeach 
                                    </select>
                                    @error('task_assigned_to')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="task_status">Task Status<span
                                        class="text-danger">*</span></label>
                                    <select class="form-control @error('task_status') is-invalid @enderror"
                                        name="task_status"  value="{{ old('task_status') }}" id="task_status">
                                        <option value="1" {{ old('task_status') == 1 ? "selected" : "" }} >Incomplete</option>
                                        <option value="2" {{ old('task_status') == 2 ? "selected" : "" }} >In Progress</option>
                                        <option value="3" {{ old('task_status') == 3 ? "selected" : "" }} >Complete</option>
                                    </select>
                                    @error('task_status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="task_description">Enter Task Description <span
                                            class="text-danger">*</span></label>
                                    <textarea
                                        class="form-control @error('task_description') is-invalid @enderror"
                                        name="task_description" id="task_description" rows="6" maxlength="4000"
                                        placeholder="Enter Task Description" >{{ old('task_description') }}</textarea>
                                    @error('task_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0">
                        <button class="btn btn-primary" id="addProduct" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
