    <div class="card mt-5">
                {{$category}}
        <hr>
                <p>
                    @foreach($subcategory_array as $subcategory)
                        <a  class="" href={{route("announcementForm", "$subcategory->id")}}>
                                {{"<$subcategory->name>"}}
                        </a>
                    @endforeach
                </p>
    </div>
