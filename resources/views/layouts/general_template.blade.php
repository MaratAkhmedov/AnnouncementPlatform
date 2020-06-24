<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>
    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">
    <style>
        header{
            margin-bottom: 80px;
        }

    </style>

    <style>
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }

        html {
            height: 100%;
            box-sizing: border-box;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        body {
            position: relative;
            margin: 0;
            padding-bottom: 6rem;
            min-height: 90%;
            font-family: "Helvetica Neue", Arial, sans-serif;
        }

        footer {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 1rem;
            background-color: #efefef;
            text-align: center;
        }
    </style>
    @yield("styles")



</head>
<body>
    <header>
        @include("layouts.navbar")
    </header>
    <main>
        @yield("content")
    </main>


    <footer class="py-4 bg-light text-black-50 mt-5">
        <div class="container text-center">
            <small>Copyright &copy; Your Website</small>
        </div>
    </footer>

<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.dropdown-submenu a.test').on("mouseover", function(e){
            $(this).closest("ul").find("ul").hide();
            $(this).next('ul').toggle();
        });
    });
</script>
@yield("scripts")
</body>
</html>