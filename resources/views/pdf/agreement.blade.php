<!DOCTYPE html>
<html>

<head>
    <title>Agreement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            border: 2px green solid;
            border-radius: 5px
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

        .quotation {
            page-break-after: always;
            margin-top: 100px;
            margin-bottom: 50px;
        }

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

        .benfit-cell {
            border: none !important;
            outline: none
        }

        .align-right{
            text-align: right
        }
    </style>
</head>

<body>
    {{-- @foreach ($quotationRequest->quotations as $quotation) --}}
        <div class="quotation">
            <div class="header">
                {{-- <img class="company-logo" src="data:image/jpeg;base64,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" alt="Company Logo"> --}}
                <h1>Ceylon Green Life Plantation (Pvt) Ltd</h1>
            </div>

            {{-- <h2>Agreement #{{ $quotation->quotation_number }}</h2> --}}
            <table class="details">
                {{-- <tr>
                    <th>Product</th>
                    <td>{{ $quotation->plan->name }}</td>
                </tr>
                <tr>
                    <th>Full Name</th>
                    <td>{{ $quotationRequest->title->name }} {{ $quotationRequest->first_name }}
                        {{ $quotationRequest->middle_name }} {{ $quotationRequest->last_name }}</td>
                </tr>
                @if (isset($quotationRequest->name_with_initials))
                    <tr>
                        <th>Name with Initials</th>
                        <td>{{ $quotationRequest->name_with_initials }}</td>
                    </tr>
                @endif
                @if (isset($quotationRequest->address))
                    <tr>
                        <th>Address</th>
                        <td>{{ $quotationRequest->address }}</td>
                    </tr>
                @endif
                @if (isset($quotationRequest->nic))
                    <tr>
                        <th>NIC</th>
                        <td>{{ $quotationRequest->nic }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Mobile Number</th>
                    <td>{{ $quotationRequest->mobile_number }}</td>
                </tr>
                @if (isset($quotationRequest->email))
                    <tr>
                        <th>Email</th>
                        <td>{{ $quotationRequest->email }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Landline Number</th>
                    <td>{{ $quotationRequest->landline_number }}</td>
                </tr>
                @if (isset($quotationRequest->email))
                    <tr>
                        <th>Email</th>
                        <td>{{ $quotationRequest->email }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Amount (LKR)</th>
                    <td>{{ number_format($quotation->amount, 2) }}</td>
                </tr>
                <tr>
                    <th>Duration</th>
                    <td>{{ $quotation->duration_text }}</td>
                </tr>
                <tr>
                    <th>Guaranteed Benefit</th>
                    <td>
                        <table style="width:100%">
                            @foreach ($quotation['benefits'] as $value)
                            <tr>
                                <td class="benfit-cell">{{ $value['name'] }} ({{ $value['rate'] }}%)</td>
                                <td class="benfit-cell"><span class="align-right">{{number_format($value['amount'], 2) }}</span></td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Expire Date</th>
                    <td>{{ $quotation->expire_date }}</td>
                </tr> --}}
            </table>

            <div class="footer">
                <p>Thank you for choosing us!</p>
                <p>Ceylong Green Life Plantation Pvt Ltd</p>
            </div>
        </div>
    {{-- @endforeach --}}
</body>

</html>
