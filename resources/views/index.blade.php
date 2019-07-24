@extends("layouts.index_page_template")

@section("styles")
    <style>
        .custom_column{
            padding-right: 10px;
            padding-bottom: 10px;
            padding-top: 10px;

        }

        .right{
            position: absolute;
            right: 10px;
            max-width: 10rem;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            /* display: none; <- Crashes Chrome on hover */
            -webkit-appearance: none;
            margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
        }

        input[type=number] {
            -moz-appearance:textfield; /* Firefox */
        }

        .custom_button{
            background-color: rgba(95, 98, 103, 0.21);
        }

        img{
            object-fit: contain;
            height: 12rem;
        }

    </style>
@endsection

@section("page_content")
        <div class="row">
            <h2 class="">Todos los anuncios</h2>
            <form class="">
                <select class="form-control right" id="exampleFormControlSelect1">
                    <option>Precio</option>
                    <option>Nombre</option>
                    <option>Distancia</option>
                </select>
            </form>
        </div>

        <div class="row mb-4">
            @foreach($announcements as $announcement)
                <div class="custom_column col-md-6 col-lg-4" style="min-width: 14rem">
                    <div class="card" >
                        <img class="card-img-top" src="{{$announcement->image_url}}" alt="Card image cap" >
                        <div class="card-body">
                            <h5 class="card-title">{{$announcement->name}}</h5>
                            <p class="card-text">{{$announcement->price}}</p>
                            <p class="card-text">Ciudad</p>
                            <p class="text-muted">{{$announcement->updated_at}}</p>
                            <a href="{{route("product_page",
                                 ["category" => str_replace(" ","",$announcement->category_name),"subcategory" => str_replace(" ","",$announcement->subcategory_name),
                                  "id" => $announcement->id])}}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
@endsection

@section("pagination")
    {{ $announcements->onEachSide(1)->links() }}
@endsection

@section("aside")
    <aside>
    <div class="card">
        <article class="card-group-item">
            <header class="card-header">
                <h6 class="title">Precio</h6>
            </header>
            <div class="filter-content">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Min</label>
                            <input type="number" class="form-control" id="inputEmail4" placeholder="Desde">
                        </div>
                        <div class="form-group col-md-6 text-right">
                            <label>Max</label>
                            <input type="number" class="form-control" placeholder="Hasta">
                        </div>
                    </div>
                </div> <!-- card-body.// -->
            </div>

            <article class="card-group-item">
                <div class="filter-content">
                    <div class="card-body">
                        <div class="custom-control custom-checkbox">
                            <!--<span class="float-right badge badge-light round">52</span>-->
                            <input type="checkbox" class="custom-control-input" id="Check1">
                            <label class="custom-control-label" for="Check1">Llevar a domicilio</label>
                        </div> <!-- form-check.// -->

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="Check2">
                            <label class="custom-control-label" for="Check2">Rebajados</label>
                        </div> <!-- form-check.// -->
                    </div> <!-- card-body.// -->
                </div>
            </article> <!-- card-group-item.// -->
        </article> <!-- card-group-item.// -->
    </div> <!-- card.// -->
        <button class="btn custom_button" style="margin-top: 10px; width: 100%">Aplicar</button>
    </aside>


@endsection