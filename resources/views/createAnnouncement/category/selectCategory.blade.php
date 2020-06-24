@extends('layouts.general_template')

@section('content')
    <div class="container">
        <h2 class="mt-3"><strong>¿Qué quiere vender?</strong></h2>
        @foreach($category_array as $category)
            @include("createAnnouncement.category.category_card", ["category" => $category["category_name"],
                                    "subcategory_array" => $category["subcategories"]])
        @endforeach
    </div>
@endsection