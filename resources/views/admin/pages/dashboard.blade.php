@extends('admin.layout.base')

@section('title')
    | Dashboard
@endsection

@section('content')
    <div class="container">
        <h3 class="mb-4">Dashboard</h3>
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <a href="/admin/users">
                    <div class="card shadow">
                        <div class="card-body">
                            <h1 class="float-end"><strong>{{ App\Models\User::count() }}</strong></h1>
                            <h1><i class="far fa-users mt-3"></i></h1>
                            <h6 class="float-end"><strong>Total Users</strong></h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-4">
                <a href="/admin/categories">
                    <div class="card shadow">
                        <div class="card-body">
                            <h1 class="float-end"><strong>{{ App\Models\Category::count() }}</strong></h1>
                            <h1><i class="far fa-grid-2 mt-3"></i></h1>
                            <h6 class="float-end"><strong>Total Categories</strong></h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-4">
                <a href="/admin/products">
                    <div class="card shadow">
                        <div class="card-body">
                            <h1 class="float-end"><strong>{{ App\Models\Product::count() }}</strong></h1>
                            <h1><i class="far fa-box mt-3"></i></h1>
                            <h6 class="float-end"><strong>Total Products</strong></h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-4">
                <a href="/admin/orders">
                    <div class="card shadow">
                        <div class="card-body">
                            <h1 class="float-end"><strong>{{ App\Models\Order::count() }}</strong></h1>
                            <h1><i class="far fa-cart-circle-check mt-3"></i></h1>
                            <h6 class="float-end"><strong>Total Orders</strong></h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-4">
                <a href="/admin/messages">
                    <div class="card shadow">
                        <div class="card-body">
                            <h1 class="float-end"><strong>{{ App\Models\Contact::count() }}</strong></h1>
                            <h1><i class="far fa-comment-dots mt-3"></i></h1>
                            <h6 class="float-end"><strong>Total Messages</strong></h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-4">
                <a href="/admin/logs">
                    <div class="card shadow">
                        <div class="card-body">
                            <h1 class="float-end"><strong>{{ App\Models\Log::count() }}</strong></h1>
                            <h1><i class="far fa-layer-group mt-3"></i></h1>
                            <h6 class="float-end"><strong>Total Logs</strong></h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

<style>
    .card {
        background-color: rgb(143, 69, 13) !important;
        color: white !important;
    }
</style>
