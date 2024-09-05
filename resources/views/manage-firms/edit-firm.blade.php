@extends('layouts.app')

@section('title', 'Firm Details')

@section('content')
<div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="m-1">
                <a href="{{ url()->previous() }}" class="btn btn-primary px-3">
                    <span class="text-secondary h3"><i class="ni ni-bold-left mr-2" style="font-size: 14px; vertical-align: middle;"></i>Back</span>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h1 class="mb-0">Edit Firm Details</h1>
                </div>
                <form action="{{ route('update_firms') }}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="m-3">
                        <div class="row mx-4">
                            <div class="alert alert-warning mb-3 py-3 px-0 w-100" role="alert">
                                <ul class="mt-0 mb-0">
                                    <li>The Firm details filled below will be used for generation of Proforma Invoice/Quotation PDFs.</li>
                                    <li>Please make sure the details filled are valid and correct.</li>
                                </ul>
                            </div>
                        </div>
                        <input type="hidden" name="firm_id" value="{{ $firm_details->id }}">
                        <div class="row mx-2">
                            <div class="col-md-12">
                                <h2 class="mb-3">Basic Details</h2>
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firm_name">Enter Firm Name <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_name"
                                        class="form-control @error('firm_name') is-invalid @enderror" id="firm_name"
                                        value="{{ old('firm_name',$firm_details->firm_name) }}" maxlength="40" placeholder="Enter Firm Name">
                                    @error('firm_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="firm_gst_no">Enter GST No. <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_gst_no"
                                        class="form-control @error('firm_gst_no') is-invalid @enderror" id="firm_gst_no"
                                        value="{{ old('firm_gst_no',$firm_details->firm_gst_no) }}" placeholder="Enter GST No.">
                                    @error('firm_gst_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="firm_contact_no">Enter Contact No. <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_contact_no"
                                        class="form-control @error('firm_contact_no') is-invalid @enderror" id="firm_contact_no"
                                        value="{{ old('firm_contact_no',$firm_details->firm_contact_no) }}" placeholder="Enter Contact No. ">
                                    @error('firm_contact_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firm_owner_name">Enter Firm Owner Name <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_owner_name"
                                        class="form-control @error('firm_owner_name') is-invalid @enderror" id="firm_owner_name"
                                        value="{{ old('firm_owner_name',$firm_details->firm_owner_name) }}" maxlength="40" placeholder="Enter Firm Owner Name">
                                    @error('firm_owner_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="firm_email">Enter Firm Email <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_email"
                                        class="form-control @error('firm_email') is-invalid @enderror" id="firm_email"
                                        value="{{ old('firm_email',$firm_details->firm_email) }}" maxlength="50" placeholder="Enter Firm Email">
                                    @error('firm_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-md-12">
                                <h2 class="mb-3">Address Details</h2>
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firm_address_line_1">Enter Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_address_line_1"
                                        class="form-control @error('firm_address_line_1') is-invalid @enderror" id="firm_address_line_1"
                                        value="{{ old('firm_address_line_1',$firm_address_lines[0])  }}" maxlength="30" placeholder="Enter Address Line 1">
                                    @error('firm_address_line_1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="firm_address_line_3">Enter Address Line 3 <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_address_line_3"
                                        class="form-control @error('firm_address_line_3') is-invalid @enderror" id="firm_address_line_3"
                                        value="{{ old('firm_address_line_3',$firm_address_lines[2]) }}" maxlength="30" placeholder="Enter Address Line 3">
                                    @error('firm_address_line_3')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="firm_address_line_5">Enter Address Line 5 <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_address_line_5"
                                        class="form-control @error('firm_address_line_5') is-invalid @enderror" id="firm_address_line_5"
                                        value="{{ old('firm_address_line_5',$firm_address_lines[4]) }}" maxlength="30" placeholder="Enter Address Line 5">
                                    @error('firm_address_line_5')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firm_address_line_2">Enter Address Line 2 <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_address_line_2"
                                        class="form-control @error('firm_address_line_2') is-invalid @enderror" id="firm_address_line_2"
                                        value="{{ old('firm_address_line_2',$firm_address_lines[1]) }}" maxlength="30" placeholder="Enter Address Line 2">
                                    @error('firm_address_line_2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="firm_address_line_4">Enter Address Line 4 <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_address_line_4"
                                        class="form-control @error('firm_address_line_4') is-invalid @enderror" id="firm_address_line_4"
                                        value="{{ old('firm_address_line_4',$firm_address_lines[3]) }}" maxlength="30" placeholder="Enter Address Line 4">
                                    @error('firm_address_line_4')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="firm_address_line_6">Enter Address Line 6 <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_address_line_6"
                                        class="form-control @error('firm_address_line_6') is-invalid @enderror" id="firm_address_line_6"
                                        value="{{ old('firm_address_line_6',$firm_address_lines[5]) }}" maxlength="30" placeholder="Enter Address Line 6">
                                    @error('firm_address_line_6')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-md-12">
                                <h2 class="mb-3">Bank Details</h2>
                            </div>
                        </div>

                        <div class="row mx-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firm_bank_name">Enter Bank Name <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_bank_name"
                                        class="form-control @error('firm_bank_name') is-invalid @enderror" id="firm_bank_name"
                                        value="{{ old('firm_bank_name',$firm_details->firm_bank_name) }}" maxlength="50" placeholder="Enter Bank Name">
                                    @error('firm_bank_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="firm_bank_account_no">Enter Bank Account No <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_bank_account_no"
                                        class="form-control @error('firm_bank_account_no') is-invalid @enderror" id="firm_bank_account_no"
                                        value="{{ old('firm_bank_account_no',$firm_details->firm_bank_account_no) }}" placeholder="Enter Bank Account No">
                                    @error('firm_bank_account_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firm_bank_branch_name">Enter Branch Name <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_bank_branch_name"
                                        class="form-control @error('firm_bank_branch_name') is-invalid @enderror" id="firm_bank_branch_name"
                                        value="{{ old('firm_bank_branch_name',$firm_details->firm_bank_branch_name) }}" maxlength="50" placeholder="Enter Branch Name">
                                    @error('firm_bank_branch_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="firm_bank_ifsc_code">Enter Bank IFSC Code <span class="text-danger">*</span></label>
                                    <input type="text" name="firm_bank_ifsc_code"
                                        class="form-control @error('firm_bank_ifsc_code') is-invalid @enderror" id="firm_bank_ifsc_code"
                                        value="{{ old('firm_bank_ifsc_code',$firm_details->firm_bank_ifsc_code) }}" placeholder="Enter Bank IFSC Code">
                                    @error('firm_bank_ifsc_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
{{-- 
                        <div class="row mx-2">
                            <div class="col-md-6">
                                <h2 class="mb-3">Authorised Signatory Image</h2>
                            </div>
                            <div class="col-md-6">
                                <h2 class="mb-3">Previous Signatory Image</h2>
                            </div>
                        </div>

                        <div class="row mx-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="signatory_image">Upload Signatory Image <span class="text-danger">*</span></label>
                                    <input type="file" name="signatory_image"
                                        class="form-control @error('signatory_image') is-invalid @enderror" id="signatory_image">
                                    @error('signatory_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                        </div> --}}
                    </div>
                    <div class="card-footer border-0">
                        <button class="btn btn-primary" id="updateProduct" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

