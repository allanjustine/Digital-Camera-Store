@extends('normal-view.layout.base')

@section('title')
    | Register
@endsection

@section('content')
    <section class="bg-light p-3 p-md-4 p-xl-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xxl-11">
                    <div class="card border-light-subtle shadow-sm">
                        <div class="row g-0">
                            <div class="col-12 col-md-6">
                                <img class="img-fluid rounded-start w-100 h-100 object-fit-cover" loading="lazy"
                                    src="/images/loginbg2.jpeg" alt="">
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                                <div class="col-12 col-lg-11 col-xl-10">
                                    <div class="card-body p-3 p-md-4 p-xl-5">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-5">
                                                    <div class="text-center mb-4">
                                                        <a href="#">
                                                            <img src="/images/icon.png" alt="" width="175"
                                                                height="175">
                                                        </a>
                                                    </div>
                                                    <h4 class="text-center">We look forward to being a part of your
                                                        photography adventures.</h4>
                                                    @if (session('message'))
                                                        <div class="alert alert-success alert-dismissible fade show text-center"
                                                            role="alert">
                                                            {{ session('message') }}
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                                aria-label="Close"></button>
                                                        </div>
                                                    @endif
                                                    @if (session('error'))
                                                        <div class="alert alert-danger alert-dismissible fade show text-center"
                                                            role="alert">
                                                            {{ session('error') }}
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                                aria-label="Close"></button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="row gy-3 overflow-hidden">
                                                <div class="col-3 mb-4">
                                                    <div>
                                                        <img id="previewImg" src="/images/bg2.png"
                                                            style="width: 100px; height: 75px; border: 3px solid black;"
                                                            class="img-fluid rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="col-9 mb-4">
                                                    <div class="form-floating mb-3">
                                                        <input id="profile_image" type="file"
                                                            class="form-control pr-4 @error('profile_image') is-invalid @enderror"
                                                            name="profile_image" value="{{ old('profile_image') }}"
                                                            accept="image/*" autocomplete="profile_image" autofocus
                                                            onchange="previewImage(event)">
                                                        <label for="profile_image" class="form-label">Upload profile
                                                            picture</label>
                                                        @error('profile_image')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            name="email" id="email" placeholder="name@example.com"
                                                            value="{{ old('email') }}">
                                                        <label for="email" class="form-label">Email</label>
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            name="name" id="name" value="{{ old('name') }}"
                                                            placeholder="Full name">
                                                        <label for="name" class="form-label">Full name</label>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="number"
                                                            class="form-control @error('age') is-invalid @enderror"
                                                            name="age" id="age" value="{{ old('age') }}"
                                                            placeholder="Age">
                                                        <label for="age" class="form-label">Age</label>
                                                        @error('age')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating mb-3">
                                                        <select name="gender" id="gender"
                                                            class="form-select @error('gender') is-invalid @enderror"
                                                            name="gender" autocomplete="gender" autofocus>
                                                            <option selected hidden value="">Select Gender</option>
                                                            <option disabled>Select Gender</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                        <label class="form-label" for="gender">Gender</label>
                                                        @error('gender')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text"
                                                            class="form-control @error('address') is-invalid @enderror"
                                                            name="address" id="address" value="{{ old('address') }}"
                                                            placeholder="Address">
                                                        <label for="address" class="form-label">Address</label>
                                                        @error('address')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="number"
                                                            class="form-control @error('phone') is-invalid @enderror"
                                                            name="phone" id="phone" value="{{ old('phone') }}"
                                                            placeholder="Phone">
                                                        <label for="phone" class="form-label">Phone</label>
                                                        @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="date"
                                                            class="form-control @error('birthday') is-invalid @enderror"
                                                            name="birthday" id="birthday" value="{{ old('birthday') }}"
                                                            placeholder="Date of birth">
                                                        <label for="birthday" class="form-label">Date of birth</label>
                                                        @error('birthday')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password" id="password" value="{{ old('password') }}"
                                                            placeholder="Password">
                                                        <label for="password" class="form-label">Password</label>
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="password"
                                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                                            name="password_confirmation" id="password_confirmation"
                                                            value="{{ old('password_confirmation') }}"
                                                            placeholder="Confirm password">
                                                        <label for="password_confirmation" class="form-label">Confirm
                                                            password</label>
                                                        @error('password_confirmation')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                {{-- <div class="col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            name="remember_me" id="remember_me">
                                                        <label class="form-check-label text-secondary" for="remember_me">
                                                            Keep me logged in
                                                        </label>
                                                    </div>
                                                </div> --}}
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button class="btn btn-dark btn-lg" type="submit">Register
                                                            now</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row">
                                            <div class="col-12">
                                                <div
                                                    class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                                                    <a href="/register"
                                                        class="link-secondary text-decoration-none">Already have an
                                                        account</a>
                                                    <a href="#!" class="link-secondary text-decoration-none">Forgot
                                                        password</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


<style>
    .cascading-right {
        margin-right: -50px;
    }

    @media (max-width: 991.98px) {
        .cascading-right {
            margin-right: 0;
        }
    }

    .gradient-custom-2 {
        background: #fccb90;

        background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

        background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
    }

    @media (min-width: 768px) {
        .gradient-form {
            height: 100vh !important;
        }
    }

    @media (min-width: 769px) {
        .gradient-custom-2 {
            border-top-right-radius: .3rem;
            border-bottom-right-radius: .3rem;
        }
    }
</style>

<script>
    function previewImage() {
        const previewImg = document.getElementById('previewImg');
        previewImg.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
