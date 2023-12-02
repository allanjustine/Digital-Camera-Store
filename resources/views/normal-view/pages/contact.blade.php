@extends('normal-view.layout.base')

@section('title')
    | Contact Us
@endsection

@section('content')
    <div class="container-fluid px-5 my-5">
        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card border-0 rounded-3 shadow-lg overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-sm-6 d-none d-sm-block bg-image"></div>
                            <div class="col-sm-6 p-4">
                                <div class="text-center">
                                    <div class="h3 fw-light">Contact Us</div>
                                    <p class="mb-4 text-muted">Fell free to send a feedback with us.</p>
                                </div>


                                <form action="{{ route('feedback') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Name Input -->
                                    <div class="form-floating mb-3">
                                        <input class="form-control @error('name') is-invalid @enderror"
                                            value="@auth {{ auth()->user()->name }} @else {{ old('name') }} @endauth"
                                            @auth readonly @endauth autocomplete="name" name="name" type="text"
                                            placeholder="Name">
                                        <label for="name">Name</label>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Email Input -->
                                    <div class="form-floating mb-3">
                                        <input class="form-control @error('email') is-invalid @enderror"
                                            value="@auth {{ auth()->user()->email }} @else {{ old('email') }} @endauth"
                                            @auth readonly @endauth autocomplete="email" name="email" id="email"
                                            type="email" placeholder="Email Address">
                                        <label for="email">Email Address</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Message Input -->
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control @error('message') is-invalid @enderror" autocomplete="message" name="message"
                                            id="message" type="text" placeholder="Message" style="height: 10rem;">{{ old('message') }}</textarea>
                                        <label for="message">Message</label>

                                        @error('message')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Submit button -->
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg" id="submitButton"
                                            type="submit">Submit</button>
                                    </div>
                                </form>
                                <!-- End of contact form -->

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .bg-image {
        background-image: url('/images/bg.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
</style>
