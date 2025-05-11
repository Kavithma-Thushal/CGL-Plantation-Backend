<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            border: 2px solid #4CAF50;
            border-radius: 10px;
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
            color: black;
            text-align: center;
        }

        .footer {
            position: relative;
            margin-bottom: 10px;
            font-size: 14px;
            color: #777;
        }

        .container {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
        }

        .container > p {
            margin: 10px 0;
            line-height: 1.6;
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
<div class="container">
    <div class="header">
        <img src="https://devcglp-admin.webmotech.com/assets/images/cgl/logo/main-logo.png" alt="Company Logo"
             STYLE="max-width: 100px;">
        <h1>Payment Receipt</h1>
    </div>

    <p>Dear {{ $customer->personalDetails->first()->getNameAttribute() }},</p>

    <p>Thank you for your payment. Below are the details of your package and remaining balance.</p>

    <table>
        <tr>
            <th>Detail</th>
            <th>Information</th>
        </tr>
        <tr>
            <td>Package Code</td>
            <td>{{ $package->job_code }}</td>
        </tr>
        <tr>
            <td>Plan</td>
            <td>{{ $package->plan->name }}</td>
        </tr>
        <tr>
            <td>Due Amount</td>
            <td>${{ $due_amount }}</td>
        </tr>
    </table>

    @if($due_amount > 0)
        <p>Please ensure the remaining balance is paid at your earliest convenience.</p>
    @endif

    <p>Thank you for choosing our services.</p>

    <p>Regards, {{ config('app.name') }}</p>

    <div class="footer">
        <p>@ 2024 Ceylon Green Life Plantation. All rights reserved.</p>
    </div>
</div>
</body>
</html>
