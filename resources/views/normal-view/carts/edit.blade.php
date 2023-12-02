@extends('normal-view.layout.base')

@section('title')
    | Update Cart
@endsection

@section('content')
    <div class="container py-5">
        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show text-center mt-5" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex py-3">
                        <h5 class="mb-0">Cart item</h5>
                    </div>
                    <div class="card-body">
                        <!-- Single item -->
                        <div class="row">
                            <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                <!-- Image -->
                                <div class="bg-image hover-overlay hover-zoom ripple rounded ml-5"
                                    data-mdb-ripple-color="light">
                                    <div id="carouselExample{{ $cart->product->id }}" class="carousel slide">
                                        <div class="carousel-inner">
                                            @if (is_array($cart->product->product_image))
                                                @foreach ($cart->product->product_image as $index => $imagePath)
                                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                        <img src="{{ Storage::url($imagePath) }}" class="d-block w-100"
                                                            style="height: 140px;" alt="...">
                                                    </div>
                                                @endforeach
                                            @else
                                                <img src="{{ Storage::url($imagePath) }}" class="d-block w-100"
                                                    style="height: 140px;" alt="...">
                                            @endif
                                        </div>
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#carouselExample{{ $cart->product->id }}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#carouselExample{{ $cart->product->id }}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                    <a href="#!">
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)">
                                        </div>
                                    </a>
                                </div>
                                <!-- Image -->
                            </div>

                            <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                <!-- Data -->
                                <p><strong>{{ $cart->product->product_name }}</strong></p>
                                <p>{{ $cart->product->category->name }}</p>
                                <p>{{ $cart->product->tracking_code }}</p>
                                <!-- Data -->
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">

                                <form action="{{ route('update.cart', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <!-- Quantity -->
                                    <div class="d-flex" style="max-width: 300px">
                                        <div class="form-outline">
                                            <input id="form1" name="cart_quantity" value="{{ $cart->cart_quantity }}"
                                                type="number"
                                                class="form-control @error('cart_quantity') is-invalid @enderror">
                                            <label class="form-label" for="form1">Enter quantity</label>
                                            @error('cart_quantity')
                                                <span class="invalid-feedback" style="font-size: 12px;" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-secondary btn-sm me-1 mb-2" data-mdb-toggle="tooltip"
                                        title="Back" onclick="goBack()">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-info text-white btn-sm me-1 mb-2"
                                        data-mdb-toggle="tooltip" title="Add order">
                                        <i class="fas fa-pen"></i> Update
                                    </button>
                                </form>
                                <!-- Quantity -->
                                <!-- Price -->
                            </div>
                        </div>
                        <!-- Single item -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
