@extends('layouts.app')

@section('title', 'Manage Roles')

{{-- @dd($role_details) --}}

@section('content')
    <div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <h1 class="mb-0">Update Role</h1>
                    </div>
                    <div class="m-3">
                        <form action="{{ route('update_roles', $role_details->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="role_name">Enter Role Name</label>
                                <input type="text" name="role_name"
                                    value="{{ old('role_name', $role_details->role_name) }}"
                                    class="form-control @error('role_name') is-invalid @enderror " id="role_name"
                                    maxlength="40" placeholder="Enter Role Name">
                                @error('role_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="role_status">Role Status</label>
                                <select class="form-control @error('role_name') is-invalid @enderror" name="role_status"
                                    id="role_status" required>
                                    <option value="">Choose Status</option>
                                    <option value="1"
                                        {{ old('role_status', $role_details->isActive) == 1 ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0"
                                        {{ old('role_status', $role_details->isActive) == 0 ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                @if ($errors->has('role_status'))
                                    <span class="invalid-feedback" role="alert" style="display: block !important">
                                        <strong>{{ $errors->first('role_status') }}</strong>
                                    </span>
                                @endif
                            </div>
                    </div>
                    <div class="card-footer border-0">
                        <button id="addRole" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <h1 class="mb-0">Grant Permissions</h1>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Check to Add</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Permissions</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- @dd($role_details->modules) --}}
                                @foreach ($active_modules as $active_module)
                                    @if ($active_module->id == config('constants.manage_roles'))
                                        @continue
                                    @endif
                                    @php
                                        $selectedModuleCheck = false;
                                        if (in_array($active_module->id, $selected_module_ids)) {
                                            $selectedModuleCheck = true;
                                            $position = array_search($active_module->id, $selected_module_ids);
                                        } else {
                                            $selectedModuleCheck = false;
                                        }
                                        // var_dump($position)
                                        // die;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                    class="custom-control-input @error('module_id') is-invalid @enderror"
                                                    name="module_id[]" value="{{ $active_module->id }}"
                                                    id="{{ $active_module->id }}"
                                                    {{ old('module_id', $selectedModuleCheck) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="{{ $active_module->id }}"></label>
                                            </div>
                                        </td>
                                        <td scope="row">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <span class="mb-0 text-sm">{{ $active_module->module_name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select
                                                    class="form-control @error('module_permission') is-invalid @enderror"
                                                    name="module_permission[]"
                                                    id="module_permission{{ $active_module->id }}" required
                                                    {{ $selectedModuleCheck ? '' : 'disabled' }}>
                                                    <option value="">Choose permission</option>
                                                    {{-- @dd($position) --}}
                                                    <option value="0"
                                                        {{ isset($position) && $selected_module_ids_modify_access[$position] == 0 && $selectedModuleCheck ? 'selected' : '' }}>
                                                        Read Only</option>
                                                    <option value="1"
                                                        {{ isset($position) && $selected_module_ids_modify_access[$position] == 1 && $selectedModuleCheck ? 'selected' : '' }}>
                                                        Full Access</option>
                                                </select>
                                                @error('module_permission')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                @if ($errors->has('module_permission.' . $loop->index))
                                                    <span class="invalid-feedback" role="alert"
                                                        style="display: block !important">
                                                        <strong>{{ $errors->first('module_permission.' . $loop->index) }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom_scripts')

    <script>
        $(document).ready(function() {
            $("input[type='checkbox']").on('change', function() {
                $('#module_permission' + this.value).attr('disabled', !this.checked)
            });

        })
    </script>

@endsection
