<!DOCTYPE html>
<html>
<head>
    <title>Generate EMI Details Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 80px;
        }

        .message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }

        button {
            padding: 12px 25px;
            font-size: 18px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .columns-container {
            margin-top: 20px;
            display: inline-block;
            text-align: left;
        }

        .columns-container table {
            border-collapse: collapse;
            margin: 0 auto;
        }

        .columns-container th, .columns-container td {
            padding: 8px 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .columns-container th {
            background-color: #f2f2f2;
        }

    </style>
</head>
<body>

    <h1><strong>Generate EMI Details Table</strong></h1>

    @if(session('status'))
        <div class="message">{{ session('status') }}</div>
    @endif

    @if(session('columns'))
        <div class="columns-container">
            <h3>Created Columns:</h3>
            <table>
                <tr>
                    <th>#</th>
                    <th>Month Column</th>
                </tr>
                @foreach(session('columns') as $index => $column)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $column }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    <form method="POST" action="{{ route('process.data.submit') }}" style="margin-top: 30px;">
        @csrf
        <button type="submit">Process Data</button>
    </form>

</body>
</html>
