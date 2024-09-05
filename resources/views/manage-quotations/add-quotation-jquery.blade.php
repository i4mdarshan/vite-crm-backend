@extends('layouts.app')

@section('title', 'Sales Transactions')

@section('content')
    <div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ route('manage_quotations') }}" class="btn btn-primary px-3">
                        <span class="h3"><i class="ni ni-bold-left mr-2"
                                style="font-size: 14px; vertical-align: middle;"></i>Sales Transactions</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <h1 class="mb-0">Generate</h1>
                    </div>
                    <div>
                        <form action="{{ route('save_quotations') }}" method="POST">
                            @csrf
                            <div class="m-3">

                                {{-- Quotation type --}}
                                <div class="row mx-2">
                                    <div class="col-md-12 col-xs-12">
                                        @if ($message = Session::get('error'))
                                            <div class="alert alert-danger alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mx-2">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="quotation_type">Type <span class="text-danger">*</span></label>
                                            <select name="quotation_type"
                                                class="form-control @error('quotation_type') is-invalid @enderror"
                                                id="quotation_type">
                                                <option value="">Choose Status</option>
                                                <option value="quotation"
                                                    {{ old('quotation_type') == 'quotation' ? 'selected' : '' }}>Quotation
                                                </option>
                                                <option value="proforma_invoice"
                                                    {{ old('quotation_type') == 'proforma_invoice' ? 'selected' : '' }}>
                                                    Proforma Invoice</option>
                                                <option value="sample_request"
                                                    {{ old('quotation_type') == 'sample_request' ? 'selected' : '' }}>
                                                    Sample Request</option>
                                                <option value="pending_order_form"
                                                    {{ old('quotation_type') == 'pending_order_form' ? 'selected' : '' }}>
                                                    Pending Order Form</option>
                                            </select>
                                            @error('quotation_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Date and Qoutation No. --}}
                                <div class="row mx-2">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="quotation_date">Dated</label>
                                            <input type="date" name="quotation_date" min="{{ now()->format('Y-m-d') }}"
                                                max="{{ now()->format('Y-m-d') }}"
                                                class="form-control @error('quotation_date') is-invalid @enderror"
                                                id="quotation_date" value="{{ now()->format('Y-m-d') }}" readonly>
                                            @error('quotation_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="sales_person_name">Sales Person Name</label>
                                            <input type="text" name="sales_person_name"
                                                class="form-control @error('sales_person_name') is-invalid @enderror"
                                                id="sales_person_name" value="{{ ucwords(Auth()->user()->full_name) }}"
                                                readonly>
                                            @error('sales_person_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                {{-- Clients and Sales Person Name --}}
                                <div class="row mx-2">
                                    <div class="col-md-6 col-xs-12">

                                        <div class="form-group">
                                            <label for="firm_name">Select Firm <span class="text-danger">*</span></label>
                                            <select name="firm_name" class="form-control" id="firm_name">
                                                <option value="">Select Firm</option>
                                                @foreach ($firms as $firm)
                                                    <option value="{{ $firm->id }}"
                                                        {{ old('firm_name') == $firm->id ? 'selected' : '' }}>
                                                        {{ ucwords($firm->firm_name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('firm_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="firm_address">Firm Address : <span
                                                    class="text-danger">*</span></label>
                                            <textarea type="text" name="firm_address" rows="4" id="firm_address"
                                                class="form-control form-control-sm @error('firm_address') is-invalid @enderror" maxlength="150"
                                                placeholder="Enter Firm Address" readonly>{{ old('firm_address') }}</textarea>
                                            @error('firm_address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-xs-12">

                                        <div class="form-group">
                                            <label for="client_name">Client Name <span class="text-danger">*</span></label>
                                            <select name="client_name" class="form-control" id="live_client_search">
                                                <option value="" {{ old('client_name') }}>Select Client</option>
                                            </select>
                                            @error('client_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group pt-1">
                                            <label for="client_address">Client Address : <span
                                                    class="text-danger">*</span></label>
                                            <textarea type="text" name="client_address" id="client_address" rows="4"
                                                class="form-control form-control-sm @error('client_address') is-invalid @enderror" maxlength="150"
                                                placeholder="Enter Client Address">{{ old('client_address') }}</textarea>
                                            @error('client_address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Dispatch Details --}}
                                <div class="row mx-2">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="dispatch_date">Dispatch Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" name="dispatch_date"
                                                min="{{ now()->format('Y-m-d') }}" value="{{ old('dispatch_date') }}"
                                                class="form-control @error('dispatch_date') is-invalid @enderror"
                                                id="dispatch_date">
                                            @error('dispatch_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="dispatch_status">Dispatch Status <span
                                                    class="text-danger">*</span></label>
                                            <select name="dispatch_status"
                                                class="form-control @error('dispatch_status') is-invalid @enderror"
                                                id="dispatch_status">
                                                <option value=""
                                                    {{ old('dispatch_status') == '' ? 'selected' : '' }}>Choose Status
                                                </option>
                                                <option value="pending"
                                                    {{ old('dispatch_status') == 'pending' ? 'selected' : '' }}>Pending
                                                </option>
                                                <option value="hold"
                                                    {{ old('dispatch_status') == 'hold' ? 'selected' : '' }}>Hold
                                                </option>
                                                <option value="dispatch"
                                                    {{ old('dispatch_status') == 'dispatch' ? 'selected' : '' }}>Dispatch
                                                </option>
                                            </select>
                                            @error('dispatch_status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Transportation Details --}}
                                <div class="row mx-2">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="transport">Transport</label>
                                            <input type="text" name="transport"
                                                class="form-control @error('transport') is-invalid @enderror"
                                                id="transport" placeholder="Transport" value="{{ old('transport') }}"
                                                maxlength="50">
                                            @error('transport')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="booking_destination">Booking Destination</label>
                                            <input type="text" name="booking_destination"
                                                class="form-control @error('booking_destination') is-invalid @enderror"
                                                id="booking_destination" placeholder="Booking Destination"
                                                value="{{ old('booking_destination') }}" maxlength="50">
                                            @error('booking_destination')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Local Forwarding Amount --}}
                                {{-- <div class="row mx-2">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="local_forwarding">Local Forwarding</label>
                                            <select name="local_forwarding"
                                                class="form-control @error('local_forwarding') is-invalid @enderror"
                                                id="local_forwarding">
                                                <option value="">Choose</option>
                                                <option value="no">No</option>
                                                <option value="yes">Yes</option>
                                            </select>
                                            @error('local_forwarding')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="amount_of_lf">Amount of LF</label>
                                            <input type="number" min="0" name="amount_of_lf"
                                                class="form-control @error('amount_of_lf') is-invalid @enderror"
                                                id="amount_of_lf">
                                            @error('amount_of_lf')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="row mx-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="from_company">From Company</label>
                                            <input type="text" name="from_company"
                                                class="form-control @error('from_company') is-invalid @enderror" id="from_company"
                                                value="Anjali Chemicals">
                                            @error('from_company')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>
                                            <label for="from_address">Address</label>
                                            <textarea class="form-control pt-3" name="from_address" id="from_address" rows="6">{!! $app_settings->billing_address !!}
                                                        </textarea>
                                            @error('from_address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="to_company">Proforma Invoice To</label>
                                            <input type="text" name="to_company"
                                                class="form-control @error('to_company') is-invalid @enderror" id="to_company"
                                                placeholder="Enter Company Name">
                                            @error('to_company')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>
                                            <label for="to_address">Address</label>
                                            <textarea class="form-control pt-3" name="to_address" id="to_address" rows="6"
                                                placeholder="Enter Company Address"></textarea>
                                            @error('to_address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- Main Quotation table --}}

                                <div class="row m-2">
                                    <div class="table-responsive">
                                        <table class="table" id="items_table">
                                            <thead class="thead-light">
                                                <tr>
                                                    {{-- <th scope="col">Sr No.</th> --}}
                                                    <th style="width: 30%" scope="col">Particular</th>
                                                    <th style="width: 5%" scope="col">Nos of Product</th>
                                                    <th style="width: 10%" scope="col">Packaging</th>
                                                    <th style="width: 10%" scope="col">Quantity </th>
                                                    <th style="width: 15%" scope="col">Price Per Unit</th>
                                                    <th style="width: 5%" scope="col">GST (%)</th>
                                                    <th style="width: 20%" scope="col">Amount (INR)</th>
                                                    <th style="width: 5%" scope="col"></th>
                                                </tr>
                                            </thead>
                                            {{-- @dd($active_products) --}}
                                            <tbody id="tbody">
                                                <tr id="product-item-row-0" class="product-item-row-0">
                                                    {{-- Select Products dropdown --}}
                                                    <td>
                                                        <div class="form-group select-2-product-search">
                                                            <select name="quotation_product_ids[]"
                                                                class="form-control select-products">
                                                                <option value="">Select Product</option>
                                                                {{-- @dd($active_products) --}}
                                                                @foreach ($active_products as $product)
                                                                    <option value="{{ $product->id }}"
                                                                        {{ old('quotation_product_ids[]') == $product->id ? 'selected' : '' }}>
                                                                        {{ ucwords($product->product_name) }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('quotation_product_ids[]')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    {{-- Input for Nos --}}
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="d-flex">
                                                                {{-- <button class="btn btn-primary btn-sm"><i
                                                                        class="fas fa-plus"></i></button> --}}

                                                                <input type="number" min="0"
                                                                    name="quotation_product_nos[]"
                                                                    class="form-control form-control-sm @error('quotation_product_nos[]') is-invalid @enderror"
                                                                    id="quotation_product_nos[]" value="0">

                                                                {{-- <button class="btn btn-danger btn-sm ml-2"><i
                                                                        class="fas fa-minus"></i></button> --}}
                                                            </div>
                                                            @error('quotation_product_nos[]')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    {{-- Input for packing --}}
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="number" min="0"
                                                                name="quotation_product_packaging[]"
                                                                class="form-control form-control-sm @error('quotation_product_packaging[]') is-invalid @enderror"
                                                                value="0" id="quotation_product_packaging[]"
                                                                readonly>
                                                            @error('quotation_product_packaging[]')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    {{-- Input for quantity --}}
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="number" min="0"
                                                                name="quotation_product_quantity[]"
                                                                id="quotation_product_quantity[]"
                                                                class="form-control form-control-sm @error('quotation_product_quantity[]') is-invalid @enderror"
                                                                value="0" readonly>
                                                            @error('quotation_product_quantity[]')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    {{-- Input for price per pack --}}
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" min="0"
                                                                name="quotation_product_price[]"
                                                                id="quotation_product_price[]"
                                                                class="form-control form-control-sm @error('quotation_product_price[]') is-invalid @enderror"
                                                                value="0">
                                                            @error('quotation_product_price[]')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    {{-- Input for product tax --}}
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" min="0"
                                                                name="quotation_product_tax[]"
                                                                id="quotation_product_tax[]"
                                                                class="form-control form-control-sm @error('quotation_product_tax[]') is-invalid @enderror"
                                                                value="0" readonly>
                                                            @error('quotation_product_tax[]')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    {{-- Input for amount --}}
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="number" min="0"
                                                                name="quotation_product_amount[]"
                                                                id="quotation_product_amount[]"
                                                                class="form-control form-control-sm @error('quotation_product_amount[]') is-invalid @enderror"
                                                                value="0" readonly>
                                                            @error('quotation_product_amount[]')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="remRow btn btn-sm btn-danger" id="row-0"
                                                            type="button">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr id="product-item-row-dummy"></tr>
                                                {{-- @endforeach --}}
                                                <tr>
                                                    <td colspan="8">
                                                        <button class="btn btn-md btn-secondary add_item" id="add_item"
                                                            type="button" style="width: 100%">
                                                            <i class="fas fa-plus-circle"
                                                                style="font-size: 12px"></i>&nbsp;Add Item
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Show subtotal tax and total --}}
                                <div class="row m-3">
                                    <div class="d-none d-sm-block col-md-3"></div>
                                    <div class="d-none d-sm-block col-md-3"></div>
                                    <div class="col-6 col-sm-6 col-md-3">
                                        {{-- <h4 class="text-right pt-1">Sub Total :</h4> --}}
                                        {{-- <h4 class="text-right pt-2">Tax :</h4> --}}
                                        <h1 class="text-right pt-1">Total :</h1>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="form-group">
                                            {{-- {{ var_dump(array_sum(array_column($this->quotationProducts,'product_price'))) }} --}}
                                            {{-- <input
                                                class="form-control form-control-sm @error('quotation_sub_total') is-invalid @enderror"
                                                type="text" name="quotation_sub_total" id="quotation_sub_total"
                                                value="0" readonly>

                                                <input
                                                class="form-control form-control-sm mt-2 @error('quotation_tax') is-invalid @enderror"
                                                type="text" name="quotation_tax" id="quotation_tax"
                                                value="0" readonly> --}}

                                            <input
                                                class="form-control form-control-sm mt-2 @error('quotation_total') is-invalid @enderror"
                                                type="text" name="quotation_total" id="quotation_total"
                                                value="0" readonly>
                                        </div>
                                    </div>
                                </div>

                                {{-- Special Notes line --}}
                                <div class="row m-3">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="remarks" class="h4">Special Note :</label>
                                            <textarea type="text" name="remarks" rows="4"
                                                class="form-control form-control-sm @error('remarks') is-invalid @enderror" placeholder="Enter Special Note"
                                                maxlength="1500">{{ old('remarks') }}</textarea>
                                            @error('remarks')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                {{-- Payment condition line --}}
                                <div class="row m-3">
                                    <div class="col-md-3 col-sm-12">
                                        <h4>Payment Condition <span class="text-danger">*</span>: </h4>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <input type="number" min="0" value="{{ old('payment_condition') }}"
                                                name="payment_condition"
                                                class="form-control form-control-sm @error('payment_condition') is-invalid @enderror"
                                                placeholder="Enter Payment Condition">
                                            @error('payment_condition')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <select
                                                class="form-control form-control-sm @error('payment_time') is-invalid @enderror"
                                                name="payment_time">
                                                <option value=""
                                                    {{ old('payment_time') == '' ? 'selected' : '' }}>Choose Payment Time
                                                </option>
                                                <option value="days"
                                                    {{ old('payment_time') == 'days' ? 'selected' : '' }}>Days</option>
                                                <option value="weeks"
                                                    {{ old('payment_time') == 'weeks' ? 'selected' : '' }}>Weeks</option>
                                                <option value="months"
                                                    {{ old('payment_time') == 'months' ? 'selected' : '' }}>Months
                                                </option>
                                                <option value="immediate"
                                                    {{ old('payment_time') == 'immediate' ? 'selected' : '' }}>Immediate
                                                </option>
                                                <option value="none"
                                                    {{ old('payment_time') == 'none' ? 'selected' : '' }}>None</option>
                                            </select>
                                            @error('payment_time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <select
                                                class="form-control form-control-sm @error('payment_type') is-invalid @enderror"
                                                name="payment_type">
                                                <option value=""
                                                    {{ old('payment_type') == '' ? 'selected' : '' }}>Choose Payment Type
                                                </option>
                                                <option value="credit"
                                                    {{ old('payment_type') == 'credit' ? 'selected' : '' }}>Credit
                                                </option>
                                                <option value="advance"
                                                    {{ old('payment_type') == 'advance' ? 'selected' : '' }}>Advance
                                                </option>
                                                <option value="pdc"
                                                    {{ old('payment_type') == 'pdc' ? 'selected' : '' }}>PDC</option>
                                                <option value="none"
                                                    {{ old('payment_type') == 'none' ? 'selected' : '' }}>None</option>
                                            </select>
                                            @error('payment_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Term of Supply and approximate total line --}}
                                <div class="row m-3">
                                    <div class="col-md-3 col-sm-12">
                                        <h4>Term Of supply (Transport Payment ) <span class="text-danger">*</span>:</h4>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        {{-- <div class=""> --}}
                                        <div class="form-group">
                                            <select name="term_of_supply"
                                                class="form-control form-control-sm @error('term_of_supply') is-invalid @enderror">
                                                <option value="to_pay"
                                                    {{ old('term_of_supply') == 'to_pay' ? 'selected' : '' }}>To Pay
                                                </option>
                                                <option value="paid"
                                                    {{ old('term_of_supply') == 'paid' ? 'selected' : '' }}>Paid</option>
                                            </select>
                                        </div>
                                        {{-- </div> --}}
                                    </div>
                                </div>

                                {{-- Submit Preview Buttons --}}
                                <div class="row m-2">
                                    <div class="col-md-12 col-sm-12 d-flex justify-content-md-end mb-3"
                                        style="justify-content: space-between;">
                                        {{-- <div class="card-footer border-0"> --}}
                                        {{-- <button class="btn btn-secondary" id="addInvoice" type="submit">
                                            <i class="fas fa-eye" style="font-size: 12px;"></i> Preview
                                        </button> --}}
                                        <button class="btn btn-primary" id="addInvoice" type="submit">
                                            <i class="fas fa-check" style="font-size: 12px;"></i> Save
                                        </button>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom_scripts')
    {{-- <script src="{{mix('js/AddQuotation.js')}}"></script> --}}
    {{-- <script src="{{mix('js/AddQuotation.js')}}"></script> --}}
    <script type="text/javascript">
        $(function() {
            $(function() {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                    },
                });
            });

            // var baseURL = process.env.APP_URL;
            var clientSearchURL = "{{ config("apiconfig.ajax_url") }}/ajax_autocomplete_search_lead";
            var clientAddressURL = "{{ config("apiconfig.ajax_url") }}/get_client_address";
            var productDetailsURL = "{{ config("apiconfig.ajax_url") }}/get_product_details";
            var productSearchURL = "{{ config("apiconfig.ajax_url") }}/ajax_autocomplete_search_product";
            var firmURL = "{{ config("apiconfig.ajax_url") }}/get_firm_details";

            //initialize select2 for live client search
            $("#live_client_search").select2({
                placeholder: "Select Client",
                dropdownAutoWidth: true,
                width: "auto",
                theme: "bootstrap4",
                selectionCssClass: "form-control form-control-md",
                ajax: {
                    url: clientSearchURL,
                    dataType: "json",
                    delay: 250,
                    processResults: function processResults(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.customer_name,
                                    id: item.id,
                                };
                            }),
                        };
                    },
                    cache: true,
                },
            });

            //on client firm name change show address
            $('#live_client_search').on('select2:select', function(e) {
                var clientId = e.params.data.id;
                var formData = {
                    client_id: clientId,
                };
                $.ajax({
                    type: "POST",
                    url: clientAddressURL,
                    data: formData,
                    dataType: "json",
                    success: function success(response) {
                        //push address from response in textarea
                        // console.log(response);
                        $("#client_address").html(response.address);
                    },
                });
                // console.log(data);
            });

            //initialize select2 for live product search
            $(".select-products").select2({
                placeholder: "Select Product",
                dropdownAutoWidth: true,
                width: "auto",
                selectionCssClass: "form-control form-control-sm",
                theme: "bootstrap4",
                ajax: {
                    url: productSearchURL,
                    dataType: "json",
                    delay: 250,
                    processResults: function processResults(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.product_name,
                                    id: item.id,
                                };
                            })
                        };
                    },
                    cache: true,
                },

            });

            //add items row on add button click
            $("#add_item").on("click", function() {
                $(".select-products").select2("destroy");
                var noOfRows = $(".product-item-row-0").length;
                // console.log(noOfRows);
                var clonedRow = $(".product-item-row-0").first().clone(true);
                clonedRow.insertBefore("#product-item-row-dummy");
                clonedRow.attr("id", "product-item-row-" + noOfRows);

                var set_product_nos = $("#product-item-row-" + noOfRows)
                    .children()
                    .find('input[id="quotation_product_nos[]"]')
                    .val(0);
                var set_product_packaging = $("#product-item-row-" + noOfRows)
                    .children()
                    .find('input[id="quotation_product_packaging[]"]')
                    .val(0);

                var set_quantity = $("#product-item-row-" + noOfRows)
                    .children()
                    .find('input[id="quotation_product_quantity[]"]')
                    .val(0);

                var set_product_per_price = $("#product-item-row-" + noOfRows)
                    .children()
                    .find('input[id="quotation_product_price[]"]')
                    .val(0);

                var set_product_per_tax = $("#product-item-row-" + noOfRows)
                    .children()
                    .find('input[id="quotation_product_tax[]"]')
                    .val(0);

                var set_product_amount = $("#product-item-row-" + noOfRows)
                    .children()
                    .find('input[id="quotation_product_amount[]"]')
                    .val(0);

                $(".select-products").select2({
                    placeholder: "Select Product",
                    dropdownAutoWidth: true,
                    width: "auto",
                    selectionCssClass: "form-control form-control-sm",
                    theme: "bootstrap4",
                    ajax: {
                        url: productSearchURL,
                        dataType: "json",
                        delay: 250,
                        processResults: function processResults(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.product_name,
                                        id: item.id,
                                    };
                                }),
                            };
                        },
                        cache: true,
                    },
                });
            });

            //delete item row on delete button click
            $(".remRow").on("click", function() {
                var noOfRows = $(".product-item-row-0").length;

                if (noOfRows > 1) {
                    var product_amounts = $('input[name="quotation_product_amount[]"]')
                        .map(function() {
                            return $(this).val();
                        })
                        .get();
                    // console.log("Product amounts array before remove: ", product_amounts);
                    $(this).closest("tr").remove();
                    var curr_row_id = $(this).parents("tr").attr("id");
                } else {
                    return false;
                }

                //get all product amounts
                var product_amounts = $('input[name="quotation_product_amount[]"]')
                    .map(function() {
                        return $(this).val();
                    })
                    .get();

                // console.log("Product amounts array after remove: ", product_amounts);

                //get all product taxes
                // var product_taxes = $('input[name="quotation_product_tax[]"]')
                //     .map(function () {
                //         return $(this).val();
                //     })
                //     .get();

                //calculate new tax total
                // var cal_quotation_tax_total = product_taxes.reduce(function (a, b) {
                //     return parseFloat(a) + parseFloat(b);
                // }, 0);

                //set new tax total
                // var set_quotation_tax_total = $(
                //     'input[name="quotation_sub_total"]'
                // ).val(cal_quotation_tax_total.toFixed(2));

                //calculate new subtotal
                // var cal_quotation_sub_total = product_amounts.reduce(function (a, b) {
                //     return parseFloat(a) + parseFloat(b);
                // }, 0);

                //set new subtotal
                // var set_quotation_sub_total = $(
                //     'input[name="quotation_sub_total"]'
                // ).val(cal_quotation_sub_total.toFixed(2));

                // calculate new tax
                // var calc_new_tax = cal_quotation_tax_total.toFixed(2);

                //set new tax
                // var set_new_tax = $('input[name="quotation_tax"]').val(calc_new_tax);

                // calculate new total
                // var calc_new_total =
                //     parseFloat(cal_quotation_sub_total.toFixed(2)) +
                //     parseFloat(calc_new_tax);

                // set new total
                // var set_new_total = $('input[name="quotation_total"]').val(
                //     calc_new_total.toFixed(2)
                // );

                //calculate new quotation total
                var cal_quotation_total = product_amounts.reduce(function(a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);

                // set new total
                var set_new_quotation_total = $('input[name="quotation_total"]').val(
                    cal_quotation_total.toFixed(2)
                );

            });

            //function to get firm address in firm change
            $("#firm_name").on("change", function(e) {
                e.preventDefault();
                var firmId = $("#firm_name").val();
                var formData = {
                    firm_id: firmId,
                };
                $.ajax({
                    type: "POST",
                    url: firmURL,
                    data: formData,
                    dataType: "json",
                    success: function success(response) {
                        //push address from response in textarea
                        $("#firm_address").html(response.firm_details.address);
                    },
                });
            });

            // set all the fields as disabled if the product is not selected

            //on select product set packaging, nos and product tax
            $('.select-products').on('select2:select', function(e) {
                e.preventDefault();
                var product_id = $(this).val();
                var curr_row_id = $(this).parents("tr").attr("id");
                var formData = {
                    product_id: product_id,
                };
                $.ajax({
                    type: "POST",
                    url: productDetailsURL,
                    data: formData,
                    dataType: "json",
                    success: function success(response) {
                        var set_product_nos = $("#" + curr_row_id)
                            .children()
                            .find('input[id="quotation_product_nos[]"]')
                            .val(1);
                        var set_product_packaging = $("#" + curr_row_id)
                            .children()
                            .find('input[id="quotation_product_packaging[]"]')
                            .val(response.product_packaging);
                        var calc_quantity = parseInt(1) * parseInt(response.product_packaging);
                        var set_quantity = $("#" + curr_row_id)
                            .children()
                            .find('input[id="quotation_product_quantity[]"]')
                            .val(calc_quantity);
                        var set_product_tax = $("#" + curr_row_id)
                            .children()
                            .find('input[id="quotation_product_tax[]"]')
                            .val(response.product_tax);
                    },
                });
                // console.log(data);
            });

            //on product nos of pack input change quantity, product amounts, subtotal, tax calculation and Total calculation
            $('input[id="quotation_product_nos[]"]').on("input", function(e) {
                e.preventDefault();

                var curr_row_id = $(this).parents("tr").attr("id");

                var curr_product_nos = $("#" + curr_row_id)
                    .children()
                    .find('input[id="quotation_product_nos[]"]')
                    .val();

                if (isNaN(curr_product_nos)) {
                    curr_product_nos = 0;
                }

                var curr_product_packaging = $("#" + curr_row_id)
                    .children()
                    .find('input[id="quotation_product_packaging[]"]')
                    .val();

                //get current product tax
                var curr_product_tax = $("#" + curr_row_id)
                    .children()
                    .find('input[id="quotation_product_tax[]"]')
                    .val();

                if (isNaN(curr_product_packaging)) {
                    curr_product_packaging = 0;
                }

                var calc_quantity = parseInt(curr_product_nos) * parseInt(curr_product_packaging);
                var set_quantity = $("#" + curr_row_id)
                    .children()
                    .find('input[id="quotation_product_quantity[]"]')
                    .val(calc_quantity);

                var curr_price_per_pack = $("#" + curr_row_id)
                    .children()
                    .find('input[id="quotation_product_price[]"]')
                    .val();

                var calc_amount = parseFloat(curr_price_per_pack) * parseInt(calc_quantity);
                var calc_tax = (calc_amount * curr_product_tax) / 100;
                calc_amount += calc_tax;

                var set_product_amount = $("#" + curr_row_id)
                    .children()
                    .find('input[id="quotation_product_amount[]"]')
                    .val(calc_amount.toFixed(2));

                var initial_quotation_sub_total = 0;
                var initial_total_tax = 0;
                var initial_total_amount = 0;

                //get all product taxes
                // var product_taxes = $('input[name="quotation_product_tax[]"]')
                //     .map(function () {
                //         return $(this).val();
                //     })
                //     .get();

                //calculate new tax total
                // var cal_quotation_tax_total = product_taxes.reduce(function (a, b) {
                //     return parseFloat(a) + parseFloat(b);
                // }, 0);

                //set new tax total
                // var set_quotation_tax_total = $(
                //     'input[name="quotation_sub_total"]'
                // ).val(cal_quotation_tax_total.toFixed(2));

                // get initital sub total
                // initial_quotation_sub_total = $(
                //     'input[name="quotation_sub_total"]'
                // ).val();

                //get initial tax amount
                // initial_total_tax = $('input[name="quotation_tax"]').val();

                //get initial total amount
                initial_total_amount = $('input[name="quotation_total"]').val();

                if (!isNaN(calc_amount)) {
                    //get all product amounts
                    var product_amounts = $('input[name="quotation_product_amount[]"]')
                        .map(function() {
                            return $(this).val();
                        })
                        .get();
                    // console.log("current quotation sub total is: ",initial_quotation_sub_total);

                    //calculate new sub total with initial sub total
                    // var cal_quotation_sub_total = product_amounts.reduce(function (
                    //     a,
                    //     b
                    // ) {
                    //     return parseFloat(a) + parseFloat(b);
                    // },
                    // 0);

                    // set new sub total
                    // var set_quotation_sub_total = $(
                    //     'input[name="quotation_sub_total"]'
                    // ).val(cal_quotation_sub_total.toFixed(2));

                    //set new tax
                    // var calc_new_tax = (cal_quotation_sub_total * 0.18).toFixed(2);
                    // var set_new_tax = $('input[name="quotation_tax"]').val(
                    //     calc_new_tax
                    // );

                    // set new total
                    // var calc_new_total =
                    //     parseFloat(cal_quotation_sub_total.toFixed(2)) +
                    //     parseFloat(calc_new_tax);

                    // var set_new_tax = $('input[name="quotation_total"]').val(
                    //     calc_new_total.toFixed(2)
                    // );

                    //calculate new quotation total
                    var calc_new_quotation_total = product_amounts.reduce(function(
                            a,
                            b
                        ) {
                            return parseFloat(a) + parseFloat(b);
                        },
                        0);

                    // set new quotation total
                    var set_new_quotation_total = $('input[name="quotation_total"]').val(
                        calc_new_quotation_total.toFixed(2)
                    );

                } else {
                    // set new sub total
                    // var set_quotation_sub_total = $(
                    //     'input[name="quotation_sub_total"]'
                    // ).val(initial_quotation_sub_total.toFixed(2));

                    // set old tax value
                    // var set_old_tax = $('input[name="quotation_tax"]').val(
                    //     initial_total_tax.toFixed(2)
                    // );

                    //set old total amount
                    var set_old_total = $('input[name="quotation_total"]').val(
                        initial_total_amount.toFixed(2)
                    );
                }
            });

            //on product pack size input,change quantity
            $('input[id="quotation_product_packaging[]"]').on("input", function(e) {
                e.preventDefault();

                var curr_row_id = $(this).parents("tr").attr("id");
                var curr_product_nos = $("#" + curr_row_id)
                    .children()
                    .find('input[id="quotation_product_nos[]"]')
                    .val();

                if (isNaN(curr_product_nos)) {
                    var curr_product_nos = 0;
                }
                var curr_product_packaging = $("#" + curr_row_id)
                    .children()
                    .find('input[id="quotation_product_packaging[]"]')
                    .val();

                if (isNaN(curr_product_packaging)) {
                    curr_product_packaging = 0;
                }
                var calc_quantity =
                    parseInt(curr_product_nos) * parseInt(curr_product_packaging);
                var set_quantity = $("#" + curr_row_id)
                    .children()
                    .find('input[id="quotation_product_quantity[]"]')
                    .val(calc_quantity);

                var curr_price_per_pack = $("#" + curr_row_id)
                    .children()
                    .find('input[id="quotation_product_price[]"]')
                    .val();

                if (isNaN(curr_price_per_pack)) {
                    curr_price_per_pack = 0;
                }

                // var calc_amount =
                //     parseInt(curr_price_per_pack) * parseInt(curr_product_packaging);
                // var set_product_amount = $("#" + curr_row_id)
                //     .children()
                //     .find('input[id="quotation_product_amount[]"]')
                //     .val(calc_amount.toFixed(2));
            });

            //on product price per pack input, update product amount, product tax, subtotal, total tax calculation and Total calculation
            $('input[id="quotation_product_price[]"]').on("input", function(e) {
                e.preventDefault();

                var price_per_pack = 0;

                // add NaN check here
                if (!isNaN(e.target.value)) {
                    //get entered product per pack value
                    var price_per_pack = e.target.value;
                }

                //get current table row id
                var curr_row_id = $(this).parents("tr").attr("id");

                //get current product nos
                var curr_product_quantity = $("#" + curr_row_id)
                    .children()
                    .find('input[id="quotation_product_quantity[]"]')
                    .val();

                //get current product tax
                var curr_product_tax = $("#" + curr_row_id)
                    .children()
                    .find('input[id="quotation_product_tax[]"]')
                    .val();

                if (isNaN(curr_product_quantity)) {
                    var curr_product_quantity = 0;
                }

                // calculate product amount using current product packs and price per pack
                var calc_amount = parseFloat(price_per_pack) * parseInt(curr_product_quantity);
                var calc_tax = (calc_amount * curr_product_tax) / 100;
                calc_amount += calc_tax;

                // set calculate product amount for current row
                var set_product_amount = $("#" + curr_row_id)
                    .children()
                    .find('input[id="quotation_product_amount[]"]')
                    .val(calc_amount.toFixed(2));

                // console.log("On Product price "+ price_per_pack +" per pack for "+curr_product_nos+" packs change Product amount: "+calc_amount);

                // var initial_quotation_sub_total = 0;
                // var initial_total_tax = 0;
                var initial_total_amount = 0;

                // get initital sub total
                // initial_quotation_sub_total = $(
                //     'input[name="quotation_sub_total"]'
                // ).val();

                //get initial tax amount
                // initial_total_tax = $('input[name="quotation_tax"]').val();

                //get initial total amount
                initial_total_amount = $('input[name="quotation_total"]').val();

                if (!isNaN(calc_amount)) {
                    //get all product amounts
                    var product_amounts = $('input[name="quotation_product_amount[]"]')
                        .map(function() {
                            return $(this).val();
                        })
                        .get();
                    // console.log("current quotation sub total is: ",initial_quotation_sub_total);

                    //calculate new sub total with initial sub total
                    // var cal_quotation_sub_total = product_amounts.reduce(function (
                    //     a,
                    //     b
                    // ) {
                    //     return parseInt(a) + parseInt(b);
                    // },
                    // 0);

                    // set new sub total
                    // var set_quotation_sub_total = $(
                    //     'input[name="quotation_sub_total"]'
                    // ).val(cal_quotation_sub_total.toFixed(2));

                    //set new tax
                    // var calc_new_tax = (cal_quotation_sub_total * 0.18).toFixed(2);
                    // var set_new_tax = $('input[name="quotation_tax"]').val(
                    //     calc_new_tax
                    // );

                    // set new total
                    // var calc_new_total =
                    //     parseFloat(cal_quotation_sub_total.toFixed(2)) +
                    //     parseFloat(calc_new_tax);

                    //calculate new quotation total
                    var calc_new_quotation_total = product_amounts.reduce(function(
                            a,
                            b
                        ) {
                            return parseFloat(a) + parseFloat(b);
                        },
                        0);

                    // set new quotation total
                    var set_new_quotation_total = $('input[name="quotation_total"]').val(
                        calc_new_quotation_total.toFixed(2)
                    );

                } else {
                    // set old sub total
                    // var set_quotation_sub_total = $(
                    //     'input[name="quotation_sub_total"]'
                    // ).val(initial_quotation_sub_total.toFixed(2));

                    // set old tax value
                    // var set_old_tax = $('input[name="quotation_tax"]').val(
                    //     initial_total_tax.toFixed(2)
                    // );

                    //set old total amount
                    // var set_old_total = $('input[name="quotation_tax"]').val(
                    //     initial_total_amount.toFixed(2)
                    // );

                    //set old total amount
                    var set_old_total = $('input[name="quotation_total"]').val(
                        initial_total_amount.toFixed(2)
                    );
                }
            });
        });
    </script>
@endsection
