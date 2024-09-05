@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')

    <div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ url()->previous() }}" class="btn btn-primary px-3">
                        <span class="text-secondary h3"><i class="ni ni-bold-left mr-2"
                                style="font-size: 14px; vertical-align: middle;"></i>Back</span>
                    </a>
                </div>
            </div>
        </div>

        @include('layouts.partials.customer-nav-menu')

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    {{-- <h1 class="m-3">Page Under Construction</h1> --}}
                    <div class="d-flex justify-content-between card-header">
                        <h1 class="mb-0">Customer Complaint Details</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 border-right">
                                <div class="mt-5 m-2">
                                    <h4><strong>Received By : </strong>{{ $complaint_info->employee->full_name }}</h4>
                                    <h4><strong>Added On :
                                        </strong>{{ date('jS F, Y', strtotime($complaint_info->created)) }}</h4>
                                    <!-- View Complaint Photos Button trigger modal -->
                                    @if (count($complaint_info->photos) != 0)
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#viewComplaintPhotosModal">
                                            View Complaint Photos
                                        </button>
                                    @endif


                                    <!-- View Complaint Photos Modal -->
                                    <div class="modal fade" id="viewComplaintPhotosModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Complaint Photos</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 5%; white-space: normal;">Sr
                                                                                No.</th>
                                                                            <th style="width: 90%; white-space: normal;">
                                                                                File</th>
                                                                            <th style="width: 5%; white-space: normal;">
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        @if ($complaint_info->photos)
                                                                            @foreach ($complaint_info->photos as $complaint_photo)
                                                                                <tr>
                                                                                    <td>{{ $loop->iteration }}</td>
                                                                                    <td
                                                                                        style="white-space: normal; max-width: 10vw;">
                                                                                        {{ $complaint_photo->image_name }}
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="{{ asset('uploads/customers/complaint-image/' . $complaint_photo->image_name) }}"
                                                                                            class="btn btn-sm btn-primary"
                                                                                            id="view_complaint_photo"
                                                                                            target="_blank"
                                                                                            data-toggle="tooltip"
                                                                                            data-placement="top"
                                                                                            title="View">
                                                                                            <i class="ni ni-bold-right"></i>
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                            <tr>
                                                                                <td>No records available.</td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        @endif

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="m-1 mt-3 mb-5">
                                    <h2 class="mb-3"><strong>Details</strong></h2>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Complaint Raised By</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $complaint_info->contact ? $complaint_info->contact->contact_person_name : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Complaint Received By</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $complaint_info->employee ? $complaint_info->employee->full_name : 'NA' }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Complain Subject</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ ucwords($complaint_info->complaint_subject) }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-12 mt-2">
                                            <div class="text-secondary border bg-secondary">
                                                <div class="p-2">
                                                    <span class="h5 mb-0">Description</span>
                                                    <h3 class="m-0 p-0">
                                                        <b>{{ $complaint_info->complaint_description }}</b>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1 mx-3">
                                        {{-- <div class="col-md-10"></div> --}}
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-end">
                                                @if ($complaint_info->statuses->first()->status->name != 'closed')
                                                    <a href="#" class="btn btn-sm btn-primary" id="view_complaint"
                                                        data-toggle="modal" data-target="#exampleModalCenter">
                                                        <span class="p" style="font-size: 12px;">Update Status</span>
                                                        <i class="ni ni-bold-right"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Update
                                                                Complaint Status</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form
                                                            action="{{ route('updateComplaintsStatus_customers', ['customer_id' => $customer_id, 'complaint_id' => $complaint_info->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="complaint_status">Complaint Status
                                                                                <span class="text-danger">*</span></label>
                                                                            <select
                                                                                class="form-control @error('complaint_status') is-invalid @enderror"
                                                                                name="complaint_status"
                                                                                id="complaint_status">
                                                                                @foreach ($complaint_statuses as $status)
                                                                                    <option value="{{ $status->id }}">
                                                                                        {{ ucwords(str_replace('_', ' ', $status->name)) }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('complaint_status')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="complaint_status_comment"
                                                                                class="col-form-label">Comment
                                                                                <small>(Character limit 1400)</small> <span
                                                                                    class="text-danger">*</span></label>
                                                                            <textarea class="form-control" rows="6" maxlength="1400" name="complaint_status_comment"
                                                                                id="complaint_status_comment" placeholder="Enter Comment"></textarea>
                                                                            @error('complaint_status_comment')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 mb-3">
                                        <div class="col-md-12 mt-2">
                                            <div class="p-2">
                                                <table class="table">
                                                    <thead>
                                                        <tr style="width: 100%">
                                                            <th style="width: 5%">Date</th>
                                                            <th style="width: 75%">Comment</th>
                                                            <th style="width: 15%">Comment By</th>
                                                            <th style="width: 5%">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($complaint_info->statuses)
                                                            @foreach ($complaint_info->statuses as $status)
                                                                <tr>
                                                                    <td>{{ date('jS F, Y', strtotime($status->created)) }}
                                                                    </td>
                                                                    <td style="white-space: normal;word-wrap: break-word;">
                                                                        {{ $status->complaint_status_comments }}</td>
                                                                    <td>{{ $status->employee->full_name }}</td>

                                                                    @if ($status->status->name == 'in_progress')
                                                                        <td>
                                                                            <span
                                                                                class="badge badge-pill badge-danger">{{ ucwords(str_replace('_', ' ', $status->status->name)) }}</span>
                                                                        </td>
                                                                    @elseif ($status->status->name == 'awaiting_approval')
                                                                        <td>
                                                                            <span
                                                                                class="badge badge-pill badge-info">{{ ucwords(str_replace('_', ' ', $status->status->name)) }}</span>
                                                                        </td>
                                                                    @elseif ($status->status->name == 'closed')
                                                                        <td>
                                                                            <span
                                                                                class="badge badge-pill badge-success">{{ ucwords(str_replace('_', ' ', $status->status->name)) }}</span>
                                                                        </td>
                                                                    @endif

                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td>No records available.</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
