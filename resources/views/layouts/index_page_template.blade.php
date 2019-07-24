@extends("layouts.general_template")

@section("content")
    <div class="container" style="margin-top: 100px">
            <div class="row">
                <div class="col-md-8 col-lg-9">
                    @yield("page_content")
                    <div class="text-center" style="position: absolute; left: 50%">
                        @yield("pagination")
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    @yield("aside")
                </div>
            </div>
    </div>
@endsection