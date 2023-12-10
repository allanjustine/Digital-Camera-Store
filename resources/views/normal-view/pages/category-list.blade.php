@extends('normal-view.layout.base')

@section('title')
    | {{ $category->name }} list
@endsection

@section('content')
    <div class="container">
        <h3 class="mt-4 d-flex justify-content-between">
            <a href="#" onclick="goBack()"><span><i class="far fa-arrow-left"></i> Go back</span></a> <span><i
                    class="far fa-camera"></i> {{ $category->name }}</span>
            <span><i class="far fa-boxes-stacked"></i> Total: {{ $category->products->count() }}</span>
        </h3>

        <div class="d-flex justify-content-center py-4">
            <div class="col-md-6">
                <form class="form-inline" action="{{ route('search') }}" method="GET">
                    @csrf
                    <div class="input-group">

                        <input type="search" class="form-control" placeholder="Search..." aria-label="Search"
                            aria-describedby="button-addon2" name="search">
                        <div class="input-group-append">
                            <button class="btn text-white" type="submit" id="button-addon2"
                                style="background: rgb(217,216,227);
                        background: linear-gradient(164deg, rgba(217,216,227,1) 0%, rgba(95,95,102,1) 35%, rgba(213,225,227,1) 100%);"><i
                                    class="far fa-magnifying-glass"></i> Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse ($category->products as $product)
                <div class="col-md-4 mt-4">
                    <div class="card card-body">
                        <div
                            class="media align-items-center align-items-lg-start text-center text-lg-left flex-column flex-lg-row">
                            <div id="carouselExample{{ $product->id }}" class="carousel slide">
                                <div class="carousel-inner">
                                    @if (is_array($product->product_image))
                                        @foreach ($product->product_image as $index => $imagePath)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ Storage::url($imagePath) }}" class="d-block" alt="..."
                                                    style="width: 100%; height: 200px;">
                                            </div>
                                        @endforeach
                                    @else
                                        <img src="{{ Storage::url($imagePath) }}" class="d-block" alt="..."
                                            style="width: 100%; height: 200px;">
                                    @endif
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExample{{ $product->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExample{{ $product->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>

                            <div class="media-body">
                                <h6 class="media-title font-weight-semibold">
                                    <h4 class="text-primary-emphasis"><strong>{{ $product->product_name }}</strong></h4>
                                </h6>

                                <ul class="list-inline list-inline-dotted mb-3 mb-lg-2">
                                    <li class="list-inline-item"><a href="#" class="text-muted"
                                            data-abc="true">{{ $product->category->name }}</a>
                                    </li>
                                </ul>

                                <p class="mb-3">{{ $product->description }} </p>
                            </div>

                            <div class="mt-3 mt-lg-0 ml-lg-3 text-center">
                                <h3 class="mb-0 font-weight-semibold">
                                    &#8369;{{ number_format($product->price, 2) }}</h3>

                                <div>
                                    @if ($product->orders->avg('rating'))
                                        @php
                                            $roundedRating = round($product->orders->avg('rating'));
                                        @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $roundedRating)
                                                <i class="fa fa-star"></i>
                                            @else
                                                <i class="fa fa-star-o"></i>
                                            @endif
                                        @endfor
                                    @else
                                        <div class="text-muted">
                                            No ratings yet
                                        </div>
                                    @endif
                                </div>

                                <div class="text-muted">
                                    @if ($product->orders->where('comment', !null)->count() <= 1)
                                        {{ $product->orders->where('comment', !null)->count() }} review
                                    @else
                                        {{ $product->orders->where('comment', !null)->count() }} reviews
                                    @endif
                                </div>
                                <p>Sold: @if ($product->sold == null)
                                        0
                                    @else
                                        {{ $product->sold }}
                                    @endif
                                </p>
                                <p>Stock: {{ $product->stock }}</p>

                                <div class="d-flex justify-content-center gap-3">
                                    <form action="{{ route('carts') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" hidden value="{{ $product->id }}" name="product_id">
                                        <button type="submit" class="btn btn-warning mt-4 text-white"><i
                                                class="far fa-cart-shopping mr-2"></i> Add to cart</button>
                                        <a href="/confirm-order-quantity/{{ $product->id }}"
                                            class="btn btn-info mt-4 text-white"><i
                                                class="far
                                                    fa-cart-circle-check mr-2"></i>
                                            Add to order</a>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <h5 class="text-center my-5">There's no products available.</h5>
            @endforelse
        </div>
    </div>
@endsection

<style>
    .mt-50 {
        margin-top: 50px;
    }

    .mb-50 {
        margin-bottom: 50px;
    }


    .bg-teal-400 {
        background-color: #26a69a;
    }

    a {
        text-decoration: none !important;
    }


    .fa {
        color: red;
    }
</style>
