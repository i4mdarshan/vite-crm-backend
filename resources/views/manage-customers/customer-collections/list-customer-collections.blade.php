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
        <div class="col-md-12" style="max-height: 180vh;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <h1 class="mb-0">Customer Collections</h1>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            @if ($module_access[0] == 1)
                                <a href="{{ route('addCollections_customers', $customer_id) }}" class="btn btn-secondary float-right mx-1 my-2 my-md-0">Add <i class="fas fa-plus-circle"></i></a>
                            @endif
                        </div>
                    </div> 
                    <div class="row mt-3">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            {{-- Search Form --}}
                            <form action="{{ route('searchCollections_customers', $customer_id) }}" class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto" method="GET">
                                <div class="form-group mb-0">
                                    <div class="input-group input-group-alternative">
                                        <input class="form-control" placeholder="Search By Name...." name="q" type="text" autocomplete="off">
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
                                            <th class="pr-2 pl-3" scope="col"></th>
                                            <th class="pl-2" scope="col">Collected By</th>
                                            <th scope="col">Collected From</th>
                                            <th scope="col">Money Received</th>
                                            <th scope="col">Received Date</th>
                                            <th scope="col">Money Pending</th>
                                            <th scope="col">Pending Date</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @if (count($customer_collection_details) == 0)
                                            <tr>
                                                <td>No records available</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endif
                                        @foreach ($customer_collection_details as $key=>$customer_collection)
                                            <tr>
                                                <td class="pr-2 pl-3" >{{ $customer_collection_details->firstItem() + $key }}</td>
                                                <td class="pl-2">{{ ucwords($customer_collection->collected_by_person_name) }}</td>
                                                <td>{{ ucwords($customer_collection->raised_by->contact_person_name) }}</td>
                                                <td>Rs. {{ number_format($customer_collection->money_received) }} /-</td>
                                                <td>{{ date("jS M, Y",strtotime($customer_collection->money_received_date)) }}</td>
                                                <td>Rs. {{ number_format($customer_collection->money_pending) }} /-</td>
                                                <td>{{ (!is_null($customer_collection->money_pending_date)) ? date("jS M, Y",strtotime($customer_collection->money_pending_date)) : 'NA' }}</td>
                                                <td>
                                                    @if ($customer_collection->status == "received")
                                                        <span class="badge badge-success px-2">Recieved</span>
                                                    @else
                                                        <span class="badge badge-danger px-2">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span>
                                                        @if ($module_access[0] == 1)
                                                            <a href="{{ route('editCollection_customers',['customer_id' => $customer_id ,'collection_id' => $customer_collection->id]) }}" class="btn btn-sm btn-secondary">
                                                                <span class="p" style="font-size: 12px;">Edit</span>
                                                                <i class="fas fa-pencil-ruler"></i>
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('viewCollectionDetails_customers',['customer_id' => $customer_id ,'collection_id' => $customer_collection->id]) }}"
                                                            class="btn btn-sm btn-secondary" id="view_customer">
                                                            <span class="p" style="font-size: 12px;">View</span>
                                                            <i class="ni ni-bold-right"></i>
                                                        </a>
                                                        @if (Auth::user()->role_id == config('constants.director_role_id'))
                                                            <a href="{{ route('deleteCollection_customers',['collection_id' => $customer_collection->id,'customer_id' => $customer_id]) }}" class="btn btn-sm btn-danger deleteCollection" id="deleteCollection{{$customer_collection->id}}" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
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
                        {{ $customer_collection_details->links('layouts.partials.pagination-links') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.deleteCollection').on('click', function(e){
                
                if(!confirm("Are you sure you want to delete ?")){
                    e.preventDefault();
                }
            });
        });
    </script>
    
@endsection

