@extends('admin.layout.base')

@section('title')
    | User Update
@endsection

@section('content')
    <div class="container">
        <h3 class="mb-4">Update user</h3>
        <div class="d-flex justify-content-center">
            <div class="card col-md-7">
                <div class="card-body px-4 py-5 px-md-5">
                    <form method="POST" action="{{ route('admin.user.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <input type="text" id="name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $user->name }}" autocomplete="name" autofocus />
                                    <label class="form-label" for="name">Full name</label>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <input type="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $user->email }}" autocomplete="email" autofocus />
                                    <label class="form-label" for="email">Email address</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <input type="text" id="address"
                                        class="form-control @error('address') is-invalid @enderror" name="address"
                                        value="{{ $user->address }}" autocomplete="address" autofocus />
                                    <label class="form-label" for="address">Address</label>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <input type="number" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ $user->phone }}" autocomplete="phone" autofocus />
                                    <label class="form-label" for="phone">Phone Number</label>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <input type="number" id="age"
                                        class="form-control @error('age') is-invalid @enderror" name="age"
                                        value="{{ $user->age }}" autocomplete="age" autofocus />
                                    <label class="form-label" for="age">Age</label>
                                    @error('age')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <select name="gender" id="gender"
                                        class="form-select @error('gender') is-invalid @enderror" autocomplete="gender"
                                        autofocus>
                                        <option value="" selected disabled>Select Gender</option>
                                        <option value="Male" @if ($user->gender == 'Male') selected @endif>Male
                                        </option>
                                        <option value="Female" @if ($user->gender == 'Female') selected @endif>Female
                                        </option>
                                    </select>
                                    <label class="form-label" for="gender">Gender</label>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <input type="date" id="birthday"
                                        class="form-control @error('birthday') is-invalid @enderror" name="birthday"
                                        value="{{ $user->birthday }}" autocomplete="birthday" autofocus />
                                    <label class="form-label" for="birthday">Date of birth</label>
                                    @error('birthday')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <select name="roles" id="roles"
                                        class="form-select @error('roles') is-invalid @enderror" name="roles"
                                        autocomplete="roles" autofocus>
                                        <option selected hidden value="">Select Roles</option>
                                        <option disabled>Select Roles</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                @if ($user->roles->first()->name == $role->name) selected @endif>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label" for="roles">Roles</label>
                                    @error('roles')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-outline mb-4">
                            <input id="profile_image" type="file"
                                class="form-control pr-4 @error('profile_image') is-invalid @enderror"
                                name="profile_image" value="{{ old('profile_image') }}" accept="image/*"
                                autocomplete="profile_image" autofocus onchange="previewImage(event)">
                            <label for="profile_image">Update profile picture</label>
                            @error('profile_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-center align-items-center mb-4">
                            <img id="previewImg"
                                src="{{ $user->profile_image === null && $user->gender === 'Male'
                                    ? url('images/profile-image.png')
                                    : ($user->profile_image === null && $user->gender === 'Female'
                                        ? url('images/profile-image2.png')
                                        : Storage::url($user->profile_image)) }}"
                                style="width: 80px; height: 80px; border: 3px solid black;"
                                class="img-fluid rounded-circle">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Update user
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function previewImage() {
        const previewImg = document.getElementById('previewImg');
        previewImg.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
