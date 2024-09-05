@extends('layouts.app')

@section('title', 'Manage Roles')

@section('content')
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="d-flex justify-content-between card-header border-0">
                        <h1 class="mb-0">Manage Roles</h1>
                        @if ($module_access[0] == 1)
                            <a href="{{ route('add_roles') }}" class="btn btn-secondary float-right mx-1 my-2 my-md-0"> 
                                Add <i class="fas fa-plus-circle"></i></a>
                        @endif
                    </div>
                    <div class="mt-1 mx-3 px-2">
                        <h3>
                            Total records: 
                            <strong>
                                {{ number_format($all_roles->count()) }}
                            </strong>
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Sr No.</th>
                                    <th scope="col">Role Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Module Access</th>
                                    @if ($module_access[0] == 1)
                                        <th scope="col">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="list">

                                @if (count($all_roles) == 0)

                                    <tr>
                                        <td>No records available</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                @else

                                    @foreach ($all_roles as $role)

                                        @if ( in_array($role->id,config('constants.default_system_roles')) && Auth::user()->id != 1)
                                            @continue
                                        @endif
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>

                                            <th scope="row">
                                                <div class="media align-items-center">
                                                    <div class="media-body">
                                                        <span
                                                            class="mb-0 text-sm">{{ ucwords($role->role_name) }}</span>
                                                    </div>
                                                </div>
                                            </th>

                                            <td>
                                                @if ($role->isActive == 1)
                                                    <span class="badge badge-success px-2">Active</span>
                                                @else
                                                    <span class="badge badge-danger px-2">InActive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach ($role_modules = $role->modules as $modules)
                                                    {{ $modules->module->module_name }}
                                                    @if ($modules->modify_access == 0)
                                                        - Read Only
                                                    @else
                                                        - Full Access
                                                    @endif<br>
                                                @endforeach
                                            </td>
                                            @if ($module_access[0] == 1)
                                                <td>
                                                    <span>
                                                        {{-- <a href="{{ route('edit_roles', $role->id) }}"
                                                            class="btn btn-primary" id="edit_product_category" title="Edit">
                                                            <i class="fas fa-pencil-ruler color-muted m-r-5"></i>
                                                        </a> --}}
                                                        @if ($role->id != config('constants.director_role_id'))
                                                            <a href="{{ route('edit_roles', $role->id) }}" class="btn btn-sm btn-secondary" id="edit_employee">
                                                                <span class="p" style="font-size: 12px;">Edit</span>
                                                                <i class="fas fa-pencil-ruler"></i>
                                                            </a>
                                                        @endif
                                                    </span>
                                                </td>
                                            @endif
                                        </tr>

                                    @endforeach

                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
