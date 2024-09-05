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
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header border">
                        <h1 class="mb-0">Employee Details</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 border-right">
                                {{-- @foreach($employee_info->user_detail->revisionHistory as $history )
                                    <p class="history">
                                        {{ $history->created_at->diffForHumans() }}, {{ $history->userResponsible()->full_name }} changed <strong>{{ ucwords(str_replace('_',' ',$history->fieldName())) }}</strong> from <code>{{ $history->oldValue() }}</code> to <code>{{ $history->newValue() }}</code>
                                    </p>
                                @endforeach --}}
                                {{-- <img src="{{ asset('uploads/users/profile_images/sample1.png') }}" height="250px" class="rounded-circle"> --}}
                                <div class="text-center m-3">
                                    
                                    @if (!is_null($employee_info->user_detail->employee_image) &&File::exists('uploads/users/profile_images/'.$employee_info->user_detail->employee_image))
                                        <img class="rounded-circle-image img-fluid"
                                        src="{{ asset('uploads/users/profile_images/'.$employee_info->user_detail->employee_image) }}" height="250px">
                                    @else
                                        <img class="rounded-circle-image img-fluid"
                                        src="{{ asset('uploads/users/default_user.png') }}" height="250px">
                                    @endif

                                    
                                    <h2 class="mt-3"><strong>{{ $employee_info->full_name }}</strong></h2>
                                    <span
                                        class="badge badge-pill badge-lg badge-info">{{ ucwords($employee_info->role_detail->role_name) }}</span>
                                </div>
                                <div class="mt-5 m-2">
                                    <h4><strong>Email : </strong>{{ $employee_info->email }}</h4>
                                    <h4><strong>Added By : </strong>{{ $employee_info->parent_employee->full_name }}</h4>
                                    <h4><strong>Firm : </strong>{{ ($employee_info->firm) ? ucwords($employee_info->firm->firm_name) : "NA" }}</h4>
                                    <h4><strong>Status : </strong> {{ $employee_info->isActive == 1 ? 'Active' : 'Inactive' }}</h4>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="m-1 mt-3 mb-5">
                                    <h2 class="mb-3"><strong>Personal Details</strong></h2>
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Full Name</span>
                                                    <h3 class="m-0 p-0"><b>{{ $employee_info->full_name }}</b></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Email</span>
                                                    <h3 class="m-0 p-0"><b>{{ $employee_info->email }}</b></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Personal Phone No. 1</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $employee_info->user_detail->personal_phone_no_1 }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Personal Phone No. 2</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $employee_info->user_detail->personal_phone_no_2 ? $employee_info->user_detail->personal_phone_no_2 : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-12 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Current Address</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $employee_info->user_detail->current_address }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-12 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Permanent Address</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $employee_info->user_detail->permanent_address }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-1 mt-3 mb-5">
                                    <h2 class="mb-3"><strong>Joining Details</strong></h2>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Joining Date</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ date("jS F, Y", strtotime($employee_info->user_detail->date_of_joining)) }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Joining Letter</span>
                                                    <h3 class="m-0 p-0"><b>
                                                            @if (!is_null($employee_info->user_detail->joining_letter) && File::exists('uploads/users/joining_letters/'.$employee_info->user_detail->joining_letter))
                                                                <a class="btn btn-sm btn-primary" target="_blank"
                                                                    href="{{ asset('uploads/users/joining_letters/' . $employee_info->user_detail->joining_letter) }}">
                                                                    View Letter
                                                                </a>
                                                            @else
                                                                Not Uploaded
                                                            @endif
                                                            
                                                        </b></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Accessories</span>
                                                    <h3 class="m-0 p-0">
                                                        @if (!is_null($employee_info->user_detail->accessories) && File::exists('uploads/users/accessories/'.$employee_info->user_detail->accessories))
                                                                <a class="btn btn-sm btn-primary" target="_blank"
                                                                    href="{{ asset('uploads/users/accessories/' . $employee_info->user_detail->accessories) }}">
                                                                    View Letter
                                                                </a>
                                                            @else
                                                                Not Uploaded
                                                            @endif
                                                            
                                                        </b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-1 mt-3 mb-5">
                                    <h2 class="mb-3"><strong>Other Details</strong></h2>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Father's Phone No.</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $employee_info->user_detail->father_phone_no ? $employee_info->user_detail->father_phone_no : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Mother's Phone No.</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $employee_info->user_detail->mother_phone_no ? $employee_info->user_detail->mother_phone_no : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Wife's Phone No.</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $employee_info->user_detail->wife_phone_no ? $employee_info->user_detail->wife_phone_no : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Others Phone No.</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $employee_info->user_detail->others_phone_no ? $employee_info->user_detail->others_phone_no : 'NA' }}</b>
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
