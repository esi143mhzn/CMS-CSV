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
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
            <a href="{{ route('clients.export.csv', ['filter' => request('filter', 'all')]) }}" class="btn btn-secondary">CSV Export</a>
            <form action="{{ route('list.clients') }}" method="GET" class="d-flex align-items-center gap-2">
                <select name="filter" class="form-select" style="width: 180px;">
                    <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="duplicates" {{ request('filter') == 'duplicates' ? 'selected' : '' }}>Duplicate</option>
                    <option value="unique" {{ request('filter') == 'unique' ? 'selected' : '' }}>Unique</option>
                </select>
                <button type="submit" class="btn btn-warning">Filter</button>
            </form>
            <a href="{{ route('list.clients') }}" class="btn btn-primary">Reset</a>
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
            {!! $clients->appends(request()->query())->links('pagination::bootstrap-5') !!}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
