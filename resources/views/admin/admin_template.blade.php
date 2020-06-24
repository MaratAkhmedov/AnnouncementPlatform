<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel</title>

    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">
    <!-- Custom styles for this template -->
    <link href={{asset("css/admin/admin_template.css")}} rel="stylesheet">
    @yield("styles")
</head>

<body>
<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">Panel de Administración</div>
        <div class="list-group list-group-flush">
            <a href={{route("admin")}} class="list-group-item list-group-item-action bg-light">Anuncios</a>
            <a href="{{route("category_settings")}}" class="list-group-item list-group-item-action bg-light">Categorías</a>
            <a href="{{route("subcategory_settings")}}" class="list-group-item list-group-item-action bg-light">Subcategorías</a>
            <a href="{{route("user_settings")}}" class="list-group-item list-group-item-action bg-light">Usuarios</a>
        </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <div class="container-fluid">
            @yield("content")
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
@yield("scripts")


</body>