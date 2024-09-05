<div style="page-break-after: auto;">
    @php
        use Carbon\Carbon;
    @endphp
    <!DOCTYPE html>
    <html>

    <head>
        <title>Invoice</title>
        <style type="text/css">
            body {
                font-size: 42px !important;
                /* margin-top: 520px !important; */
                font-family:'"Franklin Gothic Medium", "Franklin Gothic", "ITC Franklin Gothic", Arial, sans-serif' !important;
                font-weight: 400; 
                /* line-height: 20px !important; */
                margin-right: 30px;
                margin-left: 30px;
            }

            p {
                padding: 2px !important;
                margin: 2px !important;
            }

            table,
            th,
            td {
                border: 1px solid #000000;
                border-collapse: collapse;
            }

            td {
                padding: 5px;
            }

            th {
                background-color: #D3D3D3;
                text-align: left;
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

            .h1{
                font-size: 60px !important;
                font-weight: 800 !important;
                padding: 0px !important ;
                margin: 0px !important;
            } 

            .invoice-to {
                padding-bottom: 250px !important;
                
            }

            .border-no
            {
                border: none !important;
            }

        </style>
    </head>

    <body>
        <div class="row">
            <table style="width: 100%;" class="border-no">
                        <tr class="border-no">
                            <td class="border-no">
                                <h1 class="h1">Anjali Chemicals,</h1>
                                604,Shiv Parvati Apartment,<br>
                                House No.2023,Near Pyarelal Prajapati Hall,<br>
                                Sector -1,Airoli,Navi Mumbai-400708 <br>
                                Maharashtra, India <br>
                                Contact No .: 9326337723 /8425849806
                            </td>
                            <td style= 'text-align:center;' class="border-no">
                                <h1 class="h1">PROFORMA INVOICE</h1>
                            </td>       
                        </tr> 
                        <tr class="border-no">
                            <td class="invoice-to border-no" rowspan="2">
                                <strong>Proforma Invoice To</strong>
                            </td>
                            <td class="border-no">
                                <strong>Date</strong>
                            </td>
                        </tr>
                        <tr class="border-no">
                            
                            <td class="border-no">
                                <strong>Proforma Invoice No:</strong>
                            </td>
                        </tr>                                               
            </table>
        </div>    
        <div class="row" style="margin-top:50px;">
            <table style="width: 100%;">
                    <tr>
                        <td colspan="5" >
                            <strong>Comments or Special Instructions</strong>
                        </td>
                    </tr>
                    <tr >
                         <td colspan="5"><br><br><br><br><br></td>
                    </tr>
            </table>
        </div>
        <div class="row" style="margin-top:50px;">
            <table style="width: 100%;">
                        <tr>
                            <td width="20%" style=" text-align: center;"><strong>Salesperson</strong></td>
                            <td width="20%" style=" text-align: center;"><strong>P.I Number</strong></td>
                            <td width="20%" style=" text-align: center;"><strong>Ship Date</strong></td>
                            <td width="20%" style=" text-align: center;"><strong>Delivery Point</strong></td>
                            <td width="20%" style=" text-align: center;"><strong>Terms/Payment<strong></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
            </table>
        </div>
        <div class='row' style="margin-top:50px;">
            <table style='width:100%;'>
                        <tr>
                            <td width="20%" style=" text-align: center;"><strong>Quantity</strong></td>
                            <td width="20%" style=" text-align: center;"><strong>Description</strong></td>
                            <td width="20%" style=" text-align: center;"><strong>Unit Price</strong></td>
                            <td width="20%" style=" text-align: center;"><strong>Taxable</strong></td>
                            <td width="20%" style=" text-align: center;"><strong>Amount</strong></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>                       
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>      
            </table>
        </div>
        <div class='row' style="margin-top:50px;">
            <table class="border-no" width="40%;" style="float:right;">
                <tr>
                    <td class="border-no">Subtotal</td>
                    <td >INR</td>
                </tr>
                <tr>
                    <td class="border-no">GST Tax Rate</td>
                    <td >INR</td>
                </tr>
                <tr>
                    <td class="border-no" style="width:50% ">GST Tax</td>
                    <td >INR</td>
                </tr>
                <tr>

                    <td class="border-no" >Local Forwarding</td>
                    <td >INR</td>
                </tr>
                <tr>
                    <td class="border-no" >Total</td>
                    <td>INR</td>
                </tr>
            </table>
            <table class="border-no" width="100%;">
                <tr class="border-no">
                    <td class="border-no">
                        Terms & Condition <br>
                        Payments: 100 % advance. <br>
                        Delivery: Colour chemicals will be dispatch from Bhiwandi<br>
                        Transportation: Transportation will be borne by Customer.<br>
                        Bank details: Anjali Chemicals, IDBI Bank,<br> A/c No.:0367102000003322, <br> Branch Airoli, IFSC Code: IBKL0000367 <br>
                        Total amount in words : <br>
                    </td>
                </tr>
            </table>    
        </div>


        <div style="padding-top: 50px; width: 100%;">
            <span style="font-size: 46px !important;">
                <i>This is a computer generated document confirming values mentioned above.</i>
            </span>
        </div>

        <div style="padding-top:50px; width: 100% ;">
            <i style="font-size: 32px !important">Generated by:</i> <br>
            <i style="font-size: 32px !important">Edited by:</i>
        </div>

        <!-- <div class="row" style="margin-top: 150px;">
            <table style="width: 100%; border: 5px solid #000;">
                        <tr>
                            <td colspan="3" width="20%"style=" text-align: center;"><strong>QUOTATION</strong></td>
                            <td colspan="2" style=" text-align: center;"><strong>Date</strong></td>
                            <td style=" text-align: center;" >{{ date('d/m/Y') }}</td>
                            <td colspan="1" ><strong>Order No.</strong>&nbsp;&nbsp;&nbsp;&nbsp;Q18727</td>
                        </tr>
                        <tr >
                            <td colspan="2"width="20%"><strong>Sales Person Name</strong></td>
                            <td colspan="3" width="40%"></td>
                            <td width="20%"><strong>Dispatch Date</strong></td>
                            <td width="20%"  ></td>
                        </tr>
                        <tr>
                            <td colspan="2" width="20%"><strong>Billing in which firm</strong></td>
                            <td colspan="3" >&nbsp;&nbsp;</td>
                            <td ><strong>Status of Dispatch</strong></td>
                            <td colspan="1" ></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width:20%"><strong>Client name</strong></td>
                            <td colspan="5" style="width:60%"></td>
                        </tr>
                        <tr>
                            <td colspan="2" width="20%"><strong>Transport</strong></td>
                            <td colspan="3" style="width:30%"></td>
                            <td style="width:20%"><strong>Local Forwarding</strong></td>
                            <td colspan="1" style="width:20%"></td>
                        </tr>
                        <tr>
                            <td colspan="2" width="20%"><strong>Booking Destination</strong></td>
                            <td colspan="3" style="width:30%"></td>
                            <td ><strong>Amount of LF</strong></td>
                            <td colspan="1"  style="width:20%"></td>
                        </tr>

                        <tr>
                            <td style=" text-align: center;"><strong>Sr.No</strong></td>
                            <td style=" text-align: center;" width="25%"><strong>Particular</strong></td>
                            <td style=" text-align: center;"><strong>Nos</strong></td>
                            <td style=" text-align: center;"><strong>Packing</strong></td>
                            <td style=" text-align: center;"><strong>Quantity</strong></td>
                            <td style=" text-align: center;"><strong>Price</strong></td>
                            <td style=" text-align: center;"><strong>Tax</strong></td>
                        </tr>

                        <tr>
                            <td style=" text-align: center;"><strong>1</strong></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                        </tr>

                        <tr>
                            <td style=" text-align: center;"><strong>2</strong></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                        </tr>

                        <tr>
                            <td style=" text-align: center;"><strong>3</strong></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                        </tr>

                        <tr>
                            <td style=" text-align: center;"><strong>4</strong></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                        </tr>

                        <tr>
                            <td style=" text-align: center;"><strong>5</strong></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                        </tr>

                        <tr>
                            <td style=" text-align: center;"><strong>6</strong></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                            <td style=" text-align: center;"></td>
                        </tr>

                        <tr>
                            <td colspan="2" ><strong>Term of Supply(Transport Payment)</strong></td>
                            <td colspan="2" style=" text-align: center;"><strong>To Pay</strong></td>
                            <td colspan="2" style=" text-align: center;"><strong>Approximate Invoice Total</strong></td>
                            <td colspan="1" style=" text-align: center;" ><strong>INR</strong></td>
                        </tr>

                        <tr>
                            <td colspan="2"><strong>Payment Condition</strong></td>
                            <td colspan="3"></td>
                            <td colspan="2"></td>
                        </tr>

                        <tr>
                            <td colspan="2"><strong>Outstanding Details</strong></td>
                            <td colspan="3"></td>
                            <td ><strong>No. of Invoice</strong></td>
                            <td colspan="1"></td>
                        </tr>

                        <tr>
                            <td colspan="7"><strong>Remark :</strong></td>
                        </tr>
                        
                        <tr>
                            <td colspan="7">&nbsp;</td>
                        </tr>

                        <tr>
                            <td colspan="7">&nbsp;</td>
                        </tr>

                        <tr>
                            <td colspan="7">&nbsp;</td>
                        </tr>

                        <tr>
                            <td colspan="2"><strong>Check Point 1</strong></td>
                            <td colspan="2"><strong>Dt.</strong></td>
                            <td colspan="2"><strong>Check Point 2</strong></td>
                            <td colspan="1"><strong>Dt.</strong></td>
                        </tr>                          
            </table>
        </div>


        <div style="padding-top: 50px; width: 100%;">
            <span style="font-size: 46px !important;">
                <i>This is a computer generated document confirming values mentioned above.</i>
            </span>
        </div> -->
    </body>

    </html>

</div>
