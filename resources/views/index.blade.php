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

@section("scripts")
    <script>
        $('form').submit(function(e){
            var emptyinputs = $(this).find('input').filter(function(){
            return !$.trim(this.value).length;  // get all empty fields
        }).prop('disabled',true);
        });
    </script>
@endsection

@section("page_content")
    <div class="row">
            <h2 class="">
                <?php
                     if($subcategory_name){
                         echo $subcategory_name;
                     }
                     elseif ($category_name){
                         echo $category_name;
                     }
                     else{
                         echo "Todos los anuncios";
                     }
                ?>
            </h2>
            <form class="" method="get">
                <?php
                    // add all parameters except page and order_by ()
                    $parameters = request()->except(["page", "order_by"]);
                    foreach ($parameters as $key => $value){
                        echo "<input type='hidden' name=$key value=$value />";
                    }
                ?>
                <select class="form-control right" id="exampleFormControlSelect1" onchange="this.form.submit()" name="order_by">
                    <option <?php
                        if(request()->get("order_by") == "Fecha"){echo "selected";}
                        ?>>Fecha</option>
                    <option
                    <?php if(request()->get("order_by") == "Precio"){echo "selected";}?>>
                        Precio</option>
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
                                 ["category" => str_replace(" ","-",$announcement->category_name),"subcategory" => str_replace(" ","-",$announcement->subcategory_name),
                                  "id" => $announcement->id])}}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
@endsection

@section("pagination")
    {{ $announcements->onEachSide(1)->appends(request()->input())->links() }}
@endsection

@section("aside")
    <aside>
        <form method="get" action="">

            <?php
            $parameters = request()->except(["page", "min_price", "max_price"]);
            foreach ($parameters as $key => $value){
                echo "<input type='hidden' name=$key value=$value />";
            }
            ?>

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
                            <input type="number" class="form-control" id="inputEmail4" placeholder="Desde" name="min_price"
                            @if(request()->has("min_price"))
                                {{"value =" . request()->get("min_price")}}
                            @endif>
                        </div>
                        <div class="form-group col-md-6 text-right">
                            <label>Max</label>
                            <input type="number" class="form-control" placeholder="Hasta" name="max_price"
                            @if(request()->has("max_price"))
                                {{"value =" . request()->get("max_price")}}
                            @endif>
                        </div>
                    </div>
                </div> <!-- card-body.// -->
            </div>

            <article class="card-group-item">
               <!-- <div class="filter-content">
                    <div class="card-body">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="Check1">
                            <label class="custom-control-label" for="Check1">Llevar a domicilio</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="Check2">
                            <label class="custom-control-label" for="Check2">Rebajados</label>
                        </div>
                    </div>
                </div>-->
            </article> <!-- card-group-item.// -->
        </article> <!-- card-group-item.// -->
    </div> <!-- card.// -->
        <button class="btn custom_button" type="submit" style="margin-top: 10px; width: 100%">Aplicar</button>
 </form>
    </aside>


@endsection