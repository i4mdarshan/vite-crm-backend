@extends('layouts.app')

@section('title', 'Sales Transactions')

@section('content')
    <div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ route('manage_quotations') }}" class="btn btn-primary px-3">
                        <span class="h3"><i class="ni ni-bold-left mr-2" style="font-size: 14px; vertical-align: middle;"></i>Sales Transactions</span>
                    </a>
                </div>
            </div>
        </div>
        {{-- @dd($quotation_details) --}}
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 d-flex justify-content-md-between mb-3"
                                style="justify-content: space-between;">
                                <div>
                                    <h1 class="mb-0">{{ucwords(str_replace('_',' ',$quotation_details->quotation_type))}} Detail</h1>
                                </div>
                                <div>
                                    <a href="{{ route('downloadPdf_quotations',['quotation_id' => $quotation_details->id, 'old' => 0]) }}" target="_blank"
                                        class="btn btn-md btn-primary" id="view_quotation" data-toggle="tooltip"
                                        data-placement="top" title="Print">
                                        <i class="fas fa-print" style="font-size: 12px;"></i> Print
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row m-3">
                            <div class="col-md-5">
                                {{-- <h2 class="mb-1">Tenant Details</h2> --}}
                                <table class="border-0">
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Type &nbsp;</h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ ucwords(str_replace('_',' ',$quotation_details->quotation_type))}}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Dated &nbsp;</h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ date('F j, Y',strtotime($quotation_details->created)) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Firm &nbsp;</h4>
                                        </td>
                                        {{-- <td style="vertical-align: top;">:</td> --}}
                                        <td style="vertical-align: top;">:&nbsp;{{ ucwords(str_replace('_', ' ', $quotation_details->firm_name)) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Address &nbsp;:</h4>
                                        </td>
                                        {{-- <td style="vertical-align: top;">:</td> --}}
                                        <td class="px-2" style="vertical-align: top;">
                                            {!! nl2br(e(str_replace('__','<br>',$quotation_details->firm_address)));  !!}
                                        </td>
                                        {{-- <td rowspan="2" style="vertical-align: top;">: 
                                            <p>
                                                
                                            </p>
                                        </td> --}}
                                    </tr>
                                    <tr>
                                        
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Name &nbsp;</h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ ucwords($quotation_details->employee->full_name) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Email &nbsp;</h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ $quotation_details->employee->email }}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Contact &nbsp;</h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ ucwords($quotation_details->employee->user_detail->personal_phone_no_1) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-6">
                                {{-- <h2 class="mb-1">Invoice Details</h2> --}}
                                <table class="border-0">
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Invoice No. &nbsp;</h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ $quotation_details->quotation_no }}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Client Firm &nbsp;</h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ ucwords(str_replace('_', ' ', $quotation_details->client_name)) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Address &nbsp;:</h4>
                                        </td>
                                        <td class="px-2" style="vertical-align: top;">
                                            {!! nl2br(e(str_replace('__','<br>',$quotation_details->client_address)));  !!}
                                        </td>
                                        {{-- <td style="white-space: normal; word-wrap: break-word; vertical-align: top;">: 
                                            {!! nl2br(e(str_replace('__','<br>',$quotation_details->client_address))) !!}
                                        </td> --}}
                                    </tr>
                                    {{-- <tr>
                                        <td colspan="2">
                                            {{$quotation_details->client_address}}
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Dispatch Status &nbsp;</h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ ucwords($quotation_details->dispatch_status) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Dispatch Date &nbsp;</h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ date('F j, Y',strtotime($quotation_details->dispatch_date)) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Booking Destination &nbsp;</h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ ucwords($quotation_details->booking_destination) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0">Transport &nbsp;</h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ $quotation_details->transport }}</td>
                                    </tr>
                                    
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table align-items-center">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 10vw; white-space: normal;" scope="col">Sr No.</th>
                                                <th style="width: 20vw; white-space: normal;" scope="col">Particular</th>
                                                <th style="width: 11vw; white-space: normal; word-wrap: break-word; text-align: center;" scope="col">Nos of Product</th>
                                                <th style="width: 13vw; white-space: normal; text-align: center;" scope="col">Packaging</th>
                                                <th style="width: 13vw; white-space: normal; text-align: center;" scope="col">Quantity </th>
                                                <th style="width: 15vw; white-space: normal; text-align: center;" scope="col">Price Per Unit</th>
                                                <th style="width: 13vw; white-space: normal; text-align: center;" scope="col">GST (%)</th>
                                                <th style="width: 18vw; white-space: normal; text-align: center;" scope="col">Amount (INR)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($quotation_details->particulars)
                                                @foreach ($quotation_details->particulars as $particular)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td style="white-space: normal;word-wrap: break-word;">
                                                            <h4 class="p-0 m-0">
                                                                {{ ucwords($particular->product_name) }} <br/>
                                                                <small>
                                                                    <i>
                                                                        HSN: {{ $particular->product_hsn }}
                                                                    </i>
                                                                </small>
                                                            </h4>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <h4 class="p-0 m-0">
                                                                {{ $particular->product_nos }}
                                                            </h4>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <h4 class="p-0 m-0">
                                                                {{ $particular->product_packaging." ".ucwords(str_replace('_',' ',$particular->unit->name)) }}
                                                            </h4>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <h4 class="p-0 m-0">
                                                                {{ $particular->product_quantity." ".ucwords(explode('_',$particular->unit->name)[0]) }}
                                                            </h4>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <h4 class="p-0 m-0">
                                                                Rs. {{ number_format($particular->product_price,2) }}/-
                                                            </h4>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <h4 class="p-0 m-0">
                                                                {{ $particular->product_gst }}
                                                            </h4>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <h4 class="p-0 m-0">
                                                                Rs. {{ number_format($particular->product_amount,2) }}/-
                                                            </h4>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else

                                            <tr>
                                                <td>No Records Available</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 px-4 py-3">
                                <h3 class="mb-2"><b>Total in Words: </b><span>INR {{ ucwords($amount_chargeable_in_words) }}</span></h3>
                            </div>
                            <div class="col-md-4 px-3 py-3">
                                <table class="border-0">
                                    {{-- <tr>
                                        <td>
                                            <h3 class="mb-0"><b>Sub Total&nbsp;</b></h3>
                                        </td>
                                        <td>: Rs. {{ number_format($quotation_details->quotation_sub_total,2) }}/-</td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td>
                                            <h3 class="mb-0"><b>Tax (18 %) &nbsp;</b></h3>
                                        </td>
                                        <td>: Rs. {{ number_format($quotation_details->quotation_tax,2) }}/-</td>
                                    </tr> --}}
                                    <tr>
                                        <td>
                                            <h2 class="mb-0"><b>Total (in INR)&nbsp;</b></h2>
                                        </td>
                                        <td><h3 class="mb-0">: Rs. {{ number_format($quotation_details->quotation_total,2) }}/-</h3></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            {{-- <div class="col-md-1"></div> --}}
                            <div class="col-md-12 px-4 py-3">
                                <h3 class="mb-1" style="border-bottom: 1px solid #c8cace; max-width: 150px;"><b>Payment Terms: </b></h3>
                                <table class="border-0 table-fixed">
                                    <tr>
                                        <td  style="width: 30%; vertical-align: top;">
                                            <h4 class="mb-0"><b>Term Of supply (Transport Payment )</b> &nbsp;</h4>
                                        </td>
                                        <td style="width: 70%; vertical-align: top;">: {{ ucwords(str_replace('_',' ',$quotation_details->term_of_supply)) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0"><b>Payment Condition &nbsp;</b></h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{$quotation_details->payment_condition." ".ucwords($quotation_details->payment_time)." ".ucwords($quotation_details->payment_type)}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 px-4 pb-3">
                                <table class="border-0">
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0"><b>Special Note &nbsp;:</b></h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100%;">{{($quotation_details->remarks) ? $quotation_details->remarks : 'NA' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7 px-4 pb-3">
                                <h3 class="mb-1" style="border-bottom: 1px solid #c8cace; max-width: 300px;"><b>Company's Bank Details: </b></h3>
                                <table class="border-0">
                                    <tr>
                                        <td>
                                            <h4 class="mb-0"><b>Bank Name &nbsp;<br></h4>
                                        </td>
                                        <td>: {{ ucwords($quotation_details->firm_bank_name) }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4 class="mb-0"><b>A/c No. &nbsp;</b></h4>
                                        </td>
                                        <td>: {{$quotation_details->firm_bank_account_no}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4 class="mb-0"><b>Branch & IFSC Code &nbsp;</b></h4>
                                        </td>
                                        <td>: {{ $quotation_details->firm_branch_name." & ".$quotation_details->firm_bank_ifsc }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-5 px-4 pb-3">
                                <h3 class="mb-1" style="border-bottom: 1px solid #c8cace; max-width: 300px;"><b>Authorised Signatory: </b></h3>
                                <table class="border-0">
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0"><b>Sales Person Name &nbsp;<br></h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ ucwords($quotation_details->employee->full_name) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0"><b>Contact &nbsp;</b></h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ $quotation_details->employee->user_detail->personal_phone_no_1 }}</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <h4 class="mb-0"><b>Email Id &nbsp;</b></h4>
                                        </td>
                                        <td style="vertical-align: top;">: {{ $quotation_details->employee->email }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



