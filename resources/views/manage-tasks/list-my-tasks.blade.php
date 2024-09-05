@extends('layouts.app')

@section('title', 'My Task')

@section('content')


<div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="d-flex justify-content-between card-header border-0">
                    <h1 class="mb-0">My Task List</h1>
                    @if ($module_access[0] == 1)
                        <div>
                            <a href="{{ route('assigned_tasks') }}"class="btn btn-secondary float-right mx-1 my-2 my-md-0">Assigned Tasks</a> 
                        </div>
                    @endif  
                </div>
                <div class="mt-1 mx-2 px-3">
                    <h3>
                        Total records: 
                        <strong>
                            {{ number_format($my_tasks->count()) }}
                        </strong>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="height: 60vh; overflow-y: auto">
                        <table class="table align-items-center">
                            <thead class="thead-light" style="position: sticky; top:0;background-color: #f3f3f2;z-index: 999">
                                <tr>
                                    <th class="pr-2 pl-3" scope="col"></th>
                                    <th class="pl-2" scope="col">Title</th>
                                    <th scope="col">Assigned By</th>
                                    <th scope="col">Assigned To</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="list">

                                 @if (count($my_tasks) == 0) 
                                    <tr>
                                        <td>No records available</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       
                                    </tr>
                                 @endif
                                @foreach ($my_tasks as $task)
                                    {{-- @dd(count($product_category->products))  --}}
                                    <tr>
                                        <td class="pr-2 pl-3">{{ $loop->iteration }}</td>
                                        <td class="pl-2">{{ Str::of($task->task_title)->limit(60)}}</td>
                                        <td>{{ $task->assigned_by->full_name }}</td>
                                        <td>{{ $task->assigned_to->full_name }}</td>
                                      
                                        <td>
                                           @if ($task->task_status == 1)
                                                <span class="badge badge-danger px-2">InComplete</span>
                                            @elseif ($task->task_status == 2)
                                                <span class="badge badge-warning px-2">InProgress</span>
                                            @elseif($task->task_status == 3)
                                                <span class="badge badge-success px-2">Completed</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span>
                                                <a href="{{ route('view_tasks',$task->id) }}" class="btn btn-sm btn-secondary" id="view_announcement">
                                                    <span class="p" style="font-size: 12px;">View</span>
                                                    <i class="ni ni-bold-right color-muted m-r-5"></i>
                                                </a>
                                                <a href="{{ route('forward_tasks',$task->id) }}" class="btn btn-sm btn-secondary" id="view_announcement">
                                                    <span class="p" style="font-size: 12px;">Forward</span>
                                                    <i class="ni ni-bold-right color-muted m-r-5"></i>
                                                </a>
                                                <a href="{{ route('editMy_tasks',$task->id)}}" class="btn btn-sm btn-secondary" id="edit_product_category">
                                                    <span class="p" style="font-size: 12px;">Edit</span>
                                                    <i class="fas fa-pencil-ruler color-muted m-r-5"></i>
                                                </a>
                                                @if (Auth::user()->id == $task->task_assigned_by)
                                                <a href="{{ route('delete_tasks',$task->id)}}" class="btn btn-sm btn-danger deleteProduct" id="deleteProduct">
                                                    <i class="fas fa-trash color-muted m-r-5"></i>
                                                </a>
                                                @endif 
                                            </span>
                                            
                                        </td>
                                       
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
</div>
@endsection







