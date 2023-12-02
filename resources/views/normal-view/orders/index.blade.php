@extends('normal-view.layout.base')

@section('title')
    | My Oders
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
                        <h5 class="mb-0">Order - {{ $orders->count() }} items</h5>
                    </div>
                    <div class="card-body">
                        <!-- Single item -->
                        <div class="row">
                            @forelse ($orders as $order)
                                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                    <!-- Image -->
                                    <div class="bg-image hover-overlay hover-zoom ripple rounded ml-5"
                                        data-mdb-ripple-color="light">
                                        <div id="carouselExample{{ $order->id }}" class="carousel slide">
                                            <div class="carousel-inner">
                                                @if (is_array($order->product->product_image))
                                                    @foreach ($order->product->product_image as $index => $imagePath)
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
                                                data-bs-target="#carouselExample{{ $order->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#carouselExample{{ $order->id }}" data-bs-slide="next">
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
                                    <p><strong>{{ $order->product->product_name }}</strong></p>
                                    <p>{{ $order->product->category->name }}</p>
                                    <p>{{ $order->product->tracking_code }}</p>
                                    <!-- Data -->
                                </div>

                                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                    <!-- Quantity -->

                                    @if ($order->status == 'Pending')
                                        <div class="ribbon">
                                            <span class="ribbon1 bg-danger text-white"><span>Pending</span></span>
                                        </div>
                                    @elseif($order->status == 'Processing')
                                        <div class="ribbon">
                                            <span class="ribbon1 bg-info text-white"><span>Processing</span></span>
                                        </div>
                                    @elseif($order->status == 'Out for delivery')
                                        <div class="ribbon">
                                            <span class="ribbon1 bg-dark text-white"><span>Out for delivery</span></span>
                                        </div>
                                    @elseif($order->status == 'Delivered')
                                        <div class="ribbon">
                                            <span class="ribbon1 bg-primary text-white"><span>Delivered</span></span>
                                        </div>
                                    @elseif($order->status == 'Paid')
                                        <div class="ribbon">
                                            <span class="ribbon1 bg-success text-white"><span><i class="far fa-check"></i> Paid</span></span>
                                        </div>
                                    @endif
                                    <div class="d-flex" style="max-width: 300px">
                                        <div class="form-outline"></label>
                                            <label class="form-label" for="form1">Quantity
                                                x{{ $order->order_quantity }}
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <p class="text-start">
                                        <strong>&#8369;{{ number_format($order->product->price, 2) }}</strong>
                                    </p>
                                    <p class="text-start">
                                        <strong>Total price:
                                            &#8369;{{ number_format($order->product->price * $order->order_quantity, 2) }}</strong>
                                    </p>
                                    @if ($order->status == 'Delivered')
                                        <p>
                                            <a class="btn btn-warning text-white" href="/orders/review/{{ $order->id }}">Pending review and ratings</a>
                                        </p>
                                    @endif

                                    @if ($order->status == 'Pending')
                                        <a href="#" class="btn btn-danger btn-sm me-1 mb-2" data-mdb-toggle="tooltip"
                                            title="Remove item" data-bs-toggle="modal"
                                            data-bs-target="#remove{{ $order->id }}">
                                            <i class="fas fa-trash"></i> Cancel
                                        </a>
                                    @endif
                                </div>

                                <hr class="my-4" />
                                @include('normal-view.orders.cancel')
                            @empty
                                <h3 class="text-center">No orders yet.</h3>
                            @endforelse
                        </div>
                        <!-- Single item -->
                        <div><strong>Grand total:
                                &#8369;{{ number_format(
                                    $orders->sum(function ($order) {
                                        return $order->product->price * $order->order_quantity;
                                    }),
                                    2,
                                ) }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<style>
    .ribbon {
        position: relative;
    }


    .ribbon1 {
        position: absolute;
        top: -6.1px;
        right: 1px;
    }

    .ribbon1:after {
        position: absolute;
        content: "";
        width: 0;
        height: 0;
        border-left: 53px solid transparent;
        border-right: 53px solid transparent;
    }

    .ribbon1 span {
        position: relative;
        display: block;
        text-align: center;
        font-size: 14px;
        line-height: 1;
        padding: 12px 8px 10px;
        border-top-right-radius: 8px;
        width: 90px;
    }

    .ribbon1 span:before,
    .ribbon1 span:after {
        position: absolute;
        content: "";
    }

    .ribbon1 span:before {
        height: 6px;
        width: 6px;
        left: -6px;
        top: 0;
        background: #F8463F;
    }

    .ribbon1 span:after {
        height: 6px;
        width: 8px;
        left: -8px;
        top: 0;
        border-radius: 8px 8px 0 0;
        background: #C02031;
    }
</style>
