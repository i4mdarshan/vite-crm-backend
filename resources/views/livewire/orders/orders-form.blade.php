{{-- @section('select2_css')
    <!-- Select 2 -->
    <link href="{{ asset('assets/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endsection --}}

<div>
    <form action="{{ route('saveOrder_customers',$customer_id) }}" method="POST">
        @csrf
        <div class="m-3">

            {{-- Session error messages --}}
            <div class="row mx-2">
                <div class="col-md-12 col-xs-12">
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>    
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                </div>
                {{-- <div class="col-md-6 col-xs-12">
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="quotation_type">Type</label>
                        <select name="quotation_type"
                            class="form-control @error('quotation_type') is-invalid @enderror" id="quotation_type">
                            <option value="">Choose Status</option>
                            <option value="quotation">Quotation</option>
                            <option value="proforma_invoice">Proforma Invoice</option>
                            <option value="sample_request">Sample Request</option>
                            <option value="pending_order_form">Pending Order Form</option>
                        </select>
                        @error('quotation_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> --}}
            </div>

            {{-- Date and Order No. --}}
            <div class="row mx-2">
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="order_date">Date</label>
                        <input type="date" name="order_date" min="{{ now()->format('Y-m-d') }}" max="{{now()->format('Y-m-d') }}"
                            class="form-control @error('order_date') is-invalid @enderror" id="order_date"
                            value="{{ now()->format('Y-m-d') }}" readonly>
                        @error('order_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="order_no">Order No</label>
                        <input type="text" name="order_no"
                            class="form-control @error('order_no') is-invalid @enderror" id="order_no"
                            value="00000" readonly>
                        @error('order_no')
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
                        <label for="client_name">Client Name</label>
                        <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror" id="client_name" placeholder="Client Name">
                        @error('client_name')
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
                            class="form-control @error('sales_person_name') is-invalid @enderror" id="sales_person_name"
                            value="{{ ucwords(Auth()->user()->full_name) }}" readonly>
                        @error('sales_person_name')
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
                        <label for="dispatch_date">Dispatch Date</label>
                        <input type="date" name="dispatch_date" min="{{ now()->format('Y-m-d') }}" class="form-control @error('dispatch_date') is-invalid @enderror" id="dispatch_date">
                        @error('dispatch_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="dispatch_status">Dispatch Status</label>
                        <select name="dispatch_status"
                            class="form-control @error('dispatch_status') is-invalid @enderror" id="dispatch_status">
                            <option value="">Choose Status</option>
                            <option value="pending">Pending</option>
                            <option value="hold">Hold</option>
                            <option value="dispatch">Dispatch</option>
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
                        <input type="text" name="transport" class="form-control @error('transport') is-invalid @enderror" id="transport"
                            placeholder="Transport">
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
                            class="form-control @error('booking_destination') is-invalid @enderror" id="booking_destination"
                            placeholder="Booking Destination">
                        @error('booking_destination')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Local Forwarding Amount --}}
            <div class="row mx-2">
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="local_forwarding">Local Forwarding</label>
                        <select name="local_forwarding"
                            class="form-control @error('local_forwarding') is-invalid @enderror" id="local_forwarding" wire:model="local_forwarding" wire:change="setLf()">
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
                        <input type="number" min="0" name="amount_of_lf" class="form-control @error('amount_of_lf') is-invalid @enderror" id="amount_of_lf" wire:model="amount_of_lf" {{ ($this->local_forwarding == "no" || $this->local_forwarding == "") ? "readonly" : "" }} >
                        @error('amount_of_lf')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            
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
                    <table class="table" id="main">
                        <thead class="thead-light">
                            <tr>
                                {{-- <th scope="col">Sr No.</th> --}}
                                <th style="width: 25%" scope="col">Particular</th>
                                <th style="width: 16%" scope="col">Nos</th>
                                <th style="width: 11%" scope="col">Packing</th>
                                <th style="width: 11%" scope="col">Quantity</th>
                                <th style="width: 20%" scope="col">Price</th>
                                <th style="width: 11%" scope="col">Tax(in %)</th>
                                <th style="width: 5%" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            {{-- {{print_r($orderedProducts)}} --}}
                            @foreach ($orderedProducts as $index=>$ordered_product)
                                <tr>
                                    {{-- Select Products dropdown --}}
                                    <td>
                                        <div class="form-group">
                                            <select 
                                            name="orderedProducts[{{$index}}][product_id]"
                                            class="form-control form-control-sm @error('orderedProducts.{{$index}}.product_id') is-invalid @enderror" 
                                            wire:model="orderedProducts.{{$index}}.product_id"
                                            wire:change="updateProductPrice(event.target.value)">
                                                <option value="na_{{$index}}">Select Product</option>
                                                @foreach ($active_products as $product)
                                                    <option value="{{$product->id."_".$index}}">
                                                        {{ ucwords($product->product_name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('orderedProducts.{{$index}}.product_id')
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
                                                <button wire:click.prevent="incrementProductNos({{$index}})" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>

                                                <input 
                                                type="number" 
                                                min="0" 
                                                name="orderedProducts[{{$index}}][product_nos]"
                                                class="form-control form-control-sm @error('orderedProducts.{{$index}}.product_nos') is-invalid @enderror"
                                                wire:model="orderedProducts.{{$index}}.product_nos">

                                                <button wire:click.prevent="decrementProductNos({{$index}})" class="btn btn-danger btn-sm ml-2"><i class="fas fa-minus"></i></button>
                                            </div>
                                            @error('orderedProducts.{{$index}}.product_nos')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </td>
                                    {{-- Input for packing --}}
                                    <td>
                                        <div class="form-group">
                                            <input 
                                                type="number" 
                                                min="0"
                                                name="orderedProducts[{{$index}}][product_packaging]"
                                                class="form-control form-control-sm @error('orderedProducts.{{$index}}.product_packaging') is-invalid @enderror"
                                                wire:model="orderedProducts.{{$index}}.product_packaging">
                                            @error('orderedProducts.{{$index}}.product_packaging')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </td>
                                    {{-- Input for quantity --}}
                                    <td>
                                        <div class="form-group">
                                            <input 
                                                type="number" 
                                                min="0"
                                                name="orderedProducts[{{$index}}][product_quantity]"
                                                class="form-control form-control-sm @error('orderedProducts.{{$index}}.product_quantity') is-invalid @enderror"
                                                wire:model="orderedProducts.{{$index}}.product_quantity"
                                                placeholder="0">
                                            @error('orderedProducts.{{$index}}.product_quantity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </td>
                                    {{-- Input for price --}}
                                    <td>
                                        <div class="form-group">
                                            <input 
                                                type="text" 
                                                min="0" 
                                                name="orderedProducts[{{$index}}][product_price]"
                                                class="form-control form-control-sm @error('orderedProducts.{{$index}}.product_price') is-invalid @enderror"
                                                wire:model="orderedProducts.{{$index}}.product_price">
                                            @error('orderedProducts.{{$index}}.product_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </td>
                                    {{-- Input for tax --}}
                                    <td>
                                        <div class="form-group">
                                            <input 
                                                type="number" 
                                                min="0" 
                                                name="orderedProducts[{{$index}}][product_tax]" 
                                                class="form-control form-control-sm @error('product_tax.' . $index) is-invalid @enderror" wire:model="orderedProducts.{{$index}}.product_tax">
                                            @error('product_tax.' . $index)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <button class="remRow btn btn-sm btn-danger" type="button"
                                            wire:click.prevent="removeProduct({{$index}})">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="8">
                                    <button class="btn btn-md btn-secondary"
                                        wire:click.prevent="addProduct({{ $index }})" id="button-add" type="button"
                                        style="width: 100%">
                                        <i class="fas fa-plus-circle" style="font-size: 12px"></i>&nbsp;Add Item
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Term of Supply and approximate total line --}}
            <div class="row m-3">
                <div class="col-md-3 col-sm-12">
                    <h4>Term Of supply (Transport Payment ) :</h4>
                </div>
                <div class="col-md-3 col-sm-12">
                    {{-- <div class=""> --}}
                    <div class="form-group">
                        <select name="term_of_supply" class="form-control form-control-sm @error('term_of_supply') is-invalid @enderror">
                            <option value="to_pay">To Pay</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                    {{-- </div> --}}
                </div>
                <div class="col-md-3 col-sm-12">
                    <h4>Approximate Invoice Total <br> (in INR):</h4>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="form-group">
                        {{-- {{ var_dump($this->calcTotalOfOrder()) }} --}}
                        <input class="form-control form-control-sm @error('order_total') is-invalid @enderror" type="text" name="order_total" id="order_total" value="{{ number_format($this->calcTotalOfInvoice()) }}" readonly>
                    </div>
                </div>
            </div>

            {{-- Payment condition line --}}
            <div class="row m-3">
                <div class="col-md-3 col-sm-12">
                    <h4>Payment Condition :</h4>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="form-group">
                        <input type="number" min="0" name="payment_condition" class="form-control form-control-sm @error('payment_condition') is-invalid @enderror"
                            placeholder="0">
                        @error('payment_condition')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="form-group">
                        <select class="form-control form-control-sm @error('payment_time') is-invalid @enderror" name="payment_time">
                            <option value="">Choose Payment Time</option>
                            <option value="days">Days</option>
                            <option value="weeks">Weeks</option>
                            <option value="months">Months</option>
                            <option value="immediate">Immediate</option>
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
                        <select class="form-control form-control-sm @error('payment_type') is-invalid @enderror" name="payment_type">
                            <option value="">Choose Payment Type</option>
                            <option value="credit">Credit</option>
                            <option value="advance">Advance</option>
                            <option value="pdc">PDC</option>
                        </select>
                        @error('payment_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Remarks line --}}
            <div class="row m-3">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="remarks" class="h4">Remarks :</label>
                        <textarea type="text" name="remarks" rows="4"
                            class="form-control form-control-sm @error('remarks') is-invalid @enderror"
                            placeholder="Enter Remarks"></textarea>
                        @error('remarks')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Submit Preview Buttons --}}
            <div class="row m-2">
                <div class="col-md-12 col-sm-12 d-flex justify-content-md-end mb-3"
                    style="justify-content: space-between;">
                    {{-- <div class="card-footer border-0"> --}}
                    <button class="btn btn-secondary" id="addInvoice" type="submit">
                        <i class="fas fa-eye" style="font-size: 12px;"></i> Preview
                    </button>
                    <button class="btn btn-primary" id="addInvoice" type="submit">
                        <i class="fas fa-check" style="font-size: 12px;"></i> Save
                    </button>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </form>

</div>

{{-- @section('custom_scripts')
    <!-- Select 2 -->
    <script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.particulars-dropdown').select2();
            // $('#particulars-dropdown').on('change', function (e) {
            //     var data = $('#particulars-dropdown').select2("val");
            //     @this.set('particular', data);
            // });

        });
    </script>
@endsection --}}
