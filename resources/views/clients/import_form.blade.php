<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Import CSV File</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light py-5">

    <div class="container">
        <h2 class="mb-4">Import Clients from CSV</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('import_errors'))
            <div class="card mt-3">
                <div class="card-header bg-warning text-dark">Import Errors</div>
                <div class="card-body">
                    <ul>
                        @foreach (session('import_errors') as $row => $messages)
                            <li><strong>Row {{ $row }}:</strong> {{ implode(', ', $messages) }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session('duplicates'))
            <div class="card mt-3">
                <div class="card-header bg-warning text-dark">Duplicate Records (Existing in Database)</div>
                <div class="card-body">
                    <ul>
                        @foreach (session('duplicates') as $row => $msg)
                            <li><strong>Row {{ $row }}:</strong> {{ $msg }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('clients.import.csv') }}" enctype="multipart/form-data" class="mt-3">
            @csrf
            <div class="mb-3">
                <label class="form-label">Upload CSV File <strong><span class="text-danger"> *</span></strong></label>
                <input type="file" name="csv_file" class="form-control" required>
                @error('csv_file')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>

</body>

</html>
