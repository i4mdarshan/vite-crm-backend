@extends('layouts.app')

@section('title', 'Assign Task')

@section('content')
 


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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <h1 class="mb-0">Assigned Tasks</h1>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            @if ($module_access[0] == 1)
                                <a href="{{ route('add_tasks') }}" class="btn btn-secondary float-right mx-1 my-2 my-md-0">Add <i class="fas fa-plus-circle"></i> </a>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="mt-3">
                                <h3>
                                    Total records: 
                                    <strong>
                                        {{ number_format($assigned_tasks->count()) }}
                                    </strong>
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {{-- Search Form --}}
                            <form action="{{ route('search_tasks') }}" class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto" method="GET">
                                <div class="form-group mb-0">
                                    <div class="input-group input-group-alternative">
                                        <input class="form-control" placeholder="Search By Title, assigned by , assigned to ..." name="q" type="text" autocomplete="off">
                                    </div>
                                    <button class="btn btn-secondary btn-icon mx-1" type="submit">
                                        <span><i class="fas fa-search"></i></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="height: 75vh; overflow-y: auto">
                        <table class="table align-items-center">
                            <thead class="thead-light" style="position: sticky; top:0;background-color: #f3f3f2;z-index: 999">
                                <tr>
                                    <th class="pr-2 pl-3" scope="col"></th>
                                    <th class="pl-2" scope="col">Title</th>
                                    <th scope="col">Assigned By</th>
                                    <th scope="col">Assigned To</th>
                                    
                                    <th scope="col">Status</th>
                                    {{-- @if ($module_access[0] == 1)  --}}
                                        <th scope="col">Action</th>
                                    {{-- @endif --}}
                                    
                                </tr>
                            </thead>
                            <tbody class="list">

                                 @if (count($assigned_tasks) == 0) 
                                    <tr>
                                        <td>No records available</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                      
                                    </tr>
                                 @endif
                                @foreach ($assigned_tasks as $key=>$task)
                                     {{-- @dd($task->task_assigned_user)  --}}
                                    <tr>
                                        <td class="pr-2 pl-3">{{ $assigned_tasks->firstItem() + $key }}</td>
                                        <td class="pl-2">{{ Str::of($task->task_title)->limit(60)}}</td>
                                        <td>{{ $task->assigned_by->full_name }}</td>
                                        <td>{{ $task->assigned_to->full_name }}</td>
                                      
                                        <td>
                                           @if ($task->task_status == 1)
                                                <span class="badge badge-danger px-2">InComplete</span>
                                            @elseif ($task->task_status == 2)
                                                <span class="badge badge-warning px-2">In Progress</span>
                                            @elseif($task->task_status == 3)
                                                <span class="badge badge-success px-2">Completed</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('view_tasks',$task->id) }}" class="btn btn-sm btn-secondary" id="view_announcement">
                                                <span class="p" style="font-size: 12px;">View</span>
                                                <i class="ni ni-bold-right"></i>
                                            </a>
                                            @if ($module_access[0] == 1)
                                           
                                            <span>
                                                <a href="{{ route('edit_tasks',$task->id)}}" class="btn btn-sm btn-secondary" id="edit_product_category">
                                                    <span class="p" style="font-size: 12px;">Edit</span>
                                                    <i class="fas fa-pencil-ruler color-muted m-r-5"></i>
                                                </a>
                                               
                                                <a href="{{ route('delete_tasks',$task->id)}}" class="btn btn-sm btn-danger deleteProduct" id="deleteProduct">
                                                    <i class="fas fa-trash color-muted m-r-5"></i>
                                                </a>
                                            </span>
                                            @endif 
                                        </td>
                                       
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav aria-label="...">
                        {{ $assigned_tasks->links('layouts.partials.pagination-links') }}
                    </nav>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
</div>
@endsection







