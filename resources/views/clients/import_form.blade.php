<form action="{{ route('clients.import.csv') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 ms-auto">
    @csrf
    @error('csv_file')
        <small class="text-danger">{{ $message }}</small>
    @enderror
    <input type="file" name="csv_file" class="form-control form-control-sm" accept=".csv,text/csv" required>
    <button class="btn btn-primary btn-sm">Import CSV</button>
</form>