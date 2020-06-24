@extends("admin.admin_template")

@section("styles")

@endsection
<style>

</style>
@section("content")
    <h1 class="mt-3">Las categorías existentes</h1>
    <table class="table table-striped table-bordered mt-3" id="customers">
    <tr>
        <th>Id</th>
        <th>Nombre de la categoría</th>
        <th>Opciones</th>
    </tr>
    @foreach($categories as $category)
        <tr>
            <td>{{$category["id"]}}</td>
            <td>{{$category["name"]}}</td>
            <td>
                <form action="{{ route("change_category_name", $category["id"]) }}" style="display: inline;" method="post" name = "change_category_name">
                    <button class="btn btn-outline-danger m-1" type="button">
                        Modificar
                    </button>
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                <form action="{{ route('delete_category', ["id" => $category["id"]]) }}" style="display: inline;" method="post">
                    <input class="btn btn-outline-danger m-1" type="submit" value="Borrar" />
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </td>
        </tr>
    @endforeach
    </table>
    <form action="{{ route("add_category") }}" style="display: inline;" method="post" name="add_category">
        <button class="btn-lg btn-success m-1" name="add_category" type="button" style="width: 15rem">
            Añadir
        </button>
        <input type="hidden" name="_method" value="POST" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>

@endsection


@section("scripts")
    <script>
        $("button[name=add_category]").click(function () {
            var categoria = window.prompt("Introduce el nombre de la categoría");
            if(categoria){
                $('form[name = add_category]').append('<input type="hidden" name="category_name" value="' + categoria + '">').submit();
            }
        })

        $("form[name=change_category_name]").click(function () {
            var categoria = window.prompt("Introduce el nombre de la categoría");
            if(categoria){
                $(this).append('<input type="hidden" name="category_name" value="' + categoria + '">').submit();
            }
        })
    </script>
@endsection