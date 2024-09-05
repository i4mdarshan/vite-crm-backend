@extends('layouts.app')

@section('title', 'Forward Task')

@section('content')
    {{-- @dd($task_info) --}}

    {{-- need to add the employee forward and parent relationship for the employ part  --}}
    <div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ url()->previous() }}" class="btn btn-primary px-3">
                        <span class="text-secondary h3"><i class="ni ni-bold-left mr-2"
                                style="font-size: 14px; vertical-align: middle;"></i>Back</span>
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
                        <h1 class="mb-0">Forward Task</h1>
                    </div>
                    <form action="{{ route('save_tasks') }}" method="POST">
                        @csrf
                        <div class="m-3">
                            <div class="row mx-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="task_title">Enter Task Title<span class="text-danger">*</span></label>
                                        <input type="text" name="task_title"
                                            class="form-control @error('task_title') is-invalid @enderror" id="task_title"
                                            value="{{ $task_info->task_title }}" maxlength="255"
                                            placeholder="Enter Task Title" readonly>

                                    </div>
                                    <div class="form-group">
                                        <label for="task_assigned_by">Task Assigned By<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control @error('task_assigned_by') is-invalid @enderror"
                                            name="task_assigned_by" id="task_assigned_by" readonly>
                                            <option value="{{ Auth::user()->id }}">{{ Auth::user()->full_name }}</option>
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
                                            @if (Auth::user()->parent_employee &&
                                                Auth::user()->parent_employee->role_id != config('constants.director_role_id'))
                                                <option value="{{ Auth::user()->parent_employee->id }}">
                                                    {{ Auth::user()->parent_employee->full_name }}</option>
                                            @endif
                                            @foreach (Auth::user()->child_employees as $child_employee)
                                                <option value="{{ $child_employee->id }}">{{ $child_employee->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('task_assigned_to')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="task_status">Task Status<span class="text-danger">*</span></label>
                                        <select class="form-control @error('task_status') is-invalid @enderror"
                                            name="task_status" id="task_status" readonly>
                                            <option value="1">Incomplete</option>
                                            <option value="2">In Progress</option>
                                            <option value="3">Complete</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="task_description">Enter Task Description <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control @error('task_description') is-invalid @enderror" name="task_description"
                                            id="task_description" rows="6" maxlength="4000" placeholder="Enter Task Description">{{ $task_info->task_description }}</textarea>
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
                            <button class="btn btn-primary" type="submit">Forward Task</button>
                        </div>
                    </form>
                </div>



            </div>

        </div>

    </div>
@endsection
