<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quotation</title>
    <style>

        body {
            font-family: Arial, sans-serif;
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
            height: 1000px;
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

        .keys{
            font-weight: 500
        }
    </style>
</head>

<body style="font-family: Arial, sans-serif;">
        <div class="quotation">
            <!-- Quotation Header -->
            <div class="header-row">
                <h1 style="display: inline-block;">Shedule </h1>
            </div>
            
            <p style="text-align: left;">Product: {{ $userPackage['plan_name'] }}</p>
            <p style="text-align: right; margin-top:-50px">Agreement No : {{$userPackage['job_code']}}</p>

            <div class="details">
                <p class="keys">Full Name: {{ $userPackage['full_name'] }}</p>
                <p class="keys">Name with Initials: {{ $userPackage['name_with_initials'] }}</p>
                <p class="keys">Address: {{ $userPackage['address'] }}</p>
                <p class="keys">NIC No: {{ $userPackage['nic'] }}</p>
                <p class="keys">Name of beneficiary: {{ $userPackage['beneficiary_name'] }}</p>
                {{-- <p class="keys">Date of commencement of this agreement: {{ $userPackage['beneficiary_name'] }}</p>
                <p class="keys">Date of Termination of this agreement: {{ $userPackage['beneficiary_name'] }}</p> --}}
                <p class="keys">Contribution Amount: {{ number_format($userPackage['total_amount'],2) }}</p>
                <p class="keys">Term: {{ $userPackage['term'] }}</p>
                {{-- <p class="keys">Mode of Payment: Single</p>
                <p class="keys">Monthly Harvest Income: It’s mentioned in this structure.</p>
                <p class="keys">Monthly Harvest Due Date: </p>
                <p class="keys">Allocated extent of the Land: </p>
                <p class="keys">No. of allocated guava Plants: </p> --}}
                <p class="keys">Security method: Legal Agreement</p> 

                {{-- <p><em>Payment of the Harvest will commence from '31st August 2024'</em></p> --}}
            </div>
</body>

</html>
