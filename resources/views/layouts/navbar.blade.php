<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
<div class="container">
    <a class="navbar-brand" href="/">Announcements</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <!--<div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categorías
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>-->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Categorías
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <!--<li class="dropdown-submenu">
                        <a tabindex="-1" href="#" class="dropdown-item test">New dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="#" class="dropdown-item">2nd level dropdown</a></li>
                            <li><a tabindex="-1" href="#" class="dropdown-item">2nd level dropdown</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#" class="dropdown-item test">New dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="#" class="dropdown-item">2nd level dropdown</a></li>
                            <li><a tabindex="-1" href="#" class="dropdown-item">2nd level dropdown</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#" class="dropdown-item test">New dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="#" class="dropdown-item">2nd level dropdown</a></li>
                            <li><a tabindex="-1" href="#" class="dropdown-item">2nd level dropdown</a></li>
                        </ul>
                    </li>-->
                    <?php
                    foreach ($categories as $category){
                        echo "<li class='dropdown-submenu'>";
                        echo     "<a tabindex='-1' href='". "/". $category['category_name'] ."/'" . "class='dropdown-item test'>". $category['category_name'] ."<span class='caret'></span></a>";
                        echo "<ul class='dropdown-menu'>";
                        foreach ($category["subcategories"] as $subcategory){
                            echo "<li><a tabindex='-1' href='/". $category["category_name"]. "/" . $subcategory["subcategory_name"] ."/'" . "class='dropdown-item'>" . $subcategory["subcategory_name"] . "</a></li>";
                        }
                        echo "</ul>";
                    }
                    ?>
                </ul>
            </div>
        </ul>
        <form class="form-inline" method="get" action="
                    @if(request()->route()->getName() != "/")
                        {{url("/")}}
                    @endif
                ">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" name="q"
            @if(request()->has("q"))
                {{"value =" . request()->get("q")}}
            @endif
                >
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
            <a type="button" class="btn btn-secondary ml-lg-5" href="{{ route('login') }}">{{__('auth.login')}}</a>
            @endauth
        @endif

    </div>
</div>
</nav>
