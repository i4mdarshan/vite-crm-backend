@extends('layouts.app')

@section('title', 'Call Report')
{{-- need to add the relation for the ids and Filters dropdown scope  --}}



@section('content')
    <div>
         {{-- @dd($all_orders); --}}
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
            <form action="{{ route('callFilter_reports') }}" class="d-md-flex d-none" method="GET">
                <div class="form-group mx-2">
                    <label for="task_title">Select Assigned Employee</label>
                    <select class="form-control @error('assigned_to') is-invalid @enderror" name="assigned_to"
                        id="assigned_to">
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
                        <h1 class="mb-0">Calls</h1>
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
                                        <th scope="col">Employee Name</th>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Call Date</th>
                                        <th scope="col">Call Time</th>
                                        <th scope="col">Call with</th>
                                        <th scope="col">Call Description</th> 
                                       
                                    </tr>
                                </thead>
                                <tbody class="list">

                                    @if (count($all_calls) == 0)
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
                                    @foreach($all_calls as $call)
                                   
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ ucwords($call->addedBy->full_name) }}</td>
                                            <td>{{ ucwords($call->customerLeadDetails->customer_name) }}</td>
                                            <td>{{ date("jS M, Y",strtotime($call->call_date)) }}</td>
                                            <td>{{ $call->call_time }}</td>
                                            <td>{{ $call->callWith->contact_person_name }}</td>
                                            <td>{{ $call->call_description }}</td>
                                          
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
                    bookType: 'xlsx',
                    type: 'array'
                }) :
                XLSX.writeFile(wb, fn || ('OrderReport.' + (type || 'xlsx')));
        }
    </script>


@endsection
