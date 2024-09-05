@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mt-2">
        <div class="mb-2">
            <div class="col-sm-6">
                <h3 class="mb-2 mx-2 my-2 user-info-head">Quick Links</h3>
            </div><!-- /.col -->
        </div>
        {{-- Quick Action buttons --}}
        <div id="quick_action_buttons_html"></div>
        {{-- Auick action buttons end --}}

        <div class="row mb-2 mt-5">
            <div class="col-sm-6">
                <h3 class="mb-2 mx-2 my-2 user-info-head">Personal Details</h3>
            </div><!-- /.col -->
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 col-md-6 mx-3 d-flex">
                <div>
                    <div class="display-block">
                        <img class="circular-img" src="{{ asset('uploads/users/default_user.png') }}">
                    </div>
                </div>
                <div class="display-block my-4 mx-2 mb-3">
                    <div class="per-name-head">{{ ucwords(Auth::user()->full_name) }}</div>
                    {{-- <button class="per-edit-button mx-1"> <span class="per-btn-style"></span>EDIT</button> --}}
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="card dash-contact-info mt-4 mx-3">
            <span class="my-2 mx-3 per-con-head"> <i class="fas fa-info-circle mx-2"></i>Contact details</span>
            <div class="my-2 ">
                <div class="row mb-2">
                    <span class="col-12 col-sm-6 col-md-3 mx-3 mb-1 "> <i
                            class="fas fa-envelope mx-2"></i>{{ Auth::user()->email }}</span>
                    <span class="col-12 col-sm-6 col-md-3 mx-3"><i class="fas fa-phone-volume mx-2"></i>+91
                        9969697892</span>
                </div>

            </div>
        </div>
        <div class="row mt-5">
            {{-- <div class="col-xl-6 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0 user-info-head">Basic Details</h3>
                                <div class="mt-4 cl-log">
                                    <h4>Date of Joining :- <span
                                            class="mx-3">{{ date('d-m-Y', strtotime(Auth::user()->created)) }}</span>
                                    </h4>
                                </div>
                                <div class="mt-4 cl-log">
                                    <h4>Role :- <span
                                            class="mx-3">{{ ucwords(Auth::user()->role_detail->role_name) }}</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> --}}
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0 user-info-head">Announcements</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body announcements-div my-3 mr-3" style="height:200px; overflow:auto;">
                        <ul class="data-list" id="announcement_list_div" style="list-style:disc; position:relative;">

                            @foreach ($all_announcements as $announcement)
                                <li>
                                    <a href="{{ route('view_announcement',$announcement->id) }}">
                                        <h3> {{ date("jS M,Y", strtotime($announcement->start_date)) }} - {{ date("jS M,Y", strtotime($announcement->end_date)) }} </h3>
                                        <p style="text-align:left; padding:10px; overflow:hidden; text-overflow:ellipsis;white-space: nowrap;">{{ $announcement->announcement_title }}</p>
                                    </a>  
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- Footer -->

    </div>
@endsection

