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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <h1 class="mb-0">Customer Orders</h1>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                @if ($module_access[0] == 1)
                                    <a href="{{ route('addOrder_customers', $customer_id) }}"
                                        class="btn btn-secondary float-right mx-1 my-2 my-md-0">Add <i class="fas fa-plus-circle"></i> </a>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                {{-- Search Form --}}
                                <form action="{{ route('searchOrder_customers', $customer_id) }}"
                                    class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto" method="GET">
                                    <div class="form-group mb-0">
                                        <div class="input-group input-group-alternative">
                                            <input class="form-control" placeholder="Search By Order no ..." name="q"
                                                type="text" autocomplete="off">
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
                                        <th class="pr-2 pl-3"></th>
                                        <th class="pl-2">Order no. </th>
                                        <th>Order date</th>
                                        <th>Total</th>
                                        <th>Added By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @if (count($all_orders) == 0)
                                        <tr>
                                            <td>No records available</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    @foreach ($all_orders as $key => $order_details)
                                        <tr>
                                            <td class="pr-2 pl-3">{{ $all_orders->firstItem() + $key }}</td>
                                            <td class="pl-2">{{ ucwords($order_details->order_no) }}</td>
                                            <td>{{ date("jS M, Y",strtotime($order_details->order_date)) }}</td>
                                            <td>Rs. {{ number_format(round(floatval($order_details->order_total),2)) }}/-</td>
                                            <td>{{ ucwords($order_details->employee->full_name) }}</td>
                                            <td>
                                                <span>
                                                    <a href="{{ route('deleteOrder_customers',["customer_id" => $customer_id,"order_id" => $order_details->id]) }}" class="btn btn-sm btn-danger deleteorder"
                                                        data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="fas fa-trash color-muted m-r-5"></i>
                                                    </a>
                                                    <a href="{{ route('viewOrderDetails_customers', ["customer_id" => $customer_id,"order_id" => $order_details->id]) }}"
                                                        class="btn btn-sm btn-secondary" id="view_order" data-toggle="tooltip"
                                                        data-placement="top" title="View">View
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
