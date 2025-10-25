<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Duplicate Clients</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light py-5">

    <div class="container">
        <h2 class="mb-4">List of Duplicate Clients</h2>

        <div class="mb-3">
            <a href="{{ route('list.clients') }}" class="btn btn-secondary">Back to Clients</a>
        </div>

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

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>S.N.</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($duplicateClients as $key => $client)
                    <tr>
                        <td>{{ $duplicateClients->firstItem() + $key }}</td>
                        <td>{{ $client->company_name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->phone_number }}</td>
                        <td>
                            <div class="row col-md-6">
                                <div class="col-md-6">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editDuplicate{{ $client->id }}">Edit</button>
                                </div>
                                <div class="col-md-6">
                                <form action="{{ route('delete.duplicate-clients', $client->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure want you to delete?')">Delete</button>
                                </form>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="editDuplicate{{ $client->id }}" tabindex="-1"
                        aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('update.duplicate-clients', $client->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Duplicate Client</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Company Name <strong><span class="text-danger">
                                                        *</span></strong></label>
                                            <input class="form-control" type="text" name="company_name"
                                                value="{{ $client->company_name }}" id="" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email <strong><span class="text-danger">
                                                        *</span></strong></label>
                                            <input class="form-control" type="email" name="email" id=""
                                                value="{{ $client->email }}" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Phone Number <strong><span class="text-danger">
                                                        *</span></strong></label>
                                            <input class="form-control" type="text" name="phone_number"
                                                id="" value="{{ $client->phone_number }}" required />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {!! $duplicateClients->links('pagination::bootstrap-5') !!}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
