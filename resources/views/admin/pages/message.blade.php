@extends('admin.layout.base')

@section('title')
    | Messages
@endsection

@section('content')
    <div class="container">
        <h3 class="mb-4">Messages</h3>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>ID.</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->message }}</td>
                            <td>{{ $contact->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Theres no messages yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $contacts->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
