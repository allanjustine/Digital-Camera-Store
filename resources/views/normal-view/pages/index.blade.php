@extends('normal-view.layout.base')

@section('title')
    | Products list
@endsection

@section('content')

    <div class="text-white py-2"
        style="background: rgb(217,216,227);
background: linear-gradient(90deg, rgba(217,216,227,1) 0%, rgba(95,95,102,1) 35%, rgba(213,225,227,1) 100%);">
        <div class="container text-center p-2">

            <h4 class="text-center">
                There's many categories to choose
            </h4>
        </div>
    </div>
    <div class="px-2 mt-5" style="max-width: 100%; overflow-x: auto;">
        <div class="d-flex gap-3">
            @forelse ($categories as $category)
                <div class="mb-4 col-md-2" title="{{ $category->remarks }}">
                    <a href="/category/{{ $category->id }}" style="text-decoration: none;">
                        <div class="card">
                            <img src="{{ Storage::url($category->cat_image) }}" class="card-img-top"
                                alt="{{ $category->name }}" style="width: 100%; height: 200px;">
                            <div class="card-body">
                                <p class="card-title text-center">{{ $category->name }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <h5 class="text-center">
                    No records list
                </h5>
            @endforelse
        </div>
    </div>

    <div class="hero-image d-flex justify-content-center align-items-center text-center">
        <div class="hero-text text-white">
            <h3>Best quality camera &amp; accessories is here</h3>
            @auth
                <a href="/contact-us" class="btn btn-outline-info text-white">Contact us here</a>
                <a href="#list" class="btn btn-outline-primary">Buy now</a>
            @else
                <a href="/contact-us" class="btn btn-outline-info text-white">Contact us here</a>
                <a href="/login" class="btn btn-outline-primary">Buy now</a>
            @endauth
        </div>
    </div>

    <div class="text-white py-2"
        style="background: rgb(217,216,227);
background: linear-gradient(90deg, rgba(217,216,227,1) 0%, rgba(95,95,102,1) 35%, rgba(213,225,227,1) 100%);">
        <div class="container text-center p-2">
            <h3 class="font-weight-bold"><i class="far fa-product"></i> Top products</h3>
        </div>
    </div>
    <div class="container d-flex justify-content-center mt-2 mb-50">
        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-4 mt-4" title="{{ $product->description }}">
                    <div class="ribbon">
                        <div class="wrap">
                            <span class="ribbon6">Top selling</span>
                        </div>
                    </div>
                    <div class="card card-body">
                        <div
                            class="media align-items-center align-items-lg-start text-center text-lg-left flex-column flex-lg-row">
                            <div id="carouselAll{{ $product->id }}" class="carousel slide">
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
                                    data-bs-target="#carouselAll{{ $product->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselAll{{ $product->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>

                            <div class="media-body">
                                <h6 class="media-title font-weight-semibold">
                                    <h4 class="text-primary-emphasis"><strong>{{ $product->product_name }}</strong></h4>
                                </h6>

                                <ul class="list-inline list-inline-dotted mb-3 mb-lg-2">
                                    <li class="list-inline-item">
                                        <p class="text-muted">{{ $product->category->name }}</p>
                                    </li>
                                </ul>

                            </div>

                            <div class="mt-3 mt-lg-0 ml-lg-3 text-center">
                                <h3 class="mb-0 font-weight-semibold">&#8369;{{ number_format($product->price, 2) }}</h3>

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
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseOne{{ $product->id }}"
                                                aria-expanded="false" aria-controls="flush-collapseOne">
                                                Description
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne{{ $product->id }}" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">{{ $product->description }}</div>
                                        </div>
                                    </div>
                                </div>

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
                <h5 class="text-center my-5">There's no top products yet.</h5>
            @endforelse
        </div>
    </div>

    <div class="text-white py-2"
        style="background: rgb(217,216,227);
background: linear-gradient(90deg, rgba(217,216,227,1) 0%, rgba(95,95,102,1) 35%, rgba(213,225,227,1) 100%);">
        <div class="container text-center p-2">
            <h3 class="font-weight-bold"><i class="far fa-product"></i> All products</h3>
        </div>
    </div>
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
    <div class="container d-flex justify-content-center mt-2     mb-50">

        <div class="row">
            @forelse ($allProducts as $product)
                <div class="col-md-4 mt-4" title="{{ $product->description }}">
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
                                    <li class="list-inline-item">
                                        <p class="text-muted">{{ $product->category->name }}</p>
                                    </li>
                                </ul>

                            </div>

                            <div class="mt-3 mt-lg-0 ml-lg-3 text-center">
                                <h3 class="mb-0 font-weight-semibold">&#8369;{{ number_format($product->price, 2) }}</h3>

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
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseOne{{ $product->id }}"
                                                aria-expanded="false" aria-controls="flush-collapseOne">
                                                Description
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne{{ $product->id }}"
                                            class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">{{ $product->description }}</div>
                                        </div>
                                    </div>
                                </div>

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
                <h5 class="text-center my-5">There's no top products yet.</h5>
            @endforelse
        </div>
    </div>

@endsection


<style>
    .ribbon {
        position: relative;
    }

    .wrap {
        width: 100%;
        height: 188px;
        position: absolute;
        top: -8px;
        left: 8px;
        overflow: hidden;
    }

    .wrap:before,
    .wrap:after {
        content: "";
        position: absolute;
    }

    .wrap:before {
        width: 30px;
        height: 8px;
        right: 100px;
        background: #305865;
        border-radius: 8px 8px 0px 0px;
    }

    .wrap:after {
        width: 8px;
        height: 30px;
        right: 0px;
        top: 100px;
        background: #306561;
        border-radius: 0px 8px 8px 0px;
    }

    .ribbon6 {
        width: 200px;
        height: 32px;
        line-height: 29px;
        position: absolute;
        top: 30px;
        right: -50px;
        z-index: 2;
        overflow: hidden;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
        border: 1px dashed;
        box-shadow: 0 0 0 3px #ddbc43, 0px 21px 5px -18px rgba(0, 0, 0, 0.6);
        background: #dd7943;
        text-align: center;
    }

    .hero-image {
        background-image: url('/images/bg.png');
        background-size: cover;
        height: 100vh;
        position: relative;
        Border-image: fill 0 linear-gradient(#0003, #000);
    }

    .cont:hover {
        color: #000000 !important;
        background-color: rgb(186, 179, 179) !important;
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
