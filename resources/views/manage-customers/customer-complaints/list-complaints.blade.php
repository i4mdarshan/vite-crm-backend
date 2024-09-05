@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')

{{-- @dd(request()->is('manage_leads/view/profile*')) --}}
<div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="m-1">
                <a href="{{ route('manage_customers') }}" class="btn btn-primary px-3">
                    <span class="text-secondary h3"><i class="ni ni-bold-left mr-2" style="font-size: 14px; vertical-align: middle;"></i>Manage Customers</span>
                </a>
            </div>
        </div>
    </div>
    
    @include('layouts.partials.customer-nav-menu')

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                {{-- <h1 class="m-3">Page Under Construction</h1> --}}
                <div class="d-flex justify-content-between card-header">
                    <h1 class="mb-0">Customer Complaints</h1>
                    <div>
                        @if ($module_access[0] == 1)
                            <a href="{{ route('addComplaints_customers', $customer_id) }}" class="btn btn-secondary float-right mx-1 my-2 my-md-0">
                                Add <i class="fas fa-plus-circle"></i></a>
                        @endif
                    </div>
                </div>
                <div class="card-body">

                            <div class="table-responsive" style="height: 60vh; overflow-y: auto">
                                <table class="table align-items-center">
                                    <thead class="thead-light"
                                        style="position: sticky; top:0;background-color: #f3f3f2;z-index: 999">
                                        <tr>
                                            <th class="pr-2 pl-3" scope="col"></th>
                                            {{-- <th scope="col">Firm</th> --}}
                                            <th class="pl-2" scope="col">Complaint raised by</th>
                                            <th scope="col">Complaint received by </th>
                                            <th scope="col">Date </th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                            
                                        @if (count($customer_complaints) == 0)
                                            <tr>
                                                <td>No records available</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endif
                                        @foreach ($customer_complaints as $customer_complaint)
                                            <tr>
                                                <td class="pr-2 pl-3">{{ $loop->iteration }}</td>
                                                <td class="pl-2">{{ ucwords($customer_complaint->contact ? $customer_complaint->contact->contact_person_name : 'NA') }}</td>
                                                <td>{{ ucwords($customer_complaint->employee ? $customer_complaint->employee->full_name : 'NA') }}</td>
                                                <td>{{ date('jS M, Y',strtotime($customer_complaint->created)) }}</td>
                                                <td>
                                                    {{-- @dd($customer_complaint->statuses) --}}
                                                    @if (count($customer_complaint->statuses) > 0)
                                                        @if ($customer_complaint->statuses->first()->status->name == 'in_progress')
                                                            <span class="badge badge-pill badge-danger">{{ ucwords(str_replace('_', ' ', $customer_complaint->statuses->first()->status->name)) }}</span>
                                                        @elseif ($customer_complaint->statuses->first()->status->name == 'awaiting_approval')
                                                            <span class="badge badge-pill badge-info">{{ ucwords(str_replace('_', ' ', $customer_complaint->statuses->first()->status->name)) }}</span>
                                                        @elseif ($customer_complaint->statuses->first()->status->name == 'closed')
                                                            <span class="badge badge-pill badge-success">{{ ucwords(str_replace('_', ' ', $customer_complaint->statuses->first()->status->name)) }}</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <span>
                                                        @if ($module_access[0] == 1 && $customer_complaint->statuses->first()->status->name != "closed")
                                                            <a href="{{ route('editComplaints_customers',['customer_id' => $customer_complaint->customer_id, 'complaint_id' => $customer_complaint->id]) }}" class="btn btn-sm btn-secondary" 
                                                                data-toggle="tooltip">
                                                                <span class="p" style="font-size: 12px;">Edit</span>
                                                                <i class="fas fa-pencil-ruler"></i>
                                                            </a>
                                                        @endif
                                                            <a href="{{ route('viewComplaintDetails_customers',['customer_id' => $customer_id ,'complaint_id' => $customer_complaint->id]) }}"
                                                                class="btn btn-sm btn-secondary" id="view_complaint">
                                                                <span class="p" style="font-size: 12px;">
                                                                    @if ($customer_complaint->statuses->first()->status->name == "closed")
                                                                        View
                                                                    @else
                                                                        Status
                                                                    @endif
                                                                </span>
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
            </div>
        </div>
    </div>
</div>
@endsection
