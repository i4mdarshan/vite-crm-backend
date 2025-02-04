@extends('layouts.app')

@section('title', 'Manage Leads')

@section('content')

    {{-- @dd(request()->is('manage_leads/view/profile*')) --}}
    <div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ route('manage_leads') }}" class="btn btn-primary px-3">
                        <span class="text-secondary h3"><i class="ni ni-bold-left mr-2"
                                style="font-size: 14px; vertical-align: middle;"></i>Manage Leads</span>
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
                                <h1 class="mb-0">Lead Contacts</h1>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                @if ($module_access[0] == 1)
                                    <a href="{{ route('addContacts_leads', $lead_id) }}"
                                        class="btn btn-secondary float-right mx-1 my-2 my-md-0">
                                        Add <i class="fas fa-plus-circle"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                {{-- Search Form --}}
                                <form action="{{ route('searchContacts_leads', $lead_id) }}"
                                    class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto" method="GET">
                                    <div class="form-group mb-0">
                                        <div class="input-group input-group-alternative">
                                            <input class="form-control" placeholder="Search By Name, Email, Phone no...."
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
                                        <th scope="col">Designation</th>
                                        <th scope="col">Phone No.</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list">

                                    @if (count($lead_contact_details) == 0)
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
                                    @foreach ($lead_contact_details as $key => $lead_contact)
                                        <tr>
                                            <td class="pr-2 pl-3">{{ $lead_contact_details->firstItem() + $key }}</td>
                                            <td class="pl-2">
                                                <span data-toggle="tooltip" data-placement="top"
                                                    title="{{ ucwords($lead_contact->contact_person_name) }}">
                                                    {{ Str::limit(ucwords($lead_contact->contact_person_name), $limit = 40, $end = '...') }}
                                                </span>
                                            </td>
                                            <td>{{ ucwords($lead_contact->contact_designation) }}</td>
                                            <td>{{ $lead_contact->contact_number }}</td>
                                            <td>{{ $lead_contact->contact_email }}</td>
                                            <td>
                                                @if ($lead_contact->isActive == 1)
                                                    <span class="badge badge-success px-2">Active</span>
                                                @else
                                                    <span class="badge badge-danger px-2">InActive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span>
                                                    @if ($module_access[0] == 1)
                                                        <a href="{{ route('editContact_leads', ['lead_id' => $lead_id, 'contact_id' => $lead_contact->id]) }}"
                                                            class="btn btn-sm btn-secondary" id="edit_product_category">
                                                            <span class="p" style="font-size: 12px;">Edit</span>
                                                            <i class="fas fa-pencil-ruler"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('viewContactDetails_leads', ['lead_id' => $lead_id, 'contact_id' => $lead_contact->id]) }}"
                                                        class="btn btn-sm btn-secondary" id="view_lead"
                                                        data-toggle="tooltip" data-placement="top" title="View">
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
                            {{ $lead_contact_details->links('layouts.partials.pagination-links') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.lead-menu').slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [{
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
        });
    </script>

@endsection
