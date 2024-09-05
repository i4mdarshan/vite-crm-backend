{{-- <div style="page-break-after: auto;"> --}}
    @php
        use Carbon\Carbon;
    @endphp
    <!DOCTYPE html>
    <html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <head>
        <title>{{ ucwords($order_details->client_name)."_".$order_details->order_no }}</title>
        <style type="text/css">
            body {
                font-size: 44px !important;
                /* margin-top: 520px !important; */
                font-family: 'Verdana' !important;
                margin-right: 30px;
                margin-left: 30px;
            }

            p {
                padding: 2px !important;
                margin: 2px !important;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }
            table td {
                border-top: 1px solid #000;
                border-right: 1px solid #000;
                border-bottom: 1px solid #000;
                border-left: 1px solid #000;
                padding: 10px;
            }

            th {
                background-color: #D3D3D3;
                text-align: left;
            }

            .border-none{
                border-top: 0px;
                border-left: 1px solid #000 !important;
                border-right: 1px solid #000 !important;
                border-bottom: 0px;
            }

            .row {
                display: flex;
                box-sizing: border-box;
            }

            .col-1 {
                flex: 0 0 50%;
                padding: 0.1em;
                display: inline-block;
            }

            .col-2 {
                flex: 0 0 50%;
                padding: 0.1em;
                /*display: inline-block;*/
            }

            .content td {
                border-top: 0px solid transparent !important;
                border-bottom: 0px solid transparent !important;
            }

            .declarations {
                display: flex;
                box-sizing: border-box;
                width: 100%;
                margin-top: 3px;
                font-family: 'Verdana' !important;
            }

            .declarations-table td,
            tr {
                padding: 2px !important;
                margin: 2px !important;
                font-family: 'Verdana' !important;
            }

            .title{
                text-align: center;
            }

            .inr-sign::before{
                font-size: 54px !important;
                font-family: "DejaVu Sans; sans-serif";
                content:"\20B9";
            }

            .border-0 {
                border: 0px;
            }
            
            .page_break {
                page-break-before: always;
            }

            footer { 
                position: fixed; 
                bottom: 20px; 
                left: 0px; 
                right: 0px;
                height: 20px; 
            }

        </style>
    </head>

    <body>
        <div class="row">
            <div class="title">
                <h2 class="head">{{ str_replace('_',' ',strtoupper("sales_order")) }}</h2>
            </div>
            <table class="border" style="height: 80%;">
                <tr>
                    <td width="50%">Firm <br><strong>{{ ucwords($order_details->firm_name) }}</strong></td>
                    <td width="10%" style=" text-align: center;"><strong>{{$order_details->order_no}}</strong></td>
                    <td width="16.5%" style=" text-align: center;">Dated</td>
                    <td width="23.5%" style=" text-align: center;"><strong>{{ date('j F, Y',strtotime($order_details->order_date)) }}</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" width="50%">Address <br><strong>{!! nl2br(e($order_details->firm_address)) !!}</strong></td>
                    {{-- <td rowspan="3" width="50%">Address <br><strong>{!! nl2br(e(str_replace('__','&#13;',$order_details->firm_address))) !!}</strong></td> --}}
                    <td width="35%" style=" text-align: left;">Payment Type</td>
                    <td colspan="2" width="15%" style=" text-align: left;"><strong>{{str_replace('_',' ',ucwords($order_details->payment_type))}}</strong></td>
                </tr>
                <tr>
                    <td width="35%" style=" text-align: left;">Sales Person Name</td>
                    <td colspan="2" width="15%" style=" text-align: left;"><strong>{{ ucwords($order_details->employee->full_name) }}</strong></td>
                </tr>
                <tr>
                    <td width="35%" style=" text-align: left;">Dispatch Thru</td>
                    <td colspan="2" width="15%" style=" text-align: left;"><strong>{{ strtoupper($order_details->transport) }}</strong></td>
                </tr>
                <tr>
                    <td width="50%">Client <br><strong>{{ ucwords(str_replace('_', ' ', $order_details->client_name)) }}</strong></td>
                    <td width="16.5%">Terms of Delivery </td>
                    <td colspan="2">
                        <strong>
                            {{ ucwords(str_replace('_',' ',$order_details->term_of_supply)) }}
                            <br>
                            {{$order_details->payment_condition." ".ucwords($order_details->payment_time)." ".ucwords($order_details->payment_type)}}
                        </strong>
                    </td>
                </tr>
                <tr>
                    {{-- <td width="50%">Address <br><strong>{!! nl2br(e(str_replace('__','&#13;', $order_details->client_address))) !!}</strong></td> --}}
                    <td rowspan="3" width="50%">Address <br><strong>{{ ucwords(str_replace('_', ' ', $order_details->client_address)) }}</strong></td>
                    <td width="16.5%">Destination </td>
                    <td colspan="2"><strong>{{$order_details->booking_destination}}</strong></td>
                </tr>
                <tr>
                    <td width="35%" style=" text-align: left;">Dispatch Date</td>
                    <td colspan="2" width="15%" style=" text-align: left;"><strong>{{ date('j F, Y',strtotime($order_details->dispatch_date)) }}</strong></td>
                </tr>
                <tr>
                    <td width="35%" style=" text-align: left;">Dispatch Status</td>
                    <td colspan="2" width="15%" style=" text-align: left;"><strong>{{ ucwords($order_details->dispatch_status) }}</strong></td>
                </tr>
                <tr>
                    <td colspan="4" class="border" style="padding: 0px !important;">
                        <?php $count = 1; ?>
                        @foreach($order_details->particulars->chunk(17) as $chunk)
                            <div class="particulars-table">
                            <table class="border">
                                <tr>
                                    <td style=" text-align: center;" width="5%"><strong>Sr.No</strong></td>
                                    <td style=" text-align: center;" width="30%"><strong>Particular</strong></td>
                                    <td style=" text-align: center; word-wrap: break-word;" width="10%"><strong>Nos of Product</strong></td>
                                    <td style=" text-align: center;" width="10%"><strong>Packaging</strong></td>
                                    <td style=" text-align: center;" widht="10%"><strong>Qty</strong></td>
                                    <td style=" text-align: center;" width="12.5%"><strong>Price Per Unit (INR)</strong></td>
                                    <td style=" text-align: center;" width="5%"><strong>GST (%)</strong></td>
                                    <td style=" text-align: center;" width="17.5%"><strong>Amount (INR)</strong></td>
                                </tr>
                                @if ($order_details->particulars)

                                    @foreach ($chunk as $particular)
                                        <tr>

                                            <td class="border-none" style=" text-align: center; vertical-align: top;">
                                                <strong>
                                                    {{ $count }}
                                                </strong>
                                            </td>

                                            <td class="border-none" style=" text-align: left;">
                                                <strong>
                                                    {{ ucwords($particular->product_name) }}
                                                </strong>
                                                <br>
                                                <small><i>HSN: {{ $particular->product_hsn }}</i></small>
                                            </td>

                                            <td class="border-none" style=" text-align: center; vertical-align: top;">
                                                {{ $particular->product_nos }}
                                            </td>

                                            <td class="border-none" style=" text-align: center; vertical-align: top;">
                                                <strong>
                                                    {{ $particular->product_packaging." ".ucwords(str_replace('_',' ',$particular->unit->name)) }}
                                                </strong>
                                            </td>

                                            <td class="border-none" style=" text-align: center; vertical-align: top;">
                                                {{ $particular->product_quantity." ".ucwords(explode('_',$particular->unit->name)[0]) }}
                                            </td>
                                            <td class="border-none" style=" text-align: left; vertical-align: top;">
                                                {{ number_format($particular->product_price,2) }}
                                            </td>
                                            <td class="border-none" style=" text-align: left; vertical-align: top;">
                                                {{ $particular->product_gst }}
                                            </td>
                                            <td class="border-none" style="text-align: left; vertical-align: top;">
                                                <strong>
                                                    <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ number_format($particular->product_amount,2) }}
                                                </strong>
                                            </td>

                                        </tr>
                                        <?php $count++ ?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="border-none" style=" text-align: center;"><strong></strong></td>
                                        <td class="border-none" style=" text-align: center;"></td>
                                        <td class="border-none" style=" text-align: center;"></td>
                                        <td class="border-none" style=" text-align: center;"></td>
                                        <td class="border-none" style=" text-align: center;"></td>
                                        <td class="border-none" style=" text-align: center;"></td>
                                        <td class="border-none" style=" text-align: center;"></td>
                                        <td class="border-none" style=" text-align: center;"><strong></strong></td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        {{-- <div style="page-break-before: always !important;"></div> <!-- break page --> --}}
                        
                    @endforeach

                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="border" style="padding: 0px !important;">
                        <table class="border">
                            {{-- <tr>
                                <td style="border-left: 0px; border-right: 0px; text-align: left; vertical-align: top;" width="30%"></td>
                                <td style="border-left: 0px; border-right: 0px; text-align: left; vertical-align: top;" width="42%"></td>
                                <td class="border-none" style="border-bottom: 1px solid #000; padding-top: 10px !important; text-align: left; vertical-align: center; font-size: 50px !important;" width="12.5%">
                                    <strong>
                                        Sub Total
                                    </strong>
                                </td>
                                <td class="border-none" style="border-bottom: 1px solid #000; padding: 0px 0px 0px 10px !important; text-align: left; vertical-align: center; font-size: 50px !important;" width="18%">
                                    <strong>
                                        <span class="inr-sign">
                                            {{ number_format($order_details->order_sub_total,2) }}
                                        </span>
                                    </strong>
                                </td>
                            </tr> --}}
                            {{-- <tr>
                                <td style="border-left: 0px; border-right: 0px; text-align: left; vertical-align: top;" width="30%"></td>
                                <td style="border-left: 0px; border-right: 0px; text-align: left; vertical-align: top;" width="42%"></td>
                                <td class="border-none" style="border-bottom: 1px solid #000; padding-top: 10px !important; text-align: left; vertical-align: center; font-size: 50px !important;" width="12.5%">
                                    <strong>
                                        Tax ({{ $order_details->order_tax_percent }}%)
                                    </strong>
                                </td>
                                <td class="border-none" style="border-bottom: 1px solid #000; padding: 0px 0px 0px 10px !important; text-align: left; vertical-align: center; font-size: 50px !important;" width="18%">
                                    <strong>
                                        <span class="inr-sign">
                                            {{ number_format($order_details->order_tax,2) }}
                                        </span>
                                    </strong>
                                </td>
                            </tr> --}}
                            <tr>
                                <td style="border-left: 0px; border-right: 0px; text-align: left; vertical-align: top;" width="30%"></td>
                                <td style="border-left: 0px; border-right: 0px; text-align: left; vertical-align: top;" width="42%"></td>
                                <td class="border-none" style="border-bottom: 1px solid #000; padding-top: 10px !important; text-align: left; vertical-align: center; font-size: 50px !important;" width="12.5%">
                                    <strong>
                                        Total
                                    </strong>
                                </td>
                                <td class="border-none" style="border-bottom: 1px solid #000; padding: 0px 0px 0px 10px !important; text-align: left; vertical-align: center; font-size: 50px !important;" width="18%">
                                    <strong>
                                        <span class="inr-sign">
                                            {{ number_format($order_details->order_total,2) }}
                                        </span>
                                    </strong>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="page-break-inside: avoid !important;">
                    <td colspan="4" class="border" style="font-size: 50px !important; word-wrap: break-word; max-width: 1px;">
                        Amount Chargeable (in words):
                        <br>
                        <span> 
                            <strong>
                                INR {{ ucwords($amount_chargeable_in_words) }}
                            </strong>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="border">
                        Special Note:
                        <br>
                        <span> 
                            <strong>
                                {{ $order_details->remarks ? $order_details->remarks : 'NA' }}
                            </strong>
                        </span>
                    </td>
                </tr>
                <tr rowspan="2">
                    <td colspan="2" class="border">
                        Company's Bank Details
                        <br>
                        <table class="border-0">
                            <tr>
                                <td class="border-0">
                                    Bank Name
                                </td>
                                <td class="border-0">: <strong>{{ ucwords($order_details->firm_bank_name) }}</strong></td>
                            </tr>
                            <tr>
                                <td class="border-0">
                                    A/c No.
                                </td>
                                <td class="border-0">: <strong>{{ $order_details->firm_bank_account_no }}</strong></td>
                            </tr>
                            <tr>
                                <td class="border-0">
                                    Branch & IFSC Code
                                </td>
                                <td class="border-0">: <strong>{{ $order_details->firm_branch_name." & ".$order_details->firm_bank_ifsc }}</strong></td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="2">
                        For {{ ucwords($order_details->firm_name) }} ({{ Carbon::createFromDate($order_details->order_date)->format('Y').'-'.Carbon::createFromDate($order_details->order_date)->addYear()->format('Y') }})
                        <br>
                        <br>
                        <br>
                        <p>Authorised Signatory</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="vertical-align: bottom;">
                        Declaration
                        <br>
                        <strong>
                            We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.
                        </strong>
                    </td>
                    <td colspan="2">
                        Sales Person Details
                        <table class="border-0" style="width: 100%;">
                            <tr>
                                <td class="border-0" style="word-wrap: break-word; max-width: 1px;">
                                    <strong>{{ ucwords($order_details->employee->full_name) }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-0">
                                    <strong>{{ ucwords($order_details->employee->user_detail->personal_phone_no_1) }}</strong>
                                </td>

                            </tr>
                            <tr>
                                <td class="border-0"  style="word-wrap: break-word; max-width: 1px;">
                                    <strong>{{ $order_details->employee->email }}</strong>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="border-0" colspan="4">
                        <div style="margin-top: 10px; width: 100%; text-align:center;">
                            <span style="font-size: 46px !important;">
                                <i>This is a computer generated document confirming values mentioned above.</i>
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <footer>
            <div style="display: flex; flex-direction: reverse; margin-top: 10px; width: 100%;">
                <span style="font-size: 46px !important;">
                    <i>Printed By: {{ ucwords(Auth::user()->full_name) }} on {{ date("j-F-Y h:i:s") }}</i>
                </span>
            </div>
        </footer>

    </body>

    </html>

{{-- </div> --}}
