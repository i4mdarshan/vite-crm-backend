@extends('layouts.app')

@section('title', 'Manage Employees')

@section('content')
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <h1 class="mb-0">Employee List</h1>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                @if ($module_access[0] == 1)
                                    <a href="{{ route('add_employee') }}" class="btn btn-secondary float-right mx-1 my-2 my-md-0">
                                        Add <i class="fas fa-plus-circle"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-8">
                                <div class="mt-3">
                                    <h3>
                                        Total records: 
                                        <strong>
                                            {{ number_format($all_employees->total()) }}
                                        </strong>
                                    </h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                {{-- Search Form --}}
                                <form action="{{ route('search_employee') }}" class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto" method="GET">
                                    <div class="form-group mb-0">
                                        <div class="input-group input-group-alternative">
                                            <input class="form-control" placeholder="Search By Name, Role, Email, Added by..." name="q" type="text" autocomplete="off">
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
                        <div class="table-responsive" style="height: 95vh; overflow-y: auto">
                            <table class="table align-items-center">
                                <thead class="thead-light"
                                    style="position: sticky; top:0;background-color: #f3f3f2;z-index: 999">
                                    <tr>
                                        <th class="pr-2 pl-3" scope="col"></th>
                                        <th class="pl-2" scope="col">Firm</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Added By</th>
                                        <th scope="col">Joining</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list">

                                    @if (count($all_employees) == 0)
                                        <tr>
                                            <td>No records available</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    @foreach ($all_employees as $key=>$employee)
                                        <tr>
                                            <td class="pr-2 pl-3">{{ $all_employees->firstItem() + $key }}</td>
                                            <td class="pl-2">{{ ($employee->firm) ? ucwords($employee->firm->firm_name) : "NA" }}</td>
                                            <td>{{ $employee->full_name }}</td>
                                            {{-- @dd($employee->role_detail->role_name) --}}
                                            <td>{{ ucwords($employee->role_detail->role_name) }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>{{ isset($employee->parent_employee->full_name) ? $employee->parent_employee->full_name : 'N/A' }}
                                            </td>
                                            <td>{{ isset($employee->user_detail->date_of_joining)? date("jS M, Y", strtotime($employee->user_detail->date_of_joining)): 'N/A' }}
                                            </td>
                                            <td>
                                                @if ($employee->isActive == 1)
                                                    <span class="badge badge-success px-2">Active</span>
                                                @else
                                                    <span class="badge badge-danger px-2">InActive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span>
                                                    @if ($employee->role_id != 1)
                                                        <a href="{{ route('view_employee', $employee->id) }}"
                                                            class="btn btn-sm btn-secondary" id="view_employee" data-toggle="tooltip"
                                                            data-placement="top" title="View">
                                                            <span class="p" style="font-size: 12px;">View</span>
                                                            <i class="ni ni-bold-right"></i>
                                                        </a>
                                                        @if ($module_access[0] == 1)
                                                            <a href="{{ route('edit_employee', $employee->id) }}" class="btn btn-sm btn-secondary" id="edit_employee">
                                                                <span class="p" style="font-size: 12px;">Edit</span>
                                                                <i class="fas fa-pencil-ruler"></i>
                                                            </a>

                                                            @if ($employee->isActive)
                                                                <a href="{{ route('deactivate_employee', $employee->id) }}"
                                                                    class="btn btn-sm btn-danger" id="deactivate_employee" data-toggle="tooltip"
                                                                    data-placement="top" title="Deactivate">
                                                                    <span class="p" style="font-size: 12px;">Deactivate</span>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('deactivate_employee', $employee->id) }}"
                                                                    class="btn btn-sm btn-success" id="deactivate_employee" data-toggle="tooltip"
                                                                    data-placement="top" title="Activate">
                                                                    <span class="p" style="font-size: 12px;">Activate</span>
                                                                </a>
                                                            @endif

                                                           
                                                        @endif
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer py-4">
                        <nav aria-label="...">
                            {{ $all_employees->links('layouts.partials.pagination-links') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_scripts')


@endsection
