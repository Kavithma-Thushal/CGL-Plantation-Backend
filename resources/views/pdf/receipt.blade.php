<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            border: 2px solid #4CAF50;
            border-radius: 10px;
            background-color: #f9f9f9;
            padding: 20px;
            margin: 0;
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header, .footer {
            width: 100%;
            text-align: center;
        }

        .header > h1 {
            margin: 20px 0;
            font-size: 24px;
        }

        .footer {
            position: relative;
            margin-bottom: 10px;
            font-size: 14px;
            color: #777;
        }

        .content {
            padding-top: 20px;
            padding-left: 20px;
            padding-right: 20px;
        }

        .content > p {
            margin-bottom: 50px;
        }

        .logo {
            max-width: 100px;
            margin-top: 20px;
            margin-left: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #cdcdcd;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>

<body>
<div class="header">
    <img src="../public/images/company_logo.png" alt="Company Logo" class="logo">
    <h1>Payment Receipt</h1>
</div>

<div class="content">
    <p>This receipt serves as official confirmation of the payment made towards the Green Life. It outlines
        the essential terms of the agreement, including the contribution amount and relevant details related to the
        beneficiary.</p>

    <table>
        <tr>
            <th>Detail</th>
            <th>Information</th>
        </tr>
        <tr>
            <td>Receipt Number</td>
            <td>{{ $receiptRequest['receipt_number'] }}</td>
        </tr>
        <tr>
            <td>Reference Number</td>
            <td>{{ $receiptRequest['ref_number'] }}</td>
        </tr>
        <tr>
            <td>Amount</td>
            <td>LKR {{ $receiptRequest['amount'] }}</td>
        </tr>
        <tr>
            <td>Payment Method</td>
            <td>{{ $receiptRequest['payment_method'] }}</td>
        </tr>
        <tr>
            <td>Payment Date</td>
            <td>{{ $receiptRequest['payment_date'] }}</td>
        </tr>
    </table>
</div>

<div style="padding: 20px">
    <h3>Additional Information</h3>
    <p>For any inquiries related to this receipt or your plan, please contact our customer service:</p>
    <p><strong>Customer Service:</strong> 123-456-7890</p>
    <p><strong>Email:</strong> support@ceylongreenlife.com</p>

    <h3>Terms and Conditions:</h3>
    <p>1. This receipt is valid for one year from the date of payment.</p>
    <p>2. Any disputes related to this agreement should be raised within 30 days.</p>
    <p>3. The company reserves the right to amend the terms of the agreement.</p>
</div>

<div class="footer">
    <p>@ 2024 Ceylon Green Life Plantation. All rights reserved.</p>
</div>

</body>
</html>
