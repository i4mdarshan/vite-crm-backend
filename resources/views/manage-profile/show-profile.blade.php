@extends('layouts.app')

@section('title', 'Manage Profile')

@section('content')
    <div>
        <!-- Header -->
        {{-- @dd($user_data) --}}
        <div class="header pb-8 pt-3 d-flex align-items-center" style="min-height: 100px;">
            <!-- Mask -->
            <span class="mask bg-gradient-default opacity-8"></span>
            <!-- Header container -->
            <div class="container-fluid d-flex align-items-center">
                <div class="row">
                    <div class="col-lg-12 col-md-10">
                        <h1 class="display-2 text-white">Hello {{ $user_data->full_name }}</h1>
                        {{-- <p class="text-white mt-0 mb-5">This is your profile page. You can see the progress you've made with your work and manage your projects or assigned tasks</p>
              <a href="#!" class="btn btn-info">Edit profile</a> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="m-3">
                                    @if (Auth::user()->user_detail->employee_image && file_exists(public_path('uploads/users/profile_images/'.Auth::user()->user_detail->employee_image))) 
                                        <img height="300px" width="100%" alt="Image placeholder" src="{{ asset('uploads/users/profile_images/'.Auth::user()->user_detail->employee_image) }}">
                                    @else
                                        <img height="300px" width="100%" alt="Image placeholder" src="{{ asset('uploads/users/default_user.png') }}">
                                    @endif
                                    {{-- <img height="300px" width="100%" src="{{ asset('uploads/users/default_user.png') }}"> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer pt-0 pt-md-4 text-center">
                            <h2>{{ ucwords($user_data->role_detail->role_name) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 order-xl-1">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">My account</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form>
                                <h6 class="heading-small text-muted mb-4 ml-4">User information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="full_name">Full name</label>
                                                <input type="text" id="full_name"
                                                    class="form-control form-control-alternative" placeholder="Full Name"
                                                    value="{{ $user_data->full_name }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-email">Email ID</label>
                                                <input type="email" id="input-email"
                                                    class="form-control form-control-alternative" placeholder="Email"
                                                    value="{{ $user_data->email }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4" />
                                <!-- Address -->
                                <h6 class="heading-small text-muted mb-4 ml-4">Contact information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-address">Address</label>
                                                <input type="text" id="address"
                                                    class="form-control form-control-alternative"
                                                    value="{{ $user_data->user_detail->current_address }}" placeholder="Address" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="phone_number">Mobile Number</label>
                                                <input type="text" id="phone_number"
                                                    class="form-control form-control-alternative"
                                                    placeholder="Mobile Number" value="{{ $user_data->user_detail->personal_phone_no_1 }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
