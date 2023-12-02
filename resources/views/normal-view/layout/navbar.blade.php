<nav class="navbar navbar-expand-lg static-top shadow-lg sticky-top" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="/images/icon.png" alt="Camera Store" height="50">
        </a>
        <a class="navbar-brand" href="#">
            <h3 class="text-white" style="font-family: sans-serif"><strong>Camera Store</strong></h3>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto gap-2">
                <li class="nav-item">
                    <a class="nav-link text-white" href="/"><i class="far fa-boxes-stacked"></i> Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/contact-us"><i class="far fa-light fa-phone"></i> Contact
                        Us</a>
                </li>
                @role('User')
                    @auth
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/orders"><i class="far fa-cart-circle-check"></i> My
                                Orders ({{ auth()->user()->orders()->count() }})</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/carts"><i class="far fa-cart-shopping"></i> My
                                Cart ({{ auth()->user()->carts()->count() }})</a>
                        </li>
                    @endauth
                @endrole
                <li class="nav-item dropdown">
                    <a class="btn border rounded-pill w-100 text-white" href="#" id="navbarDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @auth
                            {{ auth()->user()->name }}
                        @else
                            <i class="far fa-cart-circle-check"></i> Order now
                        @endauth
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @auth
                            @role('Admin')
                                <li><a class="dropdown-item text-white" href="/admin/dashboard"><i class="far fa-arrow-up"></i>
                                        Admin Page</a>
                                </li>
                            @endrole
                            <li><a class="dropdown-item text-white" href="#"><i class="far fa-user"></i>
                                    {{ auth()->user()->name }}</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-white" href="#" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"><i class="far fa-right-from-bracket"></i>
                                    Logout</a>
                            </li>
                        @else
                            <li><a class="dropdown-item text-white" href="/login"><i class="far fa-user-lock"></i>
                                    Login</a>
                            </li>
                            <li><a class="dropdown-item text-white" href="/register"><i class="far fa-registered"></i>
                                    Register</a>
                            </li>
                        @endauth
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>


<style>
    #navbar {
        background: rgb(217, 216, 227);
        background: linear-gradient(90deg, rgba(217, 216, 227, 1) 0%, rgba(95, 95, 102, 1) 35%, rgba(213, 225, 227, 1) 100%);
    }

    .dropdown-menu {
        background: rgb(217, 216, 227);
        background: linear-gradient(90deg, rgba(217, 216, 227, 1) 0%, rgba(95, 95, 102, 1) 35%, rgba(213, 225, 227, 1) 100%);
    }

    .dropdown-item:hover {
        background-color: #7beafe19;
    }

    #navbarDropdown {
        filter: drop-shadow(12px 12px 7px rgba(89, 86, 90, 0.7));
    }

    .navbar-brand img {
        filter: drop-shadow(12px 12px 7px rgba(0, 0, 0, 0.7));
    }
</style>
