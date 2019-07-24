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
        .margin{
            margin-top: 80px;
        }

    </style>
    @yield("styles")



</head>
<body>
    @include("layouts.navbar")
    <div class="margin"></div>
    @yield("content")


    <footer class="py-4 bg-light text-black-50 mt-5">
        <div class="container text-center">
            <small>Copyright &copy; Your Website</small>
        </div>
    </footer>

<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
@yield("scripts")
</body>
</html>