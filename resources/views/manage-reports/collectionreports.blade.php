@extends('layouts.app')

@section('title', 'Collection Report')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div>
        <!-- Spinner element (initially hidden) -->
        <div id="spinner" class="spinner-border text-primary" role="status" style="display: none;">
            <span class="sr-only">Exporting...</span>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ route('manage_reports') }}" class="btn btn-primary px-3">
                        <span class="text-secondary h3"><i class="ni ni-bold-left mr-2"
                                style="font-size: 14px; vertical-align: middle;"></i>Back</span>
                    </a>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                {{-- <h1 class="m-3">Page Under Construction</h1> --}}
                <div class="card-header">
                    <h1 class="mb-2 ml-3">Collections</h1>
                    <div>
                        <form action="{{ route('collection_reports') }}" class="p-0" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="assigned_to">Collected By</label>
                                        <select
                                            class="form-control form-control-sm @error('assigned_to') is-invalid @enderror"
                                            name="assigned_to" id="assigned_to">
                                            <option value="">Choose Employee</option>
                                            @foreach ($my_employees as $my_employee)
                                                <option value="{{ $my_employee->id }}"
                                                    {{ old('assigned_to', $assigned_to) == $my_employee->id ? 'selected' : 'na' }}>
                                                    {{ $my_employee->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="to_date">Start date</label>
                                        <input type="date" name="from_date" class="form-control form-control-sm"
                                            id="from_date" value="{{ old('from_date', $from_date) }}">
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="from_date">End date</label>
                                        <input type="date" name="to_date" class="form-control form-control-sm"
                                            id="to_date" value="{{ old('to_date', $to_date) }}">
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="d-flex justify-content-between align-items-center mt-md-4 pt-md-2">
                                        <div>
                                            <button class="btn btn-sm btn-primary" type="submit">Apply
                                                filters</button>
                                        </div>
                                        <div>
                                            <a href="{{ route('collection_reports') }}" class="btn btn-sm btn-secondary"
                                                id="resetFilters" type="submit">Reset</a>
                                        </div>
                                        <div>
                                            <button type="button" id="export_collections"
                                                class="btn btn-sm btn-primary">Export</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="height: 60vh; overflow-y: auto">
                        <table id="tbl_exporttable_to_xls" class="table align-items-center">
                            <thead class="thead-light"
                                style="position: sticky; top:0;background-color: #f3f3f2;z-index: 999">
                                <tr>
                                    <th scope="col">Sr No.</th>
                                    {{-- <th scope="col">Firm</th> --}}
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Collected By</th>
                                    <th scope="col">Collected From</th>
                                    <th scope="col">Money Recieved</th>
                                    <th scope="col">Money Pending</th>
                                    <th scope="col">Money Pending Date</th>
                                    <th scope="col">Collection Status </th>
                                    <th scope="col">Date </th>
                                </tr>
                            </thead>
                            <tbody class="list">

                                @if (count($all_collections) == 0)
                                    <tr>
                                        <td>No records available</td>
                                        <td></td>
                                        {{-- <td></td> --}}
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                                {{-- @dd(count($all_collections)) --}}
                                @foreach ($all_collections as $key => $collection)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucwords($collection->customer->customer_name) }}</td>
                                        <td>{{ ucwords($collection->collected_by_person_name) }}</td>
                                        <td>{{ ucwords($collection->raised_by->contact_person_name) }}</td>
                                        <td>{{ $collection->money_received }}</td>
                                        <td>{{ $collection->money_pending }}</td>
                                        <td>{{ $collection->money_pending_date ? date('d-m-Y', strtotime($collection->money_pending_date)) : 'NA' }}
                                        </td>

                                        @if ($collection->status == 'received')
                                            <td>Received</td>
                                        @elseif ($collection->status == 'pending')
                                            <td>Pending</td>
                                        @endif
                                        <td>{{ date('d-m-Y', strtotime($collection->money_received_date)) }}</td>

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


@section('custom_scripts')

    <script type="text/javascript">
        // Fetch new dashboard data on date range change
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            var from_date = picker.startDate.format('YYYY-MM-DD');
            var to_date = picker.endDate.format('YYYY-MM-DD');
            console.log(from_date);
            console.log(to_date);
        });
    </script>

    <script>
        $(document).ready(function() {

            // Set up AJAX loader
            var loaderContainer = $('#spinner');

            $('#export_collections').on('click', function() {

                // Show loader
                loaderContainer.show();

                // Get values from form elements
                var assignedTo = $('#assigned_to').val();
                var fromDate = $('#from_date').val();
                var toDate = $('#to_date').val();

                // Make AJAX GET request
                $.ajax({
                    type: 'POST',
                    url: '{{ route('exportCollection_reports') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        assigned_to: assignedTo,
                        from_date: fromDate,
                        to_date: toDate
                    },
                    xhrFields: {
                        responseType: 'blob' // Ensure the response is treated as a binary blob
                    },
                    success: function(response, status, xhr) {
                        // console.log('Export Success:', response);
                        var disposition = xhr.getResponseHeader('Content-Disposition');
                        var matches = /filename=(.*?)(?:;|$)/g.exec(disposition);
                        var filename = (matches !== null && matches[1]) ? matches[1] :
                            'downloaded_file.csv';
                        // Handle the response here
                        var link = document.createElement('a');
                        link.href = URL.createObjectURL(new Blob([response]));
                        link.download = filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        // hide loader
                        loaderContainer.hide();
                    },
                    error: function(error, status, xhr) {
                        // hide loader
                        loaderContainer.hide();
                        alert("Error occurred while exporting data !");
                        // console.error('Export Error:', error);
                        // Handle errors here
                    }
                });
            });
        });
    </script>


@endsection
