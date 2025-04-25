<!DOCTYPE html>
<html>
<head>
    <title>EMI Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

    </style>
</head>
<body>

    <h1><strong>EMI Details Data</strong></h1>

    @if(session('status'))
        <div class="message">{{ session('status') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Client ID</th>
                <!-- Dynamically display month columns -->
                @foreach($monthColumns as $column)
                    <th>{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($emiDetails as $emi)
                <tr>
                    <td>{{ $emi->clientid }}</td>
                    <!-- Dynamically display EMI values for each month -->
                    @foreach($monthColumns as $column)
                        <td>{{ number_format($emi->$column, 2) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
