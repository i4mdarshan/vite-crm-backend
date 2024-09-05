@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')

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
                            <h1 class="mb-0">Customer Notes</h1>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            @if ($module_access[0] == 1)
                                <a href="{{ route('addNote_customers', $customer_id) }}" class="btn btn-secondary float-right mx-1 my-2 my-md-0">
                                    Add <i class="fas fa-plus-circle"></i></a>
                            @endif
                        </div>
                    </div> 
                    <div class="row mt-3">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            {{-- Search Form --}}
                            <form action="{{ route('searchNotes_customers', $customer_id) }}" class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto" method="GET">
                                <div class="form-group mb-0">
                                    <div class="input-group input-group-alternative">
                                        <input class="form-control" placeholder="Search By Time...." name="q" type="text" autocomplete="off">
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
                                            <th scope="col"></th>
                                            {{-- <th scope="col">Firm</th> --}}
                                            <th scope="col">Date</th>
                                            <th scope="col">Time</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                            
                                        @if (count($customer_notes) == 0)
                                            <tr>
                                                <td>No records available</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                             
                                            </tr>
                                        @endif
                                        @foreach ($customer_notes as $key=>$customer_note)
                                            <tr>
                                                <td>{{ $customer_notes->firstItem() + $key }}</td>
                                                <td>{{ date("jS M, Y",strtotime($customer_note->notes_date)) }}</td>
                                                <td>{{ ($customer_note->notes_time) }}</td>
                                                
                                                <td>
                                                    <span>
                                                        <a href="{{ route('viewNoteDetails_customers',['customer_id' => $customer_id ,'note_id' => $customer_note->id]) }}"
                                                            class="btn btn-sm btn-secondary" id="view_customer">
                                                            <span class="p" style="font-size: 12px;">View</span>
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
                <div class="card-footer py-4">
                    <nav aria-label="...">
                        {{ $customer_notes->links('layouts.partials.pagination-links') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

