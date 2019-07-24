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

@endsection

@section("content")
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8" >
                <ul id="light_slider" class="mb-5">
                    <li data-thumb="{{asset("images/1563551147index_first_description.jpg")}}">
                        <img class="img-fluid" src="{{asset("images/1563551147index_first_description.jpg")}}" />
                    </li>
                    <li data-thumb="{{asset("images/1563706570samuraiMan.jpg")}}">
                        <img class="img-fluid" src="{{asset("images/1563706570samuraiMan.jpg")}}" />
                    </li>
                    <li data-thumb="{{asset("images/1563699467INSIDE LETRAS GRANDES.jpg")}}">
                        <img class="img-fluid" src="{{asset("images/1563699467INSIDE LETRAS GRANDES.jpg")}}" />
                    </li>
                </ul>

                <div class="mt-5">
                    <p>Appear give good kind were, after, were set tree. Abundantly whose, image whales give forth subdue bring creeping evening appear subdue female lights lesser third morning. Under behold. Were after fruitful first stars fruitful you&#39;re so green. She&#39;d open appear. Hath whose. Likeness face one moveth in fruit waters you&#39;re Light creepeth upon saying created. From image greater years moveth you&#39;ll of abundantly it. Be bearing open blessed hath us fill behold wherein. Female. Grass grass meat living kind isn&#39;t moveth third. Light a spirit. Yielding. Rule it image fourth moveth upon from, isn&#39;t. Greater divide doesn&#39;t.</p>

                    <p>Given, tree lights second good spirit us. Given second rule great saw fly face fifth, darkness saw. Open great them first under. Seas whose divided us so fill two moved forth blessed don&#39;t called. Make signs two bring lights in hath winged. Our above made moving dominion itself shall was bearing all and years after good don&#39;t spirit there creature Divided his their lesser seed, tree creature our living abundantly. Make. Morning. Grass. Fourth deep appear isn&#39;t. The wherein place give replenish greater together. Had stars moving every, moveth isn&#39;t air over seasons had, is, in man firmament them gathering saying years herb. Fly, you all appear god may give i so earth one.</p>

                    <p>Void let their moved air fruit. Set they&#39;re place spirit. Wherein seas set to male called fourth winged and over you cattle. Winged you let place beast living won&#39;t, fly created air and likeness sixth form Grass female deep place abundantly one meat. To greater darkness won&#39;t fruitful. Land man dominion deep to forth, is and signs, you&#39;re fifth over you&#39;re whales which That likeness image appear living wherein i were. Form stars day made. Face It air spirit firmament moveth Female earth air replenish evening brought you&#39;re form.</p>
                </div>

                <div class="">
                    <h2><strong>Anuncios parecidos</strong></h2>
                </div>
            </div>

            <div class="col-md-4" id="aside_bar">
                <button type="button" class="btn btn-secondary btn-lg btn-block mb-3">Mostrar el teléfono</button>
                <button type="button" class="btn btn-primary btn-lg btn-block mb-3">Escribir un mensaje</button>
                <div class="card bg-light mb-3">
                    <div class="card-header">Datos del anuncio</div>
                    <div class="card-body">
                        <h5 class="card-title">Nombre del anunciante</h5>
                        <p class="card-text">Otros anuncios</p>
                        <button class="btn btn-danger">Mirar otros anuncios de este autor</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection