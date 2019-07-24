<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
<div class="container">
    <a class="navbar-brand" href="/">Brand</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categorías
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </ul>
        <form class="form-inline" method="GET" action="">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" name="q">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
        <a type="button" href="{{route("addAnnouncement")}}" class="btn btn-secondary ml-lg-5">Nuevo anuncio</a>

        @if (Route::has('login'))
            <!-- si el ususario esta logueado-->
            @auth
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle ml-lg-5" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{Auth::user()->first_name}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{route("profile")}}">Mis anuncios</a>
                        <hr>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            <!-- en otro caso -->
            @else
            <a type="button" class="btn btn-secondary ml-lg-5" href="{{ route('login') }}">Войти</a>
            @endauth
        @endif

    </div>
</div>
</nav>
