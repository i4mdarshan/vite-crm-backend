@extends('layouts.app')

@section('title', 'Manage Firms')


@section('content')
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <h1 class="mb-0">Manage Firms</h1>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="height: 75vh; overflow-y: auto">
                        <table class="table align-items-center">
                            <thead class="thead-light" style="position: sticky; top:0;background-color: #f3f3f2;z-index: 999">
                                <tr>
                                    <th style="width: 33.33%">Sr No.</th>
                                    <th style="width: 33.33%">Name</th>
                                    <th style="width: 33.33%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">

                                @if (count($all_firms) == 0)
                                    <tr>
                                        <td>No records available</td>
                                        <td></td>
                                        <td></td>
                                    </tr>


                                @else
                                    @foreach ($all_firms as $key => $firm)
                                        {{-- @dd($all_firms) --}}
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <th>{{ $firm->firm_name }}</th>
                                            <td>
                                                <span>
                                                    <a href="{{ route('edit_firms',$firm->id) }}" class="btn btn-sm btn-secondary" id="edit_employee">
                                                        <span class="p" style="font-size: 12px;">Edit</span>
                                                        <i class="fas fa-pencil-ruler"></i>
                                                    </a>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
</div>
@endsection
