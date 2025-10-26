<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Clients Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-4">
  <div class="container">
    <h2 class="mb-4">Clients Report</h2>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="d-flex gap-2 mb-3">
      <!-- Export button includes current filter -->
      <a href="{{ route('clients.export.csv', ['filter' => request('filter', 'all')]) }}" class="btn btn-info">
        Export CSV
      </a>

      <!-- Link to duplicate management -->
      <a href="{{ route('duplicate-clients') }}" class="btn btn-warning">Manage Duplicates</a>

      <!-- Import form (file upload) -->
      <form action="{{ route('clients.import.csv') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 ms-auto">
        @csrf
        @error('csv_file')
          <small class="text-danger">{{ $message }}</small>
        @enderror
        <input type="file" name="csv_file" class="form-control form-control-sm" accept=".csv,text/csv" required>
        <button class="btn btn-primary btn-sm">Import CSV</button>
      </form>
    </div>

    <!-- Filter form -->
    <form method="GET" action="{{ route('list.clients') }}" class="mb-3">
      <div class="row g-2 align-items-center">
        <div class="col-auto">
          <select name="filter" class="form-select form-select-sm">
            <option value="all" {{ request('filter', 'all') === 'all' ? 'selected' : '' }}>All</option>
            <option value="duplicates" {{ request('filter') === 'duplicates' ? 'selected' : '' }}>Duplicates</option>
            <option value="unique" {{ request('filter') === 'unique' ? 'selected' : '' }}>Unique</option>
          </select>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-outline-secondary btn-sm">Apply</button>
        </div>
      </div>
    </form>

    <!-- Import errors -->
    @if(session('import_errors'))
      <div class="card mb-3 border-danger">
        <div class="card-header bg-danger text-white">Import Errors</div>
        <div class="card-body">
          <ul class="mb-0">
            @foreach(session('import_errors') as $row => $msgs)
              <li><strong>Row {{ $row }}:</strong> {{ implode(', ', $msgs) }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif

    <!-- Duplicates reported during last import -->
    @if(session('duplicates'))
      <div class="card mb-3 border-warning">
        <div class="card-header bg-warning">Duplicates Detected During Import</div>
        <div class="card-body">
          <ul class="mb-0">
            @foreach(session('duplicates') as $row => $msg)
              <li><strong>Row {{ $row }}:</strong> {{ $msg }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif

    <!-- Clients table -->
    <div class="card shadow-sm">
      <div class="card-body p-0">
        <table class="table table-striped mb-0">
          <thead class="table-dark">
            <tr>
              <th style="width: 70px;">S.N.</th>
              <th>Company Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th style="width: 110px;">Duplicate</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($clients as $key => $client)
              <tr>
                <td>{{ $clients->firstItem() + $key }}</td>
                <td>{{ $client->company_name }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->phone_number }}</td>
                <td>
                  @if($client->is_duplicate)
                    <span class="badge bg-warning text-dark">Yes</span>
                  @else
                    <span class="badge bg-success">No</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-3">No records found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="mt-3">
      {!! $clients->links('pagination::bootstrap-5') !!}
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
