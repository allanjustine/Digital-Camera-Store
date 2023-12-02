<header class="header" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <div class="header_img"> <img
            src="{{ Auth::user()->profile_image === null && Auth::user()->gender === 'Male'
                ? url('images/profile-image.png')
                : (Auth::user()->profile_image === null && Auth::user()->gender === 'Female'
                    ? url('images/profile-image2.png')
                    : Storage::url(Auth::user()->profile_image)) }}"
            alt="" data-bs-toggle="dropdown" aria-expanded="false">
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"><i class="far fa-user"></i> {{ auth()->user()->name }}</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                        class="far fa-arrow-right-from-bracket"></i> Logout</a></li>
        </ul>

    </div>
</header>
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div> <a href="#" class="nav_logo"> <i class='far fa-camera nav_logo-icon'></i> <span
                    class="nav_logo-name">Digital Camera Store</span> </a>
            <div class="nav_list">
                <a href="/admin/dashboard"
                    class="nav_link {{ 'admin/dashboard' == request()->path() ? 'active' : '' }}"> <i
                        class='bx bx-grid-alt nav_icon'></i>
                    <span class="nav_name">Dashboard</span>
                </a>
                <a href="/admin/users" class="nav_link {{ 'admin/users' == request()->path() ? 'active' : '' }}"> <i
                        class='far fa-users nav_icon'></i> <span class="nav_name">Users</span>
                </a>
                <a href="/admin/categories"
                    class="nav_link {{ 'admin/categories' == request()->path() ? 'active' : '' }}"> <i
                        class='far fa-layer-group nav_icon'></i> <span class="nav_name">Category</span>
                </a>
                <a href="/admin/products" class="nav_link {{ 'admin/products' == request()->path() ? 'active' : '' }}">
                    <i class='far fa-boxes-stacked nav_icon'></i> <span class="nav_name">Products</span>
                </a>
                <a href="/admin/orders" class="nav_link {{ 'admin/orders' == request()->path() ? 'active' : '' }}">
                    <i class='far fa-cart-circle-check nav_icon'></i> <span class="nav_name">Orders</span>
                </a>
                <a href="/admin/messages" class="nav_link {{ 'admin/messages' == request()->path() ? 'active' : '' }}">
                    <i class='bx bx-message-square-detail nav_icon'></i> <span class="nav_name">Messages</span>
                </a>

                <a href="/admin/logs" class="nav_link ml-1 {{ 'admin/logs' == request()->path() ? 'active' : '' }}">
                    <i class='far fa-font-awesome nav_icon'></i> <span class="nav_name">Logs</span>
                </a>
            </div>
        </div> <a href="#" class="nav_link" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i
                class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
    </nav>
</div>
