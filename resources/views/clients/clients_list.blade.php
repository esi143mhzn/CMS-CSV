<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clients Report</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light py-5">

    <div class="container">
        <h2 class="mb-4">List of Clients Report</h2>
        <div class="buttons mb-2">
            <a href="{{ route('clients.export.csv') }}" class="btn btn-info">CSV Export</a>
            <button class="btn btn-warning">Filter</button>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $key => $client)
                    <tr>
                        <td>{{ $clients->firstItem() + $key }}</td>
                        <td>{{ $client->company_name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->phone_number }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {!! $clients->links('pagination::bootstrap-5') !!}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
