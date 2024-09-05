@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')

    {{-- @dd(request()->is('manage_leads/view/profile*')) --}}
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


        {{-- @dd($complaint_details) --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="row mx-4 mt-5">
                        <div class="alert alert-warning mb-3 py-3 px-0 w-100" role="alert">
                            <ul class="mt-0 mb-0">
                                <li>The Complaint received by field will always update to logged in user's Name on any edit.
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between card-header">
                        <h1 class="mb-0">Edit Customer Complaint Details</h1>
                    </div>
                    <form
                        action="{{ route('updateComplaints_customers', ['customer_id' => $customer_id, 'complaint_id' => $complaint_details->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="complaints_received_by">Complaint received by <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="complaints_received_by"
                                            class="form-control @error('complaints_received_by') is-invalid @enderror"
                                            id="complaints_received_by" value="{{ ucwords(Auth::user()->full_name) }}"
                                            readonly>
                                        @error('complaints_received_by')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="complaints_raised_by">Complaint raised by <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control @error('complaints_raised_by') is-invalid @enderror"
                                            name="complaints_raised_by" id="complaints_raised_by">
                                            <option value="">Choose Contact</option>
                                            @foreach ($customer_contacts as $customer_contact)
                                                <option value="{{ $customer_contact->id }}"
                                                    {{ (old("complaints_raised_by",$complaint_details->complaint_raised_by) == $customer_contact->id) ? 'selected' : '' }}>
                                                    {{ ucwords($customer_contact->contact_person_name) }}</option>
                                            @endforeach
                                        </select>
                                        @error('complaints_raised_by')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="complaints_subject">Complaint subject <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="complaints_subject"
                                            class="form-control @error('complaints_subject') is-invalid @enderror"
                                            id="complaints_subject" value="{{ old("complaints_subject",$complaint_details->complaint_subject) }}"
                                            maxlength="100" placeholder="Enter Complaint Subject">
                                        @error('complaints_subject')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="complaints_description">Enter Complaint Description <span
                                                class="text-danger">*</span></label>
                                        <textarea name="complaints_description" rows="6"
                                            class="form-control @error('complaints_description') is-invalid @enderror" id="complaints_description"
                                            maxlength="4000" placeholder="Enter complaint description">{{ old("complaints_description",$complaint_details->complaint_description) }}</textarea>
                                        @error('complaints_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="m-1">
                                        <label class="mb-2">Complaint Photos<small>(File size should be less than
                                                2Mb)</small></label>

                                        <!-- View Complaint Photos Button trigger modal -->
                                        @if (count($complaint_details->photos) != 0)
                                            <button type="button" class="btn btn-primary" id="complaintPhotosButton"
                                                data-toggle="modal" data-target="#viewComplaintPhotosModal">
                                                View Complaint Photos
                                            </button>
                                        @endif

                                        <!-- View Complaint Photos Modal -->
                                        <div class="modal fade" id="viewComplaintPhotosModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Complaint Photos
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table class="table"id="complaint_photos_table">
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

                                                                    @if ($complaint_details->photos)
                                                                        @foreach ($complaint_details->photos as $complaint_photo)
                                                                            <tr
                                                                                id="complaint_photo{{ $complaint_photo->id }}">
                                                                                <td>{{ $loop->iteration }}
                                                                                </td>
                                                                                <td style="white-space: normal; max-width: 10vw;">
                                                                                    {{ $complaint_photo->image_name }}</td>
                                                                                <td>
                                                                                    <button
                                                                                        class="btn btn-sm btn-danger complaint_photo_delete"
                                                                                        value="{{ $complaint_photo->id }}"><i
                                                                                            class="fas fa-trash"></i></button>
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
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group parent-input mb-3 mt-3 increment">
                                            <input type="file" id="complaint_photos" name="complaint_photos[]"
                                                accept=".jpg,.png,.jpeg"
                                                class="form-control @error('complaint_photos.*') is-invalid @enderror"
                                                aria-label="Complaint Photos" aria-describedby="button-addon2">

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="button"
                                                    id="button-add">Add</button>
                                            </div>

                                            @error('complaint_photos.*')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>

                                        <div class="clone" style="display: none;">
                                            <div class="input-group parent-input mb-3">
                                                <input type="file" accept=".jpg,.png,.jpeg"
                                                    class="form-control @error('complaint_photos') is-invalid @enderror"
                                                    name="complaint_photos[]" aria-label="Complaint Photos"
                                                    aria-describedby="button-addon2">
                                                <div class="input-group-append">
                                                    <button class="btn btn-icon btn-danger" type="button"
                                                        id="button-add">
                                                        <span class="btn-inner--icon"><i class="fas fa-trash"
                                                                style="font-size: 14px;"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_scripts')

    <script type="text/javascript">
        $(document).ready(function() {

            //function to clone file input on add
            $("#button-add").click(function() {
                var lsthmtl = $(".clone").html();
                $(".increment").after(lsthmtl);
            });
            $("body").on("click", ".btn-danger", function() {
                $(this).parents(".parent-input").remove();
            });

            //function to delete complaint photo
            $('.complaint_photo_delete').on('click', function(event) {
                event.preventDefault();
                var complaint_photo_id = $(this).attr('value');
                var url = "{{ config("apiconfig.ajax_url") }}/manage_customers/view/complaints_photo/delete";

                if (confirm('Are you sure you want to delete this file?')) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        cache: false,
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: complaint_photo_id,
                        },
                        success: function(dataResult) {
                            // console.log(dataResult);

                            if (dataResult['is_deleted']) {
                                $('#complaint_photo' + complaint_photo_id).remove();
                                if ($('#complaint_photos_table tbody tr').length == 0) {
                                    $('#complaintPhotosButton').remove();
                                    $('#viewComplaintPhotosModal').modal('hide');
                                    // $('#complaint_photos').prop('required', true);
                                }
                            } else {
                                alert('Error while deleting the file');
                            }
                        }
                    });

                }
            });
        });
    </script>

@endsection
