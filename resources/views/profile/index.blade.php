@extends("profile.profile_template")

@section("styles")
    @parent
    <style>
        .card .btn_left{
            visibility: collapse;
            position: absolute;
            bottom: 6px;
            left: 10px;
        }

        .card .btn_right{
            visibility: collapse;
            position: absolute;
            bottom: 6px;
            right: 10px;
        }

        .card:hover .btn{
            visibility: visible;
            transition: visibility 2s linear;
        }

        .card:hover img, .card:hover .card-body{
            opacity: 0.5;
            transition: opacity 100ms linear;
        }

        .card:hover{
            box-shadow:0px 0px 5px #5d6280;
            -webkit-box-shadow: 0 0 5px #5a5880;
            transition: box-shadow 10ms ease-in-out 0s;
        }

    </style>
@endsection

@section("scripts")
    @parent
    <script>
        $(document).ready(function() {
             $("#1").first().addClass("text-white bg-secondary");
        });
    </script>
@endsection

@section("information")
    @foreach($array as $array_element)
        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img style="object-fit: cover; height: 100%" src="{{$array_element["image_url"]}}" class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Location: </strong>{{$array_element["location"]}}</h5>
                        <p class="card-text"><strong>Descripción: </strong>{{$array_element["description"]}}</p>
                        <p class="card-text"><strong>Precio: </strong>{{$array_element["price"]}} $</p>
                        <p class="card-text"><strong>Dirección: </strong>{{$array_element["location"]}}</p>
                        <p class="card-text"><small class="text-muted">Ultima modificación: {{$array_element["updated_at"]}}</small></p>
                    </div>
                    <a href="{{route("edit", $array_element["id"])}}" class="btn btn-primary btn_left">Modificar</a>
                    <!--<a href="#" class="btn btn-danger btn_right">Borrar</a>-->
                    <form action="{{ url('/profile', ["id" => $array_element["id"]]) }}" method="post">
                        <input class="btn btn-danger btn_right" type="submit" value="Delete" />
                        <input type="hidden" name="_method" value="delete" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection