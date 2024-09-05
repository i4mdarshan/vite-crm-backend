@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')

    <div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ route('manage_customers') }}" class="btn btn-primary px-3">
                        <span class="text-secondary h3"><i class="ni ni-bold-left mr-2"
                                style="font-size: 14px; vertical-align: middle;"></i>Manage Customers</span>
                    </a>
                </div>
            </div>
        </div>

        @include('layouts.partials.customer-nav-menu')

        <div class="row">
            <div class="col-md-12" style="max-height: 180vh;">
                <div class="my-3">
                    <div class="accordion" id="accordionExample">
                        <div class="card previous-history-accordion">
                            <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseOne"
                                aria-expanded="false">
                                <span class="title p font-weight-bold pl-3">Previous Appointments History</span>
                                <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                            </div>
                            <div id="collapseOne" class="collapse" data-parent="#accordionExample">
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

                                            @if (count($customer_appointments->where('isLead',1)) == 0)
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
                                            @foreach ($customer_appointments as $key => $customer_appointment)
                                                @if ($customer_appointment->isLead == 1)
                                                    <tr>
                                                        <td class="pr-2 pl-3">{{ $customer_appointments->firstItem() + $key }}</td>
                                                        <td class="pl-2">{{ date('d-m-Y', strtotime($customer_appointment->appointment_date)) }}
                                                        </td>
                                                        <td>{{ $customer_appointment->appointment_time }}</td>
                                                        <td>{{ ucwords($customer_appointment->addedBy->full_name) }}</td>
                                                        <td>{{ ucwords($customer_appointment->appointmentWith->contact_person_name) }}</td>
                                                        <td style="white-space: nowrap;
                                                        max-width: 100px;
                                                            overflow: hidden;
                                                            text-overflow: ellipsis;"
                                                        >{{ $customer_appointment->appointment_description }}</td>
                                                        <td>
                                                            <span>
                                                                <a href="{{ route('viewAppointmentDetails_customers', ['customer_id' => $customer_id, 'appointment_id' => $customer_appointment->id]) }}"
                                                                    class="btn btn-sm btn-secondary" id="view_customer">
                                                                    <span class="p"
                                                                        style="font-size: 12px;">View</span>
                                                                    <i class="ni ni-bold-right"></i>
                                                                </a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @else
                                                    @continue
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <h1 class="mb-0">Customer Appointments</h1>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                @if ($module_access[0] == 1)
                                    <a href="{{ route('addAppointment_customers', $customer_id) }}"
                                        class="btn btn-secondary float-right mx-1 my-2 my-md-0">
                                        Add <i class="fas fa-plus-circle"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                {{-- Search Form --}}
                                <form action="{{ route('searchAppointments_customers', $customer_id) }}"
                                    class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto" method="GET">
                                    <div class="form-group mb-0">
                                        <div class="input-group input-group-alternative">
                                            <input class="form-control" placeholder="Search By Appointment with...."
                                                name="q" type="text" autocomplete="off">
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

                                    @if (count($customer_appointments->where('isLead',0)) == 0)
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
                                    @foreach ($customer_appointments as $key => $customer_appointment)
                                        @if ($customer_appointment->isLead == 0)
                                            <tr>
                                                <td class="pr-2 pl-3">{{ $customer_appointments->firstItem() + $key }}</td>
                                                <td class="pl-2">{{ date("jS M, Y", strtotime($customer_appointment->appointment_date)) }}
                                                </td>
                                                <td>{{ $customer_appointment->appointment_time }}</td>
                                                <td>{{ ucwords($customer_appointment->addedBy->full_name) }}</td>
                                                <td>{{ ucwords($customer_appointment->appointmentWith->contact_person_name) }}</td>
                                                <td style="white-space: nowrap;
                                                max-width: 100px;
                                                    overflow: hidden;
                                                    text-overflow: ellipsis;">{{ $customer_appointment->appointment_description }}</td>
                                                <td>
                                                    <span>
                                                        <a href="{{ route('viewAppointmentDetails_customers', ['customer_id' => $customer_id, 'appointment_id' => $customer_appointment->id]) }}"
                                                            class="btn btn-sm btn-secondary" id="view_customer">
                                                            <span class="p"
                                                                style="font-size: 12px;">View</span>
                                                            <i class="ni ni-bold-right"></i>
                                                        </a>
                                                    </span>
                                                </td>
                                            </tr>
                                        @else
                                            @continue
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer py-4">
                        <nav aria-label="...">
                            {{ $customer_appointments->links('layouts.partials.pagination-links') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

