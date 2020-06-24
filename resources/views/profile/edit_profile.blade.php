@extends("profile.profile_template")

@section("styles")
    @parent
    <style>

    </style>
@endsection

@section("scripts")
    @parent
    <script>
        $(document).ready(function() {
            $("#3").addClass("text-white bg-secondary");
        });
    </script>
@endsection

@section("information")
    <div class="col-md-9">
         <form method="POST" class="p-3 border border-info rounded" action="{{ route('profile_update') }}">
                    @csrf
             <h2 class="m-3">Modificar los datos del usuario</h2>

                    <div class="form-group row">
                        <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('auth.first_name') }}</label>

                        <div class="col-md-8">
                            <input id="first_name" type="text" class="form-control @error('name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $user["first_name"]) }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('auth.last_name') }}</label>

                        <div class="col-md-8">
                            <input id="last_name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name" value="{{ old('last_name' , $user["last_name"]) }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('auth.phone') }}</label>

                        <div class="col-md-8">
                            <input id="phone" type="text" class="form-control" name="phone" value="{{old('last_name',$user["phone"])}} " required autocomplete="name" autofocus>

                        </div>
                    </div>

                <div class="form-group row mb-0">
                 <div class="col-md-6 offset-md-4">
                     <button type="submit" class="btn btn-secondary">
                         {{ "Modificar" }}
                     </button>
                 </div>
                </div>
                </form>

        <form method="POST" class="mt-5 p-3 border border-info rounded" action="{{ route('email.modify.send') }}">
        @csrf
            <h2 class="m-3">Modificar el correo electrónico</h2>
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('auth.email') }}</label>

                <div class="col-md-8">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror mb-2" name="email" value="{{ old('email', $user["email"]) }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <span style="color: green;" class="">{{session("message") ? session("message") : ""}}</span>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-secondary">
                        {{ "Modificar" }}
                    </button>
                </div>
            </div>
        </form>

        <form method="POST" class="mt-5 p-3 border border-info rounded" action="{{ route('password.modify') }}">
            @csrf
            <h2 class="m-3">Modificar la contraseña</h2>
            <div class="form-group row">
                <label for="old_password" class="col-md-4 col-form-label text-md-right">{{"Contraseña antigua"}}</label>
                <div class="col-md-8">
                    <div class="col-md-8">
                        <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror mb-2" name="old_password" required>
                        @error('old_password')
                        <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="form-group row">
                <label for="new_pasword" class="col-md-4 col-form-label text-md-right">{{"Contraseña nueva"}}</label>
                <div class="col-md-8">
                    <div class="col-md-8">
                        <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror mb-2" name="new_password" required>
                        @error('new_password')
                        <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-right">{{"Repita la contraseña nueva"}}</label>
                <div class="col-md-8">
                    <div class="col-md-8">
                        <input id="new_password_confirmation" type="password" class="form-control @error('repeat_new_password') is-invalid @enderror mb-2" name="new_password_confirmation" required>
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <span style="color: green;" class="">{{session("password_changed") ? session("password_changed") : ""}}</span>



            <div class="form-group row mb-0 mt-2">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-secondary">
                        {{ "Modificar" }}
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>
@endsection