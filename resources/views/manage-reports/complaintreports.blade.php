@extends('layouts.app')

@section('title', 'Complaint Report')



@section('content')
    <div>
         {{-- @dd($all_complaints); --}}
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
        <div class="d-md-flex d-none justify-content-between card-header mb-2">
            <h1 class="mb-0">Filters</h1>
            <form action="{{ route('complaintFilter_reports') }}" class="d-md-flex d-none" method="GET">
                <div class="form-group mx-2">
                    <label for="task_title">Select Assigned Employee</label>
                    <select class="form-control @error('complaint_received_by') is-invalid @enderror" name="complaint_received_by"
                        id="complaint_received_by">
                        <option value="">Choose Employee</option>
                        @foreach ($my_employees as $my_employee)
                            <option value="{{ $my_employee->id }}">{{ $my_employee->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mx-2">
                    <label for="to_date">Select Start date</label>
                    <input type="date" name="from_date" class="form-control" id="from_date" value="">
                </div>
                <div class="form-group mx-2">
                    <label for="from_date">Select End date</label>
                    <input type="date" name="to_date" class="form-control" id="to_date" value="">
                </div>
                <div class="card-footer border-0">
                    <button class="btn btn-primary" id="applyFilters" type="submit">Apply filters</button>
                </div>
            </form>
            <h1></h1>
        </div>
        <div class="row">
            <div class="col-md-12" style="max-height: 80vh;">
                <div class="card shadow">
                    {{-- <h1 class="m-3">Page Under Construction</h1> --}}
                    <div class="d-flex justify-content-between card-header">
                        <h1 class="mb-0">Complaints</h1>
                        <div>
                            <button onclick="ExportToExcel('xlsx')" class="btn btn-primary">Export</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="myTable" class="table-responsive" style="height: 60vh; overflow-y: auto">
                            <table id="tbl_exporttable_to_xls" class="table align-items-center">
                                <thead class="thead-light"
                                    style="position: sticky; top:0;background-color: #f3f3f2;z-index: 999">
                                    <tr>
                                        <th scope="col">Sr No.</th>
                                        {{-- <th scope="col">Firm</th> --}}
                                        <th scope="col">Complain Received by</th>
                                        <th scope="col">Complain Raised by</th>
                                        <th scope="col">Complaint Subject</th>
                                        <th scope="col">Complaint Description</th>
                                        <th scope="col">Complaint Status</th>  
                                        <th scope="col">Complain Date</th>   
                                    </tr>
                                </thead>
                                <tbody class="list">

                                    @if (count($all_complaints) == 0)
                                        <tr>
                                            <td>No records available</td>
                                            <td></td>
                                            {{-- <td></td> --}}
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    @foreach ($all_complaints as $complaint)
                                        <tr>
                                            {{-- @dd($lead->employee) --}}
                                            <td>{{ $loop->iteration }}</td>
                                            {{-- <td>{{ $lead->firm_id }}</td> --}}
                                            {{-- @dd($complaint->raised_by) --}}
                                            <td>{{ ucwords($complaint->received_by->full_name) }}</td>
                                            <td>{{ ucwords($complaint->raised_by->contact_person_name) }}</td>
                                            <td>{{ $complaint->complaint_subject }}</td>
                                            <td>{{ $complaint->complaint_description }}</td>
                                            @if($complaint->complaint_status == "")
                                                <td>Pending</td>
                                            @elseif ($complaint->complaint_status == "1")
                                                <td>Completed</td>
                                            @endif 
                                            <td>{{ date('d-m-Y', strtotime($complaint->created)) }}</td>

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
        // function autofitColumns(worksheet: WorkSheet) {
        //     let objectMaxLength: ColInfo[] = [];
        //     const [startLetter, endLetter] = worksheet['!ref']?.replace(/\d/, '').split(':') !;
        //     const ranges = range(startLetter.charCodeAt(0), endLetter.charCodeAt(0) + 1);
        //     ranges.forEach((c) => {
        //         const cell = String.fromCharCode(c);
        //         const cellLength = worksheet[`${cell}1`].v.length + 1;
        //         objectMaxLength.push({
        //             width: cellLength
        //         });
        //     });
        //     worksheet['!cols'] = objectMaxLength;
        // }

        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tbl_exporttable_to_xls');
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });

            return dl ?
                XLSX.write(wb, {
                    bookType: type,
                    bookSST: true,
                    type: 'base64'
                }) :
                XLSX.writeFile(wb, fn || ('ComplaintReport.' + (type || 'xlsx')));
        }
    </script>


@endsection
