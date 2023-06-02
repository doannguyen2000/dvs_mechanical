<div class="col-lg-0 border bg-primary-subtle" id="sidebar">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-md">
                        <a class="navbar-brand" href="#">DVS</a>
                    </div>
                </nav>
                <hr>
                <nav class="nav flex-column">
                    <a class="btn border nav-link text-start {{ Request::url() == route('main') ? 'btn-outline-primary  active' : '' }}"
                        aria-current="page" href="{{ route('main') }}"><span><i
                                class="fa-solid fa-house"></i></span>&nbsp;Dard Boad</a>
                    <a class="btn border nav-link text-start {{ strpos(Route::currentRouteName(), 'admin.users') !== false ? ' btn-outline-primary  active' : '' }}"
                        aria-current="page" href="{{ route('admin.users.list') }}"><span><i
                                class="fa-solid fa-users-rectangle"></i></span>&nbsp;Users</a>
                    <a class="btn border nav-link text-start {{ strpos(Route::currentRouteName(), 'admin.products') !== false ? ' btn-outline-primary  active' : '' }}"
                        href="{{ route('admin.products.list') }}"><span><i
                                class="fa-solid fa-cart-flatbed-suitcase"></i></span>&nbsp;Products</a>
                    <a class="btn border nav-link text-start {{ strpos(Route::currentRouteName(), 'admin.roles') !== false ? ' btn-outline-primary  active' : '' }}"
                        href="{{ route('admin.roles.list') }}"><span><i
                                class="fa-solid fa-user-shield"></i></span>&nbsp;Roles</a>
                    <a class="btn border nav-link text-start {{ strpos(Route::currentRouteName(), 'admin.permissions') !== false ? ' btn-outline-primary  active' : '' }}"
                        href="{{ route('admin.permissions.list') }}"><span><i
                                class="fa-solid fa-list-check"></i></span>&nbsp;Permissions</a>
                    <a class="btn border nav-link text-start {{ strpos(Route::currentRouteName(), 'admin.categories') !== false ? ' btn-outline-primary  active' : '' }}"
                        href="{{ route('admin.categories.list') }}"><span><i
                                class="fa-solid fa-tags"></i></span>&nbsp;Categories</a>
                </nav>
            </div>
        </div>
    </nav>

</div>
