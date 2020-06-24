<?php

namespace App\Http\Controllers\Profile;

use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Notifications\email\ModifyEmail;

class EditProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('signed')->only('email_modify');
        $this->middleware('throttle:5,1')->only('email_modify', 'email_modify_send');
    }

    /**
     * Show the index page of user with his announcements that were published before.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $array = User::find(Auth::getUser()->id)->toArray();
        return view("profile.edit_profile")->with("user", $array);
    }

    /**
     * update profile info
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::getUser()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->save();
        return redirect()->back();
    }

    /**
     * update email
     */
    public function email_modify_send(Request $request){
        $request->validate([
            'email' => '|required|unique:users|max:255',
        ]);

        //guardamos en la session y luego lo actualizamos cuando pasa por el link
        //Session::put("newEmail", $request->email);
        //$request->user()->sendEmailVerificationNotification();

        //$request->user()->notify(new ModifyEmail($details));
        //Mail::to("igugle4@gmail.com", new ModifyEmail($details));
        Notification::route('mail', $request->email)->notify(new ModifyEmail($request->email));
        //$request->user()->notify(new ModifyEmail($details));

        /*$user = User::find(Auth::id());
        $user->email = $request->email;
        //$user->email_verified_at = null;
        //на другиз страницах сохраняет новый емаил только после поттверэения если не подтверждается то остается старый
        $user->save();
        $user->sendEmailVerificationNotification();*/
        return redirect()->back()->with("message", "Hemos enviado un link a su correo, por favor verifícalo");
    }

    public function email_modify(Request $request){
        if ($request->id != $request->user()->getKey()) {
            throw new AuthorizationException();
        }
        $user = User::find($request->id);
        $user->email = $request->newEmail;
        $user->email_verified_at = Carbon::now()->toDateTimeString();
        $user->save();
        return redirect()->back()->with("message", "El nuevo correo ha sido verificado");
    }

    public function password_modify(Request $request){
        $validatedData = $request->validate([
            'new_password' => 'required|max:255|confirmed|min:8',
            'old_password' => 'required',
        ],
        ['requiered' => "Este campo es requerido",
          'confirmed' => "La nueva contraseña y su confirmación no coinciden",
            'min' => "longitud mínima debe ser de 8 carácteres"
        ]);

        $hashedPassword = User::find(Auth::user()->id)->password;

        if (Hash::check($request->old_password, $hashedPassword)) {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with("password_changed", "La contraseña se ha guardado correctamente");
        }
        else{
            return redirect()->back()->withErrors(["old_password" => "La contraseña no es correcta"]);
        }
    }
}
