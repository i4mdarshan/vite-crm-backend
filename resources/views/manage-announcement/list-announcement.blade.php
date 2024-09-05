@extends('layouts.app')

@section('title', 'Announcement')

@section('content')
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <h1 class="mb-0">Announcements List</h1>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            @if ($module_access[0] == 1)
                                <a href="{{ route('add_announcement') }}" class="btn btn-secondary float-right mx-1 my-2 my-md-0">
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
                                        {{ number_format($all_announcements->total()) }}
                                    </strong>
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {{-- Search Form --}}
                            <form action="{{ route('search_announcement') }}" class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto" method="GET">
                                <div class="form-group mb-0">
                                    <div class="input-group input-group-alternative">
                                        <input class="form-control" placeholder="Search By Announcement title ..." name="q" type="text" autocomplete="off">
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
                                    <th class="pl-2">Announcement title </th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @if (count($all_announcements) == 0)
                                    <tr>
                                        <td>No records available</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                                @foreach ($all_announcements as $key=>$announcement)
                                    <tr>
                                        <td class="pr-2 pl-3">{{ $all_announcements->firstItem() + $key }}</td>
                                        <td class="pl-2">{{ Str::of($announcement->announcement_title )->limit(60)}}</td>
                                        <td>{{ date("jS M, Y",strtotime($announcement->start_date)) }}</td>
                                        <td>{{ date("jS M, Y",strtotime($announcement->end_date)) }}</td>
                                        <td >                                        
                                                <a href="{{ route('view_announcement',$announcement->id) }}" class="btn btn-sm btn-secondary" id="view_announcement">
                                                    <span class="p" style="font-size: 12px;">View</span>
                                                        <i class="ni ni-bold-right"></i>
                                                </a>
                                                @if ($module_access[0] == 1)

                                                    <a href="{{ route('edit_announcement',$announcement->id) }}" class="btn btn-sm btn-secondary" id="edit_announcement">
                                                        <span class="p" style="font-size: 12px;">Edit</span>
                                                    <i class="fas fa-pencil-ruler"></i>
                                                    </a>
                                                    <a href="{{ route('delete_announcement',$announcement->id) }}" class="btn btn-sm btn-danger deleteAnnouncement" id="delete_announcement">
                                                        <span class="p" style="font-size: 12px;">Delete</span>
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    
                                                @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav aria-label="...">
                        {{ $all_announcements->links('layouts.partials.pagination-links') }}
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

        $('.deleteAnnouncement').on('click', function(e){
            
            if(!confirm("Are you sure to delete ?")){
                e.preventDefault();
            }
        });

    });

    </script>
    
@endsection