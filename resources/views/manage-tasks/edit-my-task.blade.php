@extends('layouts.app')

@section('title', 'Edit My Task')

@section('content')


<div>
    <div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ route('manage_tasks') }}" class="btn btn-primary px-3">
                        <span class="text-secondary h3"><i class="ni ni-bold-left mr-2" style="font-size: 14px; vertical-align: middle;"></i>My Tasks</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <h1 class="mb-0">Edit Task</h1>
                    </div>
                    <form action="{{ route('update_tasks',$task_info->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="m-3">
                            <div class="row mx-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="task_title">Enter Task Title<span
                                            class="text-danger">*</span></label>
                                        <input type="text" name="task_title"
                                            class="form-control @error('task_title') is-invalid @enderror" id="task_title"
                                            value="{{ old('task_title',$task_info->task_title) }}" maxlength="255" placeholder="Enter Task Title" readonly>
                                        @error('task_title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="task_assigned_by">Task Assigned By<span
                                            class="text-danger">*</span></label>
                                            <input type="text" name="task_assigned_by"
                                            class="form-control @error('task_assigned_by') is-invalid @enderror" id="task_assigned_by"
                                            value="{{ old('task_assigned_by',$task_info->assigned_by->full_name) }}" placeholder="Enter Task Title" readonly>
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
                                            <input type="text" name="task_assigned_to"
                                            class="form-control @error('task_assigned_to') is-invalid @enderror" id="task_assigned_to"
                                            value="{{ $task_info->assigned_to->full_name }}" placeholder="Enter Task Title" readonly>
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
                                            name="task_status" id="task_status">
                                            <option value="1" {{ old("task_status",$task_info->isActive) == 1 ? 'selected' : '' }} >Incomplete</option>
                                            <option value="2" {{ old("task_status",$task_info->isActive) == 2 ? 'selected' : '' }} >In Progress</option>
                                            <option value="3" {{ old("task_status",$task_info->isActive) == 3 ? 'selected' : '' }} >Complete</option>
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
                                        <textarea type="text" name="task_description" rows="10"
                                            class="form-control @error('task_description') is-invalid @enderror" id="task_description"
                                            maxlength="4000" placeholder="Enter Task Title" readonly>{{ old("task_description",$task_info->task_description) }}</textarea>
                                            @error('task_description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="task_notes">Task Notes</label>
                                        <textarea type="text" name="task_notes" rows="10"
                                            class="form-control" maxlength="4000" placeholder="Enter Task notes">{{ old("task_notes",$task_info->task_notes) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0">
                            <button class="btn btn-primary" id="addProduct" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection