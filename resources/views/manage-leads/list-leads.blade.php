@extends('layouts.app')

@section('title', 'Manage Leads')

@section('content')
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <h1 class="mb-0">Manage Leads</h1>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                @if ($module_access[0] == 1)
                                    <a href="{{ route('add_leads') }}"
                                        class="btn btn-secondary float-right mx-1 my-2 my-md-0">
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
                                            {{ number_format($all_leads->total()) }}
                                        </strong>
                                    </h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                {{-- Search Form --}}
                                <form action="{{ route('search_leads') }}"
                                    class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto" method="GET">
                                    <div class="form-group mb-0">
                                        <div class="input-group input-group-alternative">
                                            <input class="form-control" placeholder="Search By Name, Type, Assigned to ..."
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
                                        <th class="pr-2 pl-3" scope="col"></th>
                                        <th class="pl-2" scope="col">Name</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Added By</th>
                                        <th scope="col">Assigned To</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list">

                                    @if (count($all_leads) == 0)
                                        <tr>
                                            <td>No records available</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    @foreach ($all_leads as $key => $lead)
                                        <tr>
                                            <td class="pr-2 pl-3">{{ $all_leads->firstItem() + $key }}</td>
                                            {{-- <td>{{ $lead->firm_id }}</td> --}}
                                            <td class="pl-2">
                                                <h4 class="p-0 m-0">
                                                    <span data-toggle="tooltip" data-placement="top" title="{{ $lead->customer_name }}">
                                                        {{ Str::limit($lead->customer_name, $limit = 40, $end = '...') }}
                                                    </span>
                                                    <br/>
                                                    <small>
                                                        <i>
                                                            GSTIN:
                                                            {{ isset($lead->customer_gst_no) ? $lead->customer_gst_no : 'NA' }}
                                                        </i>
                                                    </small>
                                                </h4>
                                            </td>
                                            <td>{{ ucwords($lead->customer_type) }}</td>
                                            <td>
                                                <h4 class="p-0 m-0">
                                                    {{ ucwords($lead->employee->full_name) }} <br />
                                                    <small>
                                                        <i>
                                                            On {{ date('d M Y h:iA', strtotime($lead->created)) }}
                                                        </i>
                                                    </small>
                                                </h4>
                                            </td>
                                            <td>{{ ucwords($lead->assigned->full_name) }}</td>
                                            <td>
                                                <span class="badge badge-pill badge-md {{ ($lead->isActive) ? "badge-success" : "badge-danger"}}"> {{ ($lead->isActive) ? "Active" : "Inactive" }}</span>
                                            </td>
                                            <td>
                                                <span>
                                                    <a href="{{ route('viewProfile_leads', $lead->id) }}"
                                                        class="btn btn-sm btn-secondary" id="view_lead">
                                                        <span class="p" style="font-size: 12px;">View</span>
                                                        <i class="ni ni-bold-right"></i>
                                                    </a>
                                                    <a href="{{ route('convert_leads', $lead->id) }}"
                                                        class="btn btn-sm btn-secondary convert_lead" id="convert_lead"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Convert to Customer">
                                                        <i class="fas fa-user-check"></i>
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
                            {{ $all_leads->links('layouts.partials.pagination-links') }}
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

            //function to confirm convert lead
            $(".convert_lead").click(function(e) {
                // e.preventDefault();
                // console.log("Convert Lead Button pressed.");
                if (!confirm(
                    "Are you sure you want to convert this lead ? This action cannot be reverted.")) {
                    e.preventDefault();
                }
            });

        });
    </script>
@endsection
