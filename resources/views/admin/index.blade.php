@extends("admin.admin_template")

@section("content")
    <h1 class="mt-3">Los anuncios de usuarios</h1>
    <table class="table table-striped table-bordered mt-3" id="customers">
        <tr>
            <th>Id</th>
            <th>Id del usuario</th>
            <th>Título del anuncio</th>
            <th>Descripción</th>
            <th>Última modificación</th>
            <th>Status</th>
            <th>Opciones</th>
        </tr>
        @foreach($announcements as $announcement)
            <tr>
                <td>{{$announcement["id"]}}</td>
                <td>{{$announcement["user_id"]}}</td>
                <td>{{$announcement["name"]}}</td>
                <td>{{$announcement["description"]}}</td>
                <td>{{$announcement["updated_at"]}}</td>
                <td>{{$announcement["status"]}}</td>
                <td>
                    <form action="{{ route("change_status", [$announcement["id"], 10]) }}" style="display: inline;" method="post">
                        <input class="btn btn-outline-success m-1" type="submit" value="Aprobar" />
                        <input type="hidden" name="_method" value="PUT" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                <a class="btn btn-outline-info m-1" href="{{route("show_announcement", $announcement["id"])}}">Previsualizar</a>
                <form action="{{ url('/profile', ["id" => $announcement["id"]]) }}" style="display: inline;" method="post">
                    <input class="btn btn-outline-danger m-1" type="submit" value="Borrar" />
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                    <form action="{{ route("change_status", [$announcement["id"], 1]) }}" style="display: inline;" method="post">
                        <input class="btn btn-outline-danger m-1" type="submit" value="Bloquear" />
                        <input type="hidden" name="_method" value="PUT" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </td>

            </tr>
        @endforeach
@endsection