@extends('layouts.app')

@section('title', 'Manage Leads')

@section('content')

{{-- @dd(request()->is('manage_leads/view/profile*')) --}}
<div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="m-1">
                <a href="{{ route('manage_leads') }}" class="btn btn-primary px-3">
                    <span class="text-secondary h3"><i class="ni ni-bold-left mr-2" style="font-size: 14px; vertical-align: middle;"></i>Manage Leads</span>
                </a>
            </div>
        </div>
    </div>
    
    @include('layouts.partials.lead-nav-menu')

    <div class="row">
        <div class="col-md-12" style="max-height: 180vh;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <h1 class="mb-0">Lead Appointments</h1>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            @if ($module_access[0] == 1)
                                <a href="{{ route('addAppointment_leads', $lead_id) }}" class="btn btn-secondary float-right mx-1 my-2 my-md-0">
                                    Add <i class="fas fa-plus-circle"></i></a>
                            @endif
                        </div>
                    </div> 
                    <div class="row mt-3">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            {{-- Search Form --}}
                            <form action="{{ route('searchAppointments_leads', $lead_id) }}" class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto" method="GET">
                                <div class="form-group mb-0">
                                    <div class="input-group input-group-alternative">
                                        <input class="form-control" placeholder="Search By Appointment with , Time...." name="q" type="text" autocomplete="off">
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
                                    <thead class="thead-light"
                                        style="position: sticky; top:0;background-color: #f3f3f2;z-index: 999">
                                        <tr>
                                            <th class="pr-2 pl-3" scope="col" style="width:5%;"></th>
                                            <th class="pl-2" scope="col" style="width:10%;">Date</th>
                                            <th scope="col" style="width:10%;">Time</th>
                                            <th scope="col" style="width:15%;">Added By</th>
                                            <th scope="col" style="width:15%;">Appointment With</th>
                                            <th scope="col" style="width:35%;">Description</th>
                                            <th scope="col" style="width:10%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                            
                                        @if (count($lead_appointments) == 0)
                                            <tr>
                                                <td>No records available</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endif
                                        @foreach ($lead_appointments as $key=>$lead_appointment)
                                            <tr>
                                                <td class="pr-2 pl-3">{{ $lead_appointments->firstItem() + $key }}</td>
                                                <td class="pl-2">{{ date("jS M, Y",strtotime($lead_appointment->appointment_date)) }}</td>
                                                <td>{{ ($lead_appointment->appointment_time) }}</td>
                                                <td>{{ ucwords($lead_appointment->addedBy->full_name) }}</td>
                                                <td>{{ ucwords($lead_appointment->appointmentWith->contact_person_name) }}</td>
                                                <td style="white-space: nowrap;
                                                        max-width: 100px;
                                                            overflow: hidden;
                                                            text-overflow: ellipsis;"
                                                        >{{ $lead_appointment->appointment_description }}</td>
                                                <td>
                                                    <span>
                                                        <a href="{{ route('viewAppointmentDetails_leads',['lead_id' => $lead_id ,'appointment_id' => $lead_appointment->id]) }}"
                                                            class="btn btn-sm btn-secondary" id="view_lead">
                                                            <span class="p" style="font-size: 12px;">View</span>
                                                            <i class="ni ni-bold-right"></i>
                                                        </a>
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
                        {{ $lead_appointments->links('layouts.partials.pagination-links') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_scripts')

    <script type="text/javascript">
        $(document).ready(function(){
            $('.lead-menu').slick({
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
                },
                {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
                },
                {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
            });
        });
    </script>
    
@endsection
