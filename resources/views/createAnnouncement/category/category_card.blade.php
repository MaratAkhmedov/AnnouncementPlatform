   <div class="card mt-5">
    <div class="card-header">
            <div style="margin-left: 10px">
                {{$category}}
            </div>
    </div>
    <div class="card-body">
                <p>
                    @foreach($subcategory_array as $subcategory)
                        <a  class="btn btn-outline-dark" style="margin-left: 10px; margin-right: 10px" href={{route("announcementForm", "$subcategory->id")}}>
                                {{"$subcategory->name"}}
                        </a>
                    @endforeach
                </p>
    </div>
   </div>