@extends("layouts.general_template")

@section("styles")
    <link type="text/css" rel="stylesheet" href="/css/lightslider.css" />
    <style>
        #light_slider img {
            width: 100vw;
            margin-top: 0px !important;
        }

        #aside_bar .card{
            width: 100%;
        }


        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 99999; /* Sit on top */
            padding-top: 20rem; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
        }

        /* The Close Button */
        .close {
            position: absolute;
            right: 1rem;
            top: 0.5rem;
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .inside-model{
            text-align: center;
            font-size: 2rem;
        }


    </style>
@endsection

@section("scripts")
    <script src="/js/lightslider.js"></script>
    <script type="text/javascript">

        $('#light_slider').lightSlider({
            gallery: true,
            item: 1,
            loop: true,
            slideMargin: 0,
            thumbItem: 6
        });
    </script>


    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("show_phone");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

@endsection

@inject('provider', 'App\Http\Controllers\AnnouncementController')

@section("content")
    <div>
    </div>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8" >
                <ul id="light_slider" class="mb-5">
                    <?php
                       foreach($announcement["announcement_images"] as $element){
                           //dd($element["image"]["image_url"]);
                            echo '<li data-thumb="'. $element["image"]["image_url"].'">';
                            echo '<img class="img-fluid" src="'. $element["image"]["image_url"]. '" />';
                            echo '</li>';
                       }
                    ?>
                </ul>

                <div class="mt-5 mb-5">
                    <h2 class="mb-3"><strong>Descripción</strong></h2>
                    <?php echo $announcement["description"]; ?>
                </div>

                <div class="">
                    <h2><strong>Anuncios parecidos</strong></h2>
                </div>
            </div>

            <div class="col-md-4" id="aside_bar">
                <button type="button" class="btn btn-secondary btn-lg btn-block mb-3" id="show_phone">Teléfono {{substr($announcement["user"]["phone"], 0, -3)."XXX"}}</button>
                <div id="myModal" class="modal">

                    <!-- Modal content -->
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <article class="inside-model">
                            <p>Nombre: {{$announcement["user"]["first_name"]}}</p>
                            <p style="display: inline; margin-right: 1rem">Teléfono</p>
                            <?php
                            $string = $announcement["user"]["phone"];
                            $font   = 5;
                            $width  = ImageFontWidth($font) * strlen($string)+8;
                            $height = ImageFontHeight($font)+8;
                            $im = @imagecreate ($width,$height);
                            $background_color = imagecolorallocate ($im, 255, 255, 255); //white background
                            $text_color = imagecolorallocate ($im, 0, 0,0);//black text
                            imagestring ($im, $font, 0, 0, $string, $text_color);
                            ob_start();
                            imagepng($im);
                            $imstr = base64_encode(ob_get_clean());
                            imagedestroy($im);
                            //echo "<img style='width: 15rem;height: 4rem' src='data:image/png;base64,$imstr'/>";
                            ?>
                        <img style="display: inline;width: 12rem;height: 3rem;" src="data:image/png;base64,{{ $imstr }}"/>
                        </article>
                    </div>

                </div>


                <button type="button" class="btn btn-primary btn-lg btn-block mb-3">Escribir mensaje</button>
                <div class="card bg-light mb-3">
                    <div class="card-header">Datos del anuncio</div>
                    <div class="card-body">
                        <p class="card-text">Nombre: <strong>{{$announcement["user"]["first_name"]}}</strong></p>
                        <p class="card-text">Fecha: <strong>{{$announcement["updated_at"]}}</strong></p>
                        <p class="card-text">Registrado desde: <strong>{{$announcement["user"]["created_at"]}}</strong></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection