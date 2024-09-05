@extends('layouts.app')

@section('title', 'Manage Employees')

@section('content')
    <div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ route('manage_employee') }}" class="btn btn-primary px-3">
                        <span class="text-secondary h3"><i class="ni ni-bold-left mr-2"
                                style="font-size: 14px; vertical-align: middle;"></i>Manage Employees</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <h1 class="mb-0">Edit Employee</h1>
                    </div>
                    <form action="{{ route('update_employee', $employee_details->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="m-3">
                            <div class="row mx-4">
                                <div class="alert alert-warning mb-3 py-3 px-0 w-100" role="alert">
                                    <ul class="mt-0 mb-0">
                                        <li>The <strong>Added By</strong> form field can only be edited if their are
                                            <strong>NO LEADS</strong> and <strong>NO CUSTOMERS</strong> under the Employee.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row mx-2">
                                <div class="col-md-6">
                                    <h2 class="mb-3">Basic Details</h2>
                                    <div class="form-group">
                                        <label for="full_name">Enter Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="full_name"
                                            class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                                            value="{{ old('full_name', $employee_details->full_name) }}" maxlength="40"
                                            placeholder="Enter Full Name">
                                        @error('full_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="user_role">Employee Role <span class="text-danger">*</span></label>
                                        <select class="form-control @error('user_role') is-invalid @enderror"
                                            name="user_role" id="user_role">
                                            <option value="">Choose Role</option>
                                            @foreach ($all_active_roles as $role)
                                                @if (!($role->id == Auth::user()->role_id) && $role->id != 1)
                                                    <option value="{{ $role->id }}"
                                                        {{ old('user_role', $employee_details->role_id) == $role->id ? 'selected' : '' }}>
                                                        {{ ucwords($role->role_name) }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('user_role')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @if (Auth::user()->role_id == config('constants.director_role_id'))
                                        <div class="form-group">
                                            <label for="user_firm">Employee Firm <span class="text-danger">*</span></label>
                                            <select class="form-control @error('user_firm') is-invalid @enderror"
                                                name="user_firm" id="user_firm">
                                                <option value="">Choose Firm</option>
                                                @foreach ($firms as $firm)
                                                    <option value="{{ $firm->id }}"
                                                        {{ old('user_firm', $employee_details->firm_id) == $firm->id ? 'selected' : '' }}>
                                                        {{ ucwords($firm->firm_name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('user_firm')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label for="user_firm">Employee Firm <span class="text-danger">*</span></label>
                                            <select class="form-control @error('user_firm') is-invalid @enderror"
                                                name="user_firm" id="user_firm">
                                                <option value="{{ Auth::user()->firm->id }}">
                                                    {{ ucwords(Auth::user()->firm->firm_name) }}</option>
                                            </select>
                                            @error('user_firm')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @endif
                                    {{-- @dd($employee_details->get_leads_customers($employee_details->id)) --}}
                                    @if ($employee_details->get_leads_customers_count($employee_details->id) == 0)
                                        @if (Auth::user()->role_id == config('constants.director_role_id'))
                                            <div class="form-group">
                                                <label for="added_by">Added By <span class="text-danger">*</span></label>
                                                <select class="form-control @error('added_by') is-invalid @enderror"
                                                    name="added_by" id="added_by">
                                                    <option value="">Choose Employee</option>
                                                    @foreach ($all_employees as $employee)
                                                        <option value="{{ $employee->id }}"
                                                            {{ $employee->id == $employee_details->added_by ? 'selected' : '' }}>
                                                            {{ $employee->full_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('added_by')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label for="added_by">Added By <span class="text-danger">*</span></label>
                                                <select class="form-control @error('added_by') is-invalid @enderror"
                                                    name="added_by" id="added_by">
                                                    <option value="{{ Auth::user()->id }}"
                                                        {{ Auth::user()->id == $employee_details->added_by ? 'selected' : '' }}>
                                                        {{ Auth::user()->full_name }} 
                                                    </option>
                                                </select>
                                                @error('added_by')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @endif
                                    @else
                                        <div class="form-group">
                                            <label for="added_by">Added By <span class="text-danger">*</span></label>
                                            <select class="form-control @error('added_by') is-invalid @enderror"
                                                name="added_by" id="added_by" readonly>
                                                <option value="{{ $employee_details->added_by }}">
                                                    {{ $employee_details->parent_employee->full_name }}
                                                </option>
                                            </select>
                                            @error('added_by')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="profile_image">Profile Image <small>(File size should be less than
                                                2Mb)</small></label>
                                        <input type="file" name="profile_image" accept=".jpg, .jpeg, .png"
                                            class="form-control @error('profile_image') is-invalid @enderror"
                                            id="profile_image" value="{{ old('profile_image') }}" />
                                        @error('profile_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="m-3">
                                            @if (
                                                !is_null($employee_details->user_detail->employee_image) &&
                                                    File::exists('uploads/users/profile_images/' . $employee_details->user_detail->employee_image))
                                                <img class="rounded-circle-image img-fluid"
                                                    src="{{ asset('uploads/users/profile_images/' . $employee_details->user_detail->employee_image) }}"
                                                    height="250px">
                                            @else
                                                <img class="rounded-circle-image img-fluid"
                                                    src="{{ asset('uploads/users/default_user.png') }}" height="250px">
                                            @endif
                                        </div>
                                    </div>
                                    <h2 class="my-3">Login Details</h2>
                                    <div class="form-group">
                                        <label for="email">Enter Email Id <span class="text-danger">*</span></label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            value="{{ old('email', $employee_details->email) }}" maxlength="50"
                                            placeholder="Enter Email Id">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <label for="password">Password </label>
                                    <div class="input-group mb-3">
                                        <input type="password" name="password"
                                            class="form-control  @error('password') is-invalid @enderror" id="password"
                                            value="{{ old('password') }}" minilength="6" placeholder="Enter Password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button" id="toggle-password">
                                                <i class="fas fa-eye" id="show_password_icon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <label for="password_confirmation">Confirm Password </label>
                                    <div class="input-group mb-3">
                                        <input type="password" name="password_confirmation"
                                            class="form-control  @error('password_confirmation') is-invalid @enderror"
                                            id="password_confirmation" value="{{ old('password_confirmation') }}"
                                            minlength="6" placeholder="Enter Password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button"
                                                id="toggle-confirm-password">
                                                <i class="fas fa-eye" id="show_password_confirmation_icon"></i>
                                            </button>
                                        </div>
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h2 class="mb-3">Contact Details</h2>
                                    <div class="row m-0">
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="0">Enter Personal Number 1 <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="personal_phone_no_1"
                                                    class="form-control @error('personal_phone_no_1') is-invalid @enderror"
                                                    id="personal_phone_no_1"
                                                    value="{{ old('personal_phone_no_1', $employee_details->user_detail->personal_phone_no_1) }}"
                                                    placeholder="Enter Personal Number 1">
                                                @error('personal_phone_no_1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="personal_phone_no_2">Enter Personal Number 2</label>
                                                <input type="number" name="personal_phone_no_2"
                                                    class="form-control @error('personal_phone_no_2') is-invalid @enderror"
                                                    id="personal_phone_no_2"
                                                    value="{{ old('personal_phone_no_2', $employee_details->user_detail->personal_phone_no_2) }}"
                                                    placeholder="Enter Personal Number 2">
                                                @error('personal_phone_no_2')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-0">
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="father_phone_no">Enter Father's Number</label>
                                                <input type="number" name="father_phone_no"
                                                    class="form-control @error('father_phone_no') is-invalid @enderror"
                                                    id="father_phone_no"
                                                    value="{{ old('father_phone_no', $employee_details->user_detail->father_phone_no) }}"
                                                    placeholder="Enter Father's Number">
                                                @error('father_phone_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="mother_phone_no">Enter Mother's Number</label>
                                                <input type="number" name="mother_phone_no"
                                                    class="form-control @error('mother_phone_no') is-invalid @enderror"
                                                    id="mother_phone_no"
                                                    value="{{ old('mother_phone_no', $employee_details->user_detail->mother_phone_no) }}"
                                                    placeholder="Enter Mother's Number">
                                                @error('mother_phone_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-0">
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="wife_phone_no">Enter Wife's Number</label>
                                                <input type="number" name="wife_phone_no"
                                                    class="form-control @error('wife_phone_no') is-invalid @enderror"
                                                    id="wife_phone_no"
                                                    value="{{ old('wife_phone_no', $employee_details->user_detail->wife_phone_no) }}"
                                                    placeholder="Enter Wife's Number">
                                                @error('wife_phone_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label for="others_phone_no">Enter Other Number</label>
                                                <input type="number" name="others_phone_no"
                                                    class="form-control @error('others_phone_no') is-invalid @enderror"
                                                    id="others_phone_no"
                                                    value="{{ old('others_phone_no', $employee_details->user_detail->others_phone_no) }}"
                                                    placeholder="Enter Other Number">
                                                @error('others_phone_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-0 mb-1">
                                        <div class="col-md-12 px-1">
                                            <div class="form-group">
                                                <label for="current_address">Enter Current Address <span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control @error('current_address') is-invalid @enderror" name="current_address"
                                                    id="current_address" rows="5" maxlength="150" placeholder="Enter Current Address">{{ old('current_address', $employee_details->user_detail->current_address) }}</textarea>
                                                @error('current_address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="permanent_address">Enter Permanent Address <span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control @error('permanent_address') is-invalid @enderror" name="permanent_address"
                                                    id="permanent_address" rows="5" maxlength="150" placeholder="Enter Permanent Address">{{ old('permanent_address', $employee_details->user_detail->permanent_address) }}</textarea>
                                                @error('permanent_address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <h2 class="">Joining Details</h2>
                                    <div class="form-group">
                                        <label for="joining_date">Enter Joining Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" max="{{ date('Y-m-d') }}" name="joining_date"
                                            class="form-control @error('joining_date') is-invalid @enderror"
                                            id="joining_date"
                                            value="{{ old('joining_date', date('Y-m-d', strtotime($employee_details->user_detail->date_of_joining))) }}"
                                            placeholder="Enter Joining Date">
                                        @error('joining_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="joining_letter">Joining Letter <small> (File size should be less than
                                                2Mb)</small></label>
                                        <input type="file" name="joining_letter"
                                            accept=".jpg, .jpeg, .png, .pdf, docx"
                                            class="form-control @error('joining_letter') is-invalid @enderror"
                                            id="joining_letter"
                                            value="{{ old('joining_letter', $employee_details->joining_letter) }}" />
                                        @error('joining_letter')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @if (
                                            !is_null($employee_details->user_detail->joining_letter) &&
                                                File::exists('uploads/users/joining_letters/' . $employee_details->user_detail->joining_letter))
                                            <a class="btn btn-sm btn-primary my-3" target="_blank"
                                                href="{{ asset('uploads/users/joining_letters/' . $employee_details->user_detail->joining_letter) }}">
                                                View Letter </a>
                                        @else
                                            <strong>Not Uploaded</strong>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="accessories">Accessories <small> (File size should be less than
                                                2Mb)</small></label>
                                        <input type="file" name="accessories" accept=".jpg, .jpeg, .png, .pdf, docx"
                                            class="form-control @error('accessories') is-invalid @enderror"
                                            id="accessories"
                                            value="{{ old('accessories', $employee_details->accessories) }}" />
                                        @error('accessories')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @if (
                                            !is_null($employee_details->user_detail->accessories) &&
                                                File::exists('uploads/users/accessories/' . $employee_details->user_detail->accessories))
                                            <a class="btn btn-sm btn-primary my-3" target="_blank"
                                                href="{{ asset('uploads/users/accessories/' . $employee_details->user_detail->accessories) }}">
                                                View Accessories </a>
                                        @else
                                            <strong>Not Uploaded</strong>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom_scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $("body").on('click', '#toggle-password', function() {

                $("#show_password_icon").toggleClass("fa-eye fa-eye-slash");
                var input = $("#password");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }

            });

            $("body").on('click', '#toggle-confirm-password', function() {

                $("#show_password_confirmation_icon").toggleClass("fa-eye fa-eye-slash");
                var input = $("#password_confirmation");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }

            });
        });
    </script>

@endsection
