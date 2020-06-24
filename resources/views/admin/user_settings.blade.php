@extends("admin.admin_template")

@section("content")
    <h1 class="mt-3">Los anuncios de usuarios</h1>
    <table class="table table-striped table-bordered mt-3" id="customers">
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Email verificado</th>
            <th>Opciones</th>
        </tr>

        @foreach($users as $user)
            <tr>
                <td>{{$user["id"]}}</td>
                <td>{{$user["first_name"]}}</td>
                <td>{{$user["last_name"]}}</td>
                <td>{{$user["email"]}}</td>
                <td>
                    @if($user["email_verified_at"] == null)
                        NO verificado
                    @else
                        Verificado
                    @endif
                </td>
                <td>
                    <form action="{{ route('delete_user', ["id" => $user["id"]]) }}" style="display: inline;" method="post">
                        <input class="btn btn-outline-danger m-1" type="submit" value="Borrar" />
                        <input type="hidden" name="_method" value="delete" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection