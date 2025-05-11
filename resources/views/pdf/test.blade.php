<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quotation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* border: 2px green solid; */
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

        .align-right {
            text-align: right
        }
    </style>
</head>

<body style="font-family: Arial, sans-serif;">
    @foreach ($quotationRequest->quotations as $quotation)
        <div class="quotation">
            <!-- Quotation Header -->
            <h1 style="text-align: center;">Quotation #{{ $quotation->quotation_number }}</h1>
            <p style="text-align: right;">Date: {{ $quotation->created_at->format('Y-m-d') }}</p>

            <!-- Company Details -->
            <table style="width: 100%; margin-bottom: 20px;">
                <tr>
                    <td>
                        <strong>Ceylon Green Life Plantation Pvt Ltd</strong><br>
                        428 Negombo,<br>
                        Colombo Main Rd, Seeduwa<br>
                        Contact: 0114 371 250<br>
                        Email: info@ceylongreenlifeplantation.com
                    </td>
                </tr>
            </table>

            <p>{{ $quotationRequest->title->name }}{{ $quotationRequest->first_name }}
                {{ $quotationRequest->middle_name }} {{ $quotationRequest->last_name }}</p>
            <p>Explore our investment options for sustainable plantation growth and potential returns.</p>

            <!-- Quotation Items -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #000; padding: 8px; text-align: left;">Product</th>
                        <th style="border: 1px solid #000; padding: 8px; text-align: left;">Duration</th>
                        <th style="width:150px; border: 1px solid #000; padding: 8px; text-align: right;">Amount (LKR)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #000; padding: 8px;">{{ $quotation->plan->name }}</td>
                        <td style="border: 1px solid #000; padding: 8px;">{{ $quotation->duration_text }}</td>
                        <td style="border: 1px solid #000; padding: 8px;text-align: right;">
                            {{ number_format($quotation->amount, 2) }}</td>
                    </tr>

                    <tr>
                        <td colspan="2" style="border: 1px solid #000; padding: 8px; text-align: right;">
                            <strong>Subtotal</strong>
                        </td>
                        <td style="width:150px; border: 1px solid #000; padding: 8px; text-align: right;">
                            {{ number_format($quotation->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: 1px solid #000; padding: 8px; text-align: right;">
                            <strong>Total</strong>
                        </td>
                        <td style="border: 1px solid #000; padding: 8px; text-align: right;">
                            <strong>{{ number_format($quotation->amount, 2) }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p>Please confirm this quotation at your earliest convenience. We appreciate your prompt attention to this
                matter and look forward to your continued support.</p>

            <!-- Signature -->
            <p>Best regards,</p>
            <p><strong>John Doe</strong><br>
                Owner, Ceylon Green Life Plantation Pvt Ltd</p>

            <!-- Footer -->
            <p class="footer" style="width: 100%; text-align:center;font-size:20px;color:rgb(44, 44, 44)"><i>Invest in
                    green today for a
                    sustainable tomorrow!</i>
        </div>
    @endforeach

</body>

</html>
