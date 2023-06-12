<div class="col-lg-0 text-primary-emphasis bg-light border border-primary-subtle rounded-end" id="sidebar">
    <nav class="navbar navbar-expand-lg ">

        <div class="container-fluid position-relative">
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <nav class="navbar navbar-expand-lg">
                    <button id="closeSidebar" type="button"
                        class="btn btn-outline-secondary btn-sm position-absolute top-0 end-0"
                        onclick="$('#showSidebar').click();"><i class="fa-solid fa-xmark"></i></button>
                    <div class="container-md">
                        <a class="navbar-brand" href="#">DVS</a>
                    </div>
                </nav>
                <hr>
                <nav class="nav flex-column">
                    <a class="btn mb-1 shadow-sm border border-dark border-opacity-25 text-start {{ Request::url() == route('main') ? ' btn-outline-primary opacity-75 border-3 border-primary  active' : '' }}"
                        aria-current="page" href="{{ route('main') }}"><span><i
                                class="fa-solid fa-house me-3"></i></span>&nbsp;Dard Boad</a>
                    <a class="btn mb-1 shadow-sm border border-dark border-opacity-25 text-start {{ strpos(Route::currentRouteName(), 'admin.users') !== false ? '  btn-outline-primary opacity-75 border-3 border-primary  active' : '' }}"
                        aria-current="page" href="{{ route('admin.users.list') }}"><span><i
                                class="fa-solid fa-users-rectangle me-3"></i></span>&nbsp;Users</a>
                    <a class="btn mb-1 shadow-sm border border-dark border-opacity-25 text-start {{ strpos(Route::currentRouteName(), 'admin.products') !== false ? '  btn-outline-primary opacity-75 border-3 border-primary  active' : '' }}"
                        href="{{ route('admin.products.list') }}"><span><i
                                class="fa-solid fa-cart-flatbed-suitcase me-3"></i></span>&nbsp;Products</a>
                    <a class="btn mb-1 shadow-sm border border-dark border-opacity-25 text-start {{ strpos(Route::currentRouteName(), 'admin.roles') !== false ? '  btn-outline-primary opacity-75 border-3 border-primary  active' : '' }}"
                        href="{{ route('admin.roles.list') }}"><span><i
                                class="fa-solid fa-user-shield me-3"></i></span>&nbsp;Roles</a>
                    <a class="btn mb-1 shadow-sm border border-dark border-opacity-25 text-start {{ strpos(Route::currentRouteName(), 'admin.permissions') !== false ? '  btn-outline-primary opacity-75 border-3 border-primary  active' : '' }}"
                        href="{{ route('admin.permissions.list') }}"><span><i
                                class="fa-solid fa-list-check me-3"></i></span>&nbsp;Permissions</a>
                    <a class="btn mb-1 shadow-sm border border-dark border-opacity-25 text-start {{ strpos(Route::currentRouteName(), 'admin.categories') !== false ? '  btn-outline-primary opacity-75 border-3 border-primary  active' : '' }}"
                        href="{{ route('admin.categories.list') }}"><span><i
                                class="fa-solid fa-tags me-3"></i></span>&nbsp;Categories</a>
                </nav>
            </div>
        </div>
    </nav>

</div>
