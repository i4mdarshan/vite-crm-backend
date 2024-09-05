@extends('layouts.app')

@section('title', 'Lead Report')

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
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h1 class="mb-2 ml-3">Leads</h1>
                        <div>
                            <form action="{{ route('lead_reports') }}" class="p-0" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3 col-xs-12">
                                        <div class="form-group">
                                            <label for="added_by">Added By</label>
                                            <select
                                                class="form-control form-control-sm @error('added_by') is-invalid @enderror"
                                                name="added_by" id="added_by">
                                                <option value="">Choose Employee</option>
                                                @foreach ($my_employees as $my_employee)
                                                    <option value="{{ $my_employee->id }}"
                                                        {{ old('added_by', $added_by) == $my_employee->id ? 'selected' : 'na' }}>
                                                        {{ $my_employee->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="assigned_to">Assigned to</label>
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
                                                <a href="{{ route('lead_reports') }}" class="btn btn-sm btn-secondary"
                                                    id="resetFilters" type="submit">Reset</a>
                                            </div>
                                            <div>
                                                <button type="button" id="export_leads"
                                                    class="btn btn-sm btn-primary">Export</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="myTable" class="table-responsive" style="height: 60vh; overflow-y: auto">
                            <table id="tbl_exporttable_to_xls" class="table align-items-center">
                                <thead class="thead-light"
                                    style="position: sticky; top:0;background-color: #f3f3f2;z-index: 999">
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Firm</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Added By</th>
                                        <th scope="col">Assigned to</th>
                                        <th scope="col">Contact 1</th>
                                        <th scope="col">State </th>
                                        <th scope="col">District</th>
                                        <th scope="col">Taluka</th>
                                        <th scope="col">Zip Code</th>
                                        <th scope="col">Added On</th>
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
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    @foreach ($all_leads as $lead)
                                        <tr>
                                            {{-- @dd($lead->employee) --}}
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $lead->customer_name }}</td>
                                            <td>{{ $lead->firm->firm_name }}</td>
                                            <td>{{ ucwords($lead->customer_type) }}</td>
                                            <td>{{ ucwords($lead->employee->full_name) }}</td>
                                            <td>{{ ucwords($lead->assigned->full_name) }}</td>
                                            <td>{{ $lead->customer_no1 }}</td>
                                            <td>{{ $lead->state->state_title }}</td>
                                            <td>{{ $lead->customer_district }}</td>
                                            <td>{{ $lead->customer_taluka }}</td>
                                            <td>{{ $lead->customer_pin_code ? $lead->customer_pin_code : 'NA' }}</td>
                                            <td>{{ date('d-m-Y', strtotime($lead->created)) }}</td>
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
        });
    </script>

    <script>
        $(document).ready(function() {

            // Set up AJAX loader
            var loaderContainer = $('#spinner');

            $('#export_leads').on('click', function() {

                // Show loader
                loaderContainer.show();

                // Get values from form elements
                var assignedTo = $('#assigned_to').val();
                var addedBy = $('#added_by').val();
                var fromDate = $('#from_date').val();
                var toDate = $('#to_date').val();

                // Make AJAX GET request
                $.ajax({
                    type: 'POST',
                    url: '{{ route('exportLead_reports') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        assigned_to: assignedTo,
                        from_date: fromDate,
                        to_date: toDate,
                        added_by: addedBy
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
