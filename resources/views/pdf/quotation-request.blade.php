<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quotation</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            /* border: 2px green solid; */
            /* background-image: url("{{ public_path('images/background.jpg') }}"); */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 5px
        }

        @page {
            margin: 25px;
        }

        .header,
        .footer {
            width: 100%;
            text-align: center;
            position: fixed;
        }

        .header {
            top: 0;
            width: 100%;
            table-layout: fixed;
        }

        .footer {
            bottom: 0;
        }

        .header-row{
            position: relative; 
            text-align: center;
        }

        .logo{
            width: 150px;
            height:  100px;
            /* background-image: url("{{ public_path('images/company_logo.jpg') }}"); */
            /* background-size :contain;
            background-position: center;
            background-repeat: no-repeat; */
        }

        .address{
            margin-top: -35px
        }

        .line-height{
            line-height: 25px;
        }

        .header-row h1{
            margin-top: 65px
        }

        .quotation {
            /* page-break-after: always; */
            height: 1000px;
            /* border: solid 1px rgba(8, 138, 8, 0.404) */
            /* margin-top: 100px;
            margin-bottom: 50px; */
            /* border: solid 1px green; */
        }

        /* .quotation:not(:last-child) {
            page-break-after: always;
        } */

        .quotation h2 {
            text-align: center;
        }

        .details {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .details th,
        .details td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .details th {
            background-color: #f2f2f2;
        }
       
        th {
            background-color: #40916c;
            color: white
        }
        th:first-child {
           border-radius: 5px 0 0 0;
        }
        
        th:last-child {
           border-radius: 0 5px 0 0;
        }

        .table-bakcground {
            background-color: #40916d1a;
        }
       
        .table-row {
            border-bottom: solid 1px #03502dc4
        }


        .benfit-cell {
            border: none !important;
            outline: none
        }

        .align-right {
            text-align: right
        }
    </style>
</head>

<body style="font-family: Arial, sans-serif;">
    @foreach ($quotationRequest->quotations as $quotation)
        <div class="quotation">
            <!-- Quotation Header -->
            <div class="header-row">
                <div class="logo" style="position: absolute; left: 0;">
                    <!-- Logo image or content goes here -->
                </div>
                <h1 style="display: inline-block;">Quotation #{{ $quotation->quotation_number }}</h1>
            </div>
            
            <p style="text-align: right;">Date: {{ $quotation->created_at->format('Y-m-d') }}</p>

            <!-- Company Details -->
            <table style="width: 100%; margin-bottom: 20px;">
                <tr>
                    <td>
                        <p class="address line-height">
                        <strong>Ceylon Green Life Plantation Pvt Ltd</strong><br>
                        428 Negombo,<br>
                        Colombo Main Rd, Seeduwa<br>
                        Contact: 0114 371 250<br>
                        Email: info@ceylongreenlifeplantation.com
                        </p>
                    </td>
                </tr>
            </table>

            <p>{{ $quotationRequest->title->name }}{{ ucFirst($quotationRequest->first_name) }}
                {{ ucFirst($quotationRequest->middle_name) }} {{ ucFirst($quotationRequest->last_name) }}</p>
            <p>Explore our investment options for sustainable plantation growth and potential returns.</p>

            <!-- Quotation Items -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th style="padding: 8px; text-align: left;">Product</th>
                        <th style="padding: 8px; text-align: left;">Duration</th>
                        <th style="width:150px; padding: 8px; text-align: right;">Amount (LKR)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-row">
                        <td class="table-bakcground" style="padding: 8px;">{{ $quotation->plan->name }}</td>
                        <td class="table-bakcground" style="padding: 8px;">{{ $quotation->duration_text }}</td>
                        <td class="table-bakcground" style="padding: 8px;text-align: right;">
                            {{ number_format($quotation->amount, 2) }}</td>
                    </tr>
                   
                    @if(isset($quotation['benefits']))
                    <tr>
                        <td colspan="3">
                            <h4 style="margin:8px 0px">Guaranteed Yearly Benefits</h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table style="width: 60%;">
                                <tbody>
                                    @if(in_array($quotation->plan->planTemplate->id ,[3,4]))
                                    <tr>
                                        <td style="padding: 4px 8px;">{{ $quotation['benefits']['name'] }}
                                        </td>
                                        <td style="padding: 4px 8px;text-align:right;">
                                            {{ number_format($quotation['benefits']['amount'], 2) }}</td>
                                    </tr>
                                    @else
                                    @foreach ($quotation['benefits'] as $value)
                                        <tr>
                                            <td style="padding: 4px 8px;">{{ $value['name'] }} ({{ $value['rate'] }}%)
                                            </td>
                                            <td style="padding: 4px 8px;text-align:right;">
                                                {{ number_format($value['amount'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endif

                    @if(isset($quotation['profits']['name']))
                    <tr>
                        <td colspan="3">
                            <h4 style="margin:8px 0px">Guaranteed Profit</h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table style="width: 60%;">
                                <tbody>
                                    @if(in_array($quotation->plan->planTemplate->id ,[3]))
                                    <tr>
                                        <td style="padding: 4px 8px;">{{ $quotation['profits']['name'] }}
                                        </td>
                                        <td style="padding: 4px 8px;text-align:right;">
                                            {{ number_format($quotation['profits']['amount'], 2) }}</td>
                                    </tr>
                                    @else
                                        @foreach ($quotation['profits'] as $value)
                                            <tr>
                                                <td style="padding: 4px 8px;">{{ $value['name'] }} ({{ $value['rate'] }}%)
                                                </td>
                                                <td style="padding: 4px 8px;text-align:right;">
                                                    {{ number_format($value['amount'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endif

                    @if(isset($quotation['capital_return']['name']))
                    <tr>
                        <td colspan="3">
                            <h4 style="margin:8px 0px">Maturity</h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table style="width: 60%;">
                                <tbody>
                                    @if(in_array($quotation->plan->planTemplate->id ,[3]))
                                    <tr>
                                        <td style="padding: 4px 8px;">{{ $quotation['capital_return']['name'] }}
                                        </td>
                                        <td style="padding: 4px 8px;text-align:right;">
                                            {{ number_format($quotation['capital_return']['amount'], 2) }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <p class="line-height">Please confirm this quotation at your earliest convenience. We appreciate your prompt attention to this
                matter and look forward to your continued support.</p>

            <!-- Signature -->
            <p>Best regards,</p>
            <p class="line-height"><strong>John Doe</strong><br>
                Owner, Ceylon Green Life Plantation Pvt Ltd</p>

            <!-- Footer -->
            <p class="footer" style="width: 100%; text-align:center;font-size:20px;color:rgb(44, 44, 44)"><i>Invest in
                    green today for a
                    sustainable tomorrow!</i>
        </div>
    @endforeach
</body>

</html>
