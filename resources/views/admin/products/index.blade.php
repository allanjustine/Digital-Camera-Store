@extends('admin.layout.base')

@section('title')
    | Admin Products
@endsection

@section('content')
    <div class="container">
        <h3 class="mb-4">Products</h3>

        <div class="col-sm-12">
            <a href="/admin/products/create" class="btn btn-primary mb-3 me-2 float-end">
                <i class="fa-solid fa-boxes"></i> Add Product
            </a>
            <form action="{{ route('admin.products.search') }}" method="GET">
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
                        <th>Tracking code</th>
                        <th>Product image</th>
                        <th>Product category</th>
                        <th>Product name</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Sold</th>
                        <th>Description</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->tracking_code }}</td>
                            <td>
                                @if (is_array($product->product_image))
                                    @foreach ($product->product_image as $index => $imagePath)
                                        <img style="width: 40px; height: 40px; margin-bottom: -15px;"
                                            class="rounded-circle border" src="{{ Storage::url($imagePath) }}"
                                            alt="">
                                    @endforeach
                                @else
                                    <img style="width: 40px; height: 40px; margin-top: -10px;" class="rounded-circle border"
                                        src="{{ Storage::url($product->product_image) }}" alt="">
                                @endif
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>&#8369;{{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->sold }}</td>
                            <td>{{ $product->description }}</td>
                            <td>
                                <a href="/admin/products/update/{{ $product->id }}" class="btn btn-primary mb-1"><i
                                        class="far fa-pen-to-square"></i> Edit</a>
                                <a href="#" class="btn btn-danger mb-1" data-bs-toggle="modal"
                                    data-bs-target="#deleteProduct{{ $product->id }}"><i class="far fa-trash"></i>
                                    Delete</a>
                            </td>
                        </tr>
                        @include('admin.products.delete')
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">
                                No data found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
