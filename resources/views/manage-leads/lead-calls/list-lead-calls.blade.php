@extends('layouts.app')

@section('title', 'Manage Calls')

@section('content')

<div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="m-1">
                <a href="{{ route('manage_leads') }}" class="btn btn-primary px-3">
                    <span class="text-secondary h3"><i class="ni ni-bold-left mr-2" style="font-size: 14px; vertical-align: middle;"></i>Manage Leads</span>
                </a>
            </div>
        </div>
    </div>
    
    @include('layouts.partials.lead-nav-menu')

    <div class="row">
        <div class="col-md-12" style="max-height: 180vh;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <h1 class="mb-0">Lead Calls</h1>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            @if ($module_access[0] == 1)
                                <a href="{{ route('addCalls_leads', $lead_id) }}" class="btn btn-secondary float-right mx-1 my-2 my-md-0">
                                    Add <i class="fas fa-plus-circle"></i></a>
                            @endif
                        </div>
                    </div> 
                    <div class="row mt-3">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            {{-- Search Form --}}
                            <form action="{{ route('searchCalls_leads', $lead_id) }}" class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto" method="GET">
                                <div class="form-group mb-0">
                                    <div class="input-group input-group-alternative">
                                        <input class="form-control" placeholder="Search By Call With, Date, Time...." name="q" type="text" autocomplete="off">
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
                                            <th class="pr-2 pl-3" scope="col" style="width:5%;"></th>
                                            <th class="pl-2" scope="col" style="width:10%;">Date</th>
                                            <th scope="col" style="width:10%;">Time</th>
                                            <th scope="col" style="width:15%;">Added By</th>
                                            <th scope="col" style="width:15%;">Call With</th>
                                            <th scope="col" style="width:35%;">Description</th>
                                            <th scope="col" style="width:10%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                            
                                        @if (count($lead_calls_details) == 0)
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
                                        @foreach ($lead_calls_details as  $key=>$lead_calls)
                                            <tr>
                                                <td class="pr-2 pl-3">{{ $lead_calls_details->firstItem() + $key }}</td>
                                                <td class="pl-2">{{ date("jS M, Y",strtotime($lead_calls->call_date)) }}</td>
                                                <td>{{ ($lead_calls->call_time) }}</td>
                                                <td>{{ ucwords($lead_calls->addedBy->full_name) }}</td>
                                                <td>{{ ucwords($lead_calls->callWith->contact_person_name) }}</td>
                                                <td style="white-space: nowrap;
                                                max-width: 100px;
                                                    overflow: hidden;
                                                    text-overflow: ellipsis;"
                                                >{{ $lead_calls->call_description }}</td>
                                                <td>
                                                    <span>
                                                        <a href="{{ route('viewCallsDetails_leads',['lead_id' => $lead_id ,'call_id' => $lead_calls->id]) }}"
                                                            class="btn btn-sm btn-secondary" id="view_call">
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
                        {{ $lead_calls_details->links('layouts.partials.pagination-links') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_scripts')

    <script type="text/javascript">
        $(document).ready(function(){
            $('.lead-menu').slick({
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
                },
                {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
                },
                {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
            });


            $(":button[name='filter_lead_calls']").click(function() {

                var filter_call_date = $('#filter_call_date').val();
                var filter_call_lead_id = '{{ $lead_id }}';

                console.log('filter_date: '+filter_call_date+' filter_lead: '+filter_call_lead_id);

                var url = "{{ config("apiconfig.ajax_url") }}/manage_filter/view/calls";
                var getUrl = url + "/" + filter_call_date + "/" + filter_call_lead_id;
                console.log(getUrl);
                $.ajax({
                    url: getUrl,
                    type: "POST",
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(dataResult) {

                        console.log(dataResult);
                        $('#billings_table').html(dataResult['filtered_data']);

                    }
                });
            });
        });
    </script>
    
@endsection
