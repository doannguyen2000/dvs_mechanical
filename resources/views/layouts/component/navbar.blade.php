<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand">DVS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" id="showSidebar"></span>
        </button>
        @auth
            <form class="d-flex" id="nav-search" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        @endauth
        <div class="d-flex" role="search">
            @auth
                <div class="dropdown">
                    <button class="btn border dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false" style="min-width: 136px;">
                        <span><img src="{{ asset('assets/images/adminAvatar.jpg') }}" style="height: 25px;width: 25px;"
                                class="border rounded-5" alt="..."></span>&nbsp;{{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-sm-start">
                        <li><button class="dropdown-item" type="button">My information&nbsp;<span><i
                                        class="fa-regular fa-circle-user"></i></span></button></li>
                        <li>
                            <button class="dropdown-item"
                                onclick="document.getElementById('logout-form').submit();">Logout&nbsp;<span><i
                                        class="fa-solid fa-right-from-bracket"></i></span></button>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                @unless (Request::url() == route('login'))
                    <a class="btn btn-success" href="{{ route('login') }}"><span><i
                                class="fa-solid fa-right-to-bracket"></i></span>&nbsp;Login</a>
                @endunless

                &nbsp;
                @unless (Request::url() == route('register'))
                    <a class="btn btn-outline-primary" href="{{ route('register') }}"><span><i
                                class="fa-solid fa-arrow-up-from-bracket"></i></span>&nbsp;Sign Up</a>
                @endunless
            @endauth
        </div>
    </div>
</nav>
