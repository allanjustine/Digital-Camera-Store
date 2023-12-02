@extends('normal-view.layout.base')

@section('title')
    | Confirm Order
@endsection

@section('content')
    <div class="container py-5">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center mt-5" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex py-3">
                        <h5 class="mb-0">Confirm order</h5>
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
                                <p>Stock: {{ $cart->product->stock }}</p>
                                <!-- Data -->
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                <!-- Quantity -->
                                <div class="d-flex mb-4" style="max-width: 300px">

                                    <form action="{{ route('orders.create', $cart->product->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="product_id" value="{{ $cart->product->id }}" hidden>

                                        <div class="form-outline">
                                            <input id="form1" min="0" name="order_quantity" hidden
                                                value="{{ $cart->cart_quantity }}" type="number" class="form-control" />
                                            <label class="form-label" for="form1">Quantity
                                                x{{ $cart->cart_quantity }}</label>
                                            <br>
                                            <span class="text-start">
                                                <strong>&#8369;{{ number_format($cart->product->price, 2) }}</strong>
                                            </span>
                                            <p class="text-start">
                                                <strong>Total price:
                                                    &#8369;{{ number_format($cart->product->price * $cart->cart_quantity, 2) }}</strong>
                                            </p>
                                        </div>

                                        <button type="submit" class="btn btn-primary text-white btn-sm me-1 mb-2"
                                            data-mdb-toggle="tooltip" title="Add order">
                                            <i class="fas fa-cart-circle-check"></i> Add to order
                                        </button>
                                    </form>
                                </div>
                                <!-- Quantity -->

                                <!-- Price -->
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
