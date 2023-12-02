@extends('admin.layout.base')

@section('title')
    | Users
@endsection

@section('content')
    <div class="container">
        <h3 class="mb-4">Users</h3>
        <div class="col-sm-12">
            <a href="/admin/users/create" class="btn btn-primary mb-3 me-2 float-end">
                <i class="fa-solid fa-user-plus"></i> Add User
            </a>
            <form action="{{ route('admin.users.search') }}" method="GET">
                @csrf
                <input type="search" name="search" class="form-control mb-3 mx-2 float-start" style="width: 198px;"
                    placeholder="Search">
                <button class="btn btn-primary"><i class="far fa-magnifying-glass"></i></button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>ID.</th>
                        <th>Profile Picture</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Mobile Number</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Birthday</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <img style="width: 40px; height: 40px; margin-top: -10px;" class="rounded-circle border"
                                    src="{{ $user->profile_image === null && $user->gender === 'Male'
                                        ? url('images/profile-image.png')
                                        : ($user->profile_image === null && $user->gender === 'Female'
                                            ? url('images/profile-image2.png')
                                            : Storage::url($user->profile_image)) }}"
                                    alt="">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->age }}</td>
                            <td>{{ $user->gender }}</td>
                            <td>{{ $user->birthday }}</td>
                            <td>
                                @foreach ($user->roles as $role)
                                    @if ($role->id === 1)
                                        <span class="badge rounded-pill text-bg-primary">Admin</span>
                                    @break

                                @else
                                    <span class="badge rounded-pill text-bg-warning">User</span>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @if ($user->email_verified_at != null)
                                <span class="badge rounded-pill text-bg-info text-white">Verified</span>
                            @else
                                <span class="badge rounded-pill text-bg-danger text-white">Not Verified</span>
                            @endif
                        </td>
                        <td>
                            <a href="/admin/users/update/{{ $user->id }}" class="btn btn-primary mb-1"><i
                                    class="far fa-pen-to-square"></i> Edit</a>
                            <a href="#" class="btn btn-danger mb-1" data-bs-toggle="modal"
                                data-bs-target="#delete{{ $user->id }}"><i class="far fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                    @include('admin.users.delete')
                @empty
                    <tr>
                        <td colspan="12" class="text-center">
                            No data found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
