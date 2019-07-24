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
        <form method="post" class="mt-5" action="{{route("store")}}" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="category">Categoría:<a class="ml-3" href="{{route("addAnnouncement")}}">  {{$category_name}}</a></label>
                    <select id="category" class="form-control" name="subcategory_selected">
                        <option selected>{{$subcategory_selected}}</option>
                        @foreach($subcategories as $subcategory)
                            <option>{{$subcategory}}</option>
                        @endforeach
                    </select>
                </div>

               <!-- <div class="form-group col-md-6">
                    <label for="inputState">Тип</label>
                    <select id="inputState" class="form-control">
                        <option selected>Choose...</option>
                        <option>...</option>
                    </select>
                </div>
                -->
            </div>
            <div class="form-group">
                <label for="adress">Dirección*</label>
                <input type="text" class="form-control" id="adress" name="adress" placeholder="Улица">
            </div>

            <!--<div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">Ciudad*</label>
                    <input type="text" class="form-control" id="city" name="city">
                </div>
                <div class="form-group col-md-4">
                    <label for="province">Provincia</label>
                    <select id="province" class="form-control" name="province">
                        <option selected>Alicante</option>
                        <option>Valencia</option>
                        <option>Barcelona</option>
                        <option>Madrid</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="zip">Индекс*</label>
                    <input type="text" class="form-control" id="zip" name="zip">
                </div>
            </div>-->

            <div class="form-group">
                <label for="announcement_name">Nombre del Producto*</label>
                <input type="text" class="form-control" id="announcement_name" name="announcement_name" placeholder="Название товара">
            </div>

            <div class="form-group">
                <label for="price">Precio*</label>
                <input type="text" class="form-control" id="price" placeholder="$" name="price">
            </div>

            <div class="form-group">
                <label for="photos[]">Fotos:*</label>
               <!-- <input type="file" class="form-control" name="photos[]" />
                <input type="file" class="form-control" name="photos[]" />-->
                <div class="row">
                    <div class="col-sm-2 imgUp">
                        <div class="imagePreview"></div>
                        <label class="btn btn-primary">Photo principal
                            <input type="file" name="photos[]" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                        </label>
                    </div><!-- col-2 -->
                    <i class="fa fa-plus imgAdd"></i>
                </div><!-- row -->
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <input type="text" class="form-control" id="description" placeholder="" name="description">
            </div>

            {{ csrf_field() }}

            <button type="submit" class="btn btn-primary">Siguiente</button>
        </form>
    </div>
@endsection