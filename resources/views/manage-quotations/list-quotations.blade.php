@extends('layouts.app')

@section('title', 'Manage Quotations')

@section('content')
<div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <h1 class="mb-0">Sales Transactions List</h1>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            @if ($module_access[0] == 1)
                                <a href="{{ route('add_quotations') }}" class="btn btn-secondary float-right mx-1 my-2 my-md-0">
                                    Add <i class="fas fa-plus-circle"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="mt-3">
                                <h3>
                                    Total records: 
                                    <strong>
                                        {{ number_format($quotations->total()) }}
                                    </strong>
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {{-- Search Form --}}
                            <form action="{{ route('search_quotations') }}" class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto" method="GET">
                                <div class="form-group mb-0">
                                    <div class="input-group input-group-alternative">
                                        <input class="form-control" placeholder="Search By Transaction no, Type, Total..." name="q" type="text" autocomplete="off">
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
                        <table class="table align-items-center" >
                            <thead class="thead-light" style="position: sticky; top:0;background-color: #f3f3f2;z-index: 999">
                                <tr>
                                    <th class="pr-2 pl-3"></th>
                                    <th class="pl-2">Client Firm</th>
                                    {{-- <th>Transaction date</th> --}}
                                    <th>Type</th>
                                    <th>Total</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @if (count($quotations) == 0)
                                    <tr>
                                        <td>No records available</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        {{-- <td></td> --}}
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                                @foreach ($quotations as $key=>$quotation_details)
                                    <tr>
                                        <td class="pr-2 pl-3">{{ $quotations->firstItem() + $key }}</td>
                                        <td class="pl-2">
                                            {{-- {{ ucwords($quotation_details->quotation_no) }} --}}
                                            <h4 class="p-0 m-0">
                                                <span data-toggle="tooltip" data-placement="top" title="{{ ucwords(str_replace('_', ' ', $quotation_details->client_name)) }}">
                                                    {{ Str::limit(ucwords(str_replace('_', ' ', $quotation_details->client_name)), $limit = 40, $end = '...') }}
                                                </span>
                                                <br/>
                                                <small>
                                                    <i>
                                                        {{ ucwords($quotation_details->quotation_no) }}
                                                    </i>
                                                </small>
                                            </h4>
                                        </td>
                                        {{-- <td>{{ date("jS M, Y",strtotime($quotation_details->quotation_date)) }}</td> --}}
                                        <td>
                                            <h4 class="p-0 m-0">
                                                {{ ucwords(str_replace('_',' ',$quotation_details->quotation_type)) }}
                                            </h4>
                                        </td>
                                        <td>
                                            <h4 class="p-0 m-0">
                                                Rs. {{ number_format(round(floatval($quotation_details->quotation_total),2)) }}/-</td>
                                            </h4>
                                        <td>
                                            {{-- {{ ucwords($quotation_details->employee->full_name) }} --}}
                                            <h4 class="p-0 m-0">
                                                {{ ucwords($quotation_details->employee->full_name) }} <br/>
                                                <small>
                                                    <i>
                                                       On {{ date('d M Y h:iA',strtotime($quotation_details->created)) }}
                                                    </i>
                                                </small>
                                            </h4>
                                        </td>
                                        <td>
                                            <span>
                                                
                                                <a href="{{ route('view_quotations',$quotation_details->id) }}"
                                                    class="btn btn-sm btn-secondary" id="view_quotation" data-toggle="tooltip"
                                                    data-placement="top" title="View">
                                                    View
                                                    <i class="ni ni-bold-right"></i>
                                                </a>
                                                @if ($module_access[0] == 1)
                                                    <a href="{{ route('edit_quotations',$quotation_details->id) }}"
                                                        class="btn btn-sm btn-secondary" id="edit_quotation" data-toggle="tooltip"
                                                        data-placement="top" title="edit">
                                                        Edit
                                                        <i class="fas fa-pencil-ruler"></i>
                                                    </a>
                                                    <a href="{{ route('delete_quotations',$quotation_details->id) }}" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="fas fa-trash color-muted m-r-5"></i>
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
                        {{ $quotations->links('layouts.partials.pagination-links') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom_scripts')

    <script>

    $(document).ready(function() {

        $('.btn-danger').on('click', function(e){
            
            if(!confirm("Are you sure to delete ?")){
                e.preventDefault();
            }
        });
    });

    </script>
    
@endsection