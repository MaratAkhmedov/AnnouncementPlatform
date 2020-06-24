@extends('layouts.general_template')

@section("styles")
<style>
    .imagePreview {
        width: 100%;
        height: 180px;
        background-position: center center;
        background:url(http://cliquecities.com/assets/no-image-e3699ae23f866f6cbdf8ba2443ee5c4e.jpg);
        background-color:#fff;
        background-size: cover;
        background-repeat:no-repeat;
        display: inline-block;
        box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);
    }
    .btn-primary
    {
        display:block;
        border-radius:0px;
        box-shadow:0px 4px 6px 2px rgba(0,0,0,0.2);
        margin-top:-5px;
    }
    .imgUp
    {
        margin-bottom:15px;
    }
   /* .del
    {
        position:absolute;
        top:0px;
        right:15px;
        width:30px;
        height:30px;
        text-align:center;
        line-height:30px;
        background-color:rgba(255,255,255,0.6);
        cursor:pointer;
    }*/
    .del:before{
        content: url("https://img.icons8.com/material-rounded/24/000000/remove-image.png");
        position:absolute;
        top:5px;
        left:20px;
        width:30px;
        height:30px;
        text-align:center;
        line-height:30px;
        cursor:pointer;
    }

    .imgAdd
    {
        width:30px;
        height:30px;
        border-radius:50%;
        background-color:#4bd7ef;
        color:#fff;
        box-shadow:0px 0px 2px 1px rgba(0,0,0,0.2);
        text-align:center;
        line-height:30px;
        margin-top:0px;
        cursor:pointer;
        font-size:15px;
    }
    .imgAdd:before{
        content: "+";
        width: 100%;
        height: 100%;
        text-align: center;
        display: block;
    }
</style>
@endsection

@section("scripts")
<script>
    $(".imgAdd").click(function(){
        $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-2 imgUp"><div class="imagePreview"></div>' +
            '<label class="btn btn-primary">Otra photo<input type="file" name="photos[]" class="uploadFile img" value="Upload Photo" ' +
            'style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>');
    });
    $(document).on("click", "i.del" , function() {
        $(this).parent().remove();
    });
    $(function() {
        $(document).on("change",".uploadFile", function()
        {
            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function(){ // set image data as background of div
                    //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                    uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
                }
            }

        });
    });
</script>
@endsection

@section('content')
    <div class="container">
        <form method="post" class="mt-5" action="{{isset($old_values) ? route("update", $old_values['id']) : route('store')}}" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="category">Categoría:{{$category_name}}</label>
                    <select id="category" class="form-control" name="subcategory_selected">
                        <option selected>{{$subcategory_selected}}</option>
                        @foreach($subcategories as $subcategory)
                            <option>{{$subcategory}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="form-group">
                <label for="adress">Dirección*</label>
                <input type="text" class="form-control" id="adress" name="adress" placeholder="Dirección" value="{{isset($old_values) ? $old_values["location"] : ''}}">
                @error('adress')
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->get('adress') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="announcement_name">Nombre del Producto*</label>
                <input type="text" class="form-control" id="announcement_name" name="announcement_name" placeholder="Título del anuncio"
                    value="{{isset($old_values) ? $old_values["name"] : ''}}">
                @error('announcement_name')
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->get('announcement_name') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Precio*</label>
                <input type="text" class="form-control" id="price" placeholder="$" name="price" value="{{isset($old_values) ? $old_values["price"] : ''}}">
                @error('price')
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->get('price') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @enderror



            </div>

            <div class="form-group">
                <label for="photos[]">Fotos:*</label>
               <!-- <input type="file" class="form-control" name="photos[]" />
                <input type="file" class="form-control" name="photos[]" />-->
                <div class="row">
                    @if(!isset($old_values))
                    <div class="col-sm-2 imgUp">
                        <div class="imagePreview"></div>
                        <label class="btn btn-primary">Photo principal
                            <input type="file" id="photos" name="photos[]" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                        </label>
                    </div><!-- col-2 -->

                    @else
                        @foreach($old_values["announcement_images"] as $image)
                            <div class="col-sm-2 imgUp">
                                <!-- pasamos el id de las imagenes predefinidas-->
                                <input type="hidden" name="photos[]" value="{{$image["image"]["id"]}}" class="hidden_input">
                                <!-- подставлять input type hidden с фотографиями которые билдятся через foreach и потом в on change удалять их-->

                                <div class="imagePreview" style='background-image: url("{{$image["image"]["image_url"]}}")'>
                                </div>
                                <label class="btn btn-primary">
                                    @if($image["order_index"] == 1)
                                        Photo principal
                                    @else
                                        Otra photo
                                    @endif
                                    <input type="file" name="photos[]" class="uploadFile img" value="Upload Photo"style="width:0px;height:0px;overflow:hidden;">

                                </label>
                                @if($image["order_index"] != 1)
                                    <i class="fa fa-times del"></i>
                                @endif
                            </div>
                        @endforeach
                    @endif
                    <i class="fa fa-plus imgAdd"></i>

                </div><!-- row -->
                @error('photos')
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->get('photos') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror
                @if ($errors->has('photos.*'))
                    <div class="alert alert-danger">
                        @foreach($errors->get('photos.*') as $error)
                            <li>{{ "Solo son compatibles los formatos .jpeg, .png, .jpg, el tamaño máximo de la imagen debe ser de 2 MB" }}</li>
                        @endforeach
                    </div>
                @endif

            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <input type="text" class="form-control" id="description" placeholder="" name="description" value="{{isset($old_values) ? $old_values["description"] : ''}}">
                @error('description')
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->get('description') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror
            </div>

            {{ csrf_field() }}

            @if(@isset($old_values))
                @method('put')
            @else
                @method('post')
            @endif


            <button type="submit" class="btn btn-primary">Siguiente</button>
        </form>
    </div>
@endsection