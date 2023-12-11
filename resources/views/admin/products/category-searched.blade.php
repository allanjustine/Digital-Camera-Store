@extends('admin.layout.base')

@section('title')
    | @if ($search)
        Search result for "{{ $search }}"
    @else
        No category found
    @endif
@endsection

@section('content')
    <div class="container">
        <h3 class="mb-4">
            @if ($search)
                Search result for "{{ $search }}"
            @else
                No category found
            @endif
        </h3>
        <div class="col-sm-12">
            <a href="/admin/categories/create" class="btn btn-primary mb-3 me-2 float-end">
                <i class="fa-solid fa-layer-group"></i> Add Category
            </a>
            <form action="{{ route('admin.category.search') }}" method="GET">
                @csrf
                <input type="search" name="search" class="form-control mb-3 mx-2 float-start" style="width: 198px;"
                    placeholder="Search">
                <button class="btn btn-primary"><i class="far fa-magnifying-glass"></i></button>
            </form>
        </div>
        @if ($search)
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID.</th>
                            <th>Category image</th>
                            <th>Category name</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td><img src="{{ Storage::url($category->cat_image) }}" alt=""
                                        class="rounded-circle" style="width: 100px; height: 100px;"></td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->remarks }}</td>
                                <td>
                                    <a href="/admin/categories/update/{{ $category->id }}" class="btn btn-primary mb-1"><i
                                            class="far fa-pen-to-square"></i> Edit</a>
                                    <a href="#" class="btn btn-danger mb-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteCategory{{ $category->id }}"><i class="far fa-trash"></i>
                                        Delete</a>
                                </td>
                            </tr>
                            @include('admin.products.delete-category')
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    No data found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <button class="btn btn-dark" onclick="goBack()">Back <i class="far fa-arrow-left"></i></button>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID.</th>
                            <th>Category Name</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center">
                                No data found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-dark" onclick="goBack()">Back <i class="far fa-arrow-left"></i></button>
        @endif
    </div>

@endsection
