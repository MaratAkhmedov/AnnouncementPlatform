@extends("admin.admin_template")


@section("content")
    <div class="container-fluid">

    <div class="row">
        <h1 class="col-md-12 mt-3">Subcategorías</h1>
    @foreach($categories as $category)
        <div class="col-md-4 card-group p-5">
        <div class="card" style="">
            <div class="card-header">
                {{$category["name"]}}
            </div>
            <ul class="list-group list-group-flush">
                @forelse($category["subcategories"] as $subcategory)
                    <li class="list-group-item">
                        <span class="" href="" style="width: 50%; display: inline"> {{$subcategory["name"]}}</span>
                        <form action="{{ route('delete_subcategory', ["id" => $subcategory["id"]]) }}" style="display: inline;" method="post">
                            <input class="btn btn-outline-danger" type="submit" style="display: inline" value="Borrar" />
                            <input type="hidden" name="_method" value="delete" />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                        <form action="{{ route("change_subcategory_name", $subcategory["id"]) }}" style="display: inline;" method="post" name = "change_subcategory_name">
                            <button class="btn btn-outline-info m-1" type="button">
                                Modificar
                            </button>
                            <input type="hidden" name="_method" value="PUT" />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </li>
                    @empty
                    No hay subcategorías creadas
                @endforelse
                    <li class="list-group-item">
                        <form action="{{ route("add_subcategory") }}" style="display: inline;" method="post" name="add_subcategory">
                            <button class="btn btn-outline-success m-1" name="add_subcategory" type="button" style="width: 100%;">
                                Añadir
                            </button>
                            <input type="hidden" name="category_id" value="{{$category["id"]}}">
                            <input type="hidden" name="_method" value="POST" />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </li>
            </ul>

        </div>
        </div>
    @endforeach
    </div>
    </div>
@endsection

@section("scripts")
    <script>
        $("form[name=add_subcategory]").click(function () {
            var categoria = $(this).closest("ul").siblings(".card-header").text();
            //borramos todos los espacios
            categoria = $.trim(categoria);
            var subcategoria = window.prompt("Introduce el nombre de la subcategoría que quieres guardar en la categoría " + categoria.toUpperCase());
            if(subcategoria){
                $(this).append('<input type="hidden" name="subcategory_name" value="' + subcategoria + '">').submit();
            }
        })

        $("form[name=change_subcategory_name]").click(function () {
            var subcategoria = window.prompt("Introduce el nuevo nombre de la subcategoría");
            if(subcategoria){
                $(this).append('<input type="hidden" name="subcategory_name" value="' + subcategoria + '">').submit();
            }
        })
    </script>
@endsection