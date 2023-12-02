@extends('admin.layout.base')

@section('title')
    | Logs
@endsection

@section('content')
    <div class="container">
        <h3 class="mb-4">Logs</h3>
        <table class="table table-bordered">
            <thead style="background-color: #BFACE0">
                <tr>
                    {{-- <th>Medicine ID</th> --}}
                    <th>Timestamp</th>
                    <th>Log Entry</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($logEntries as $logEntry)
                    <tr>
                        {{-- <td>{{ $med->id }}</td> --}}
                        <td>{{ $logEntry->formattedCreatedAt }}</td>
                        <td>{{ $logEntry->log_entry }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">
                            <h5 class="text-center">No logs yet.</h5>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        <div>
            {{ $logEntries->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection
