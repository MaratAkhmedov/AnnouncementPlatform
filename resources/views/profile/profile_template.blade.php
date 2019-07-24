@extends("layouts.general_template")

@section("styles")
<style>
    #sidebar-wrapper {
        height: auto;
        width: 100%;
       /* -webkit-transition: margin .25s ease-out;
        -moz-transition: margin .25s ease-out;
        -o-transition: margin .25s ease-out;
        transition: margin .25s ease-out;*/
    }


</style>
@endsection

@section("scripts")
    <script>
        $(document).ready(function() {
            /*$('#sidebar-wrapper a').click(function() {
                $('#sidebar-wrapper a.bg-secondary').removeClass('bg-secondary text-white');
                $(this).addClass('bg-secondary text-white');
            });*/
        });


    </script>
@endsection



@section("content")
    <div class="container">
        <div class="row mt-5">
            <!-- aside at the left -->
            <div class="d-flex col-md-3" id="wrapper">

                <!-- Sidebar -->
                <div class="mb-5" id="sidebar-wrapper">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action bg-secondary text-white">Mis anuncios</a>
                        <a href="#" class="list-group-item list-group-item-action">Mis mensajes</a>
                        <a href="#" class="list-group-item list-group-item-action">Ajustes</a>
                    </div>
                </div>
            </div>
                <!-- /#sidebar-wrapper -->


            <div class="col-md-9">
                @yield("information")
            </div>
        </div>
    </div>
@endsection