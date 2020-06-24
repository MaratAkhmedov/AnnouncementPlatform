<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAnnouncementValidation extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'price' => 'required|numeric',
            'announcement_name' => 'required|min:2|max:100',
            //'photos'=>'required',
            //'photos.*' => 'mimes:jpeg,png,jpg|max:2048',
            'adress' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        $message = [
            'required' => 'Tienes que rellenar el campo',
            'price.numeric' => 'Hay que introducir el precio con cifras',
            //'photos.required' => 'Hay que cargar por lo menos una imagen',
            'announcement_name.min' => 'La longitud mínima es de 2 símbolos',
            'announcement_name.max' => 'La longitud máxima es de 100 símbolos',
            'photos.max' => 'El tamaño máximo de la imagen debe ser de 2 MB',
        ];

        return $message;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $photoArray = $this->photos;
            foreach ($photoArray as $photo){
                if(is_file($photo)){
                    $allowedfileExtension = ["jpeg","jpg","JPG","PNG", "png"];
                    $extension = $photo->getClientOriginalExtension();
                    $compatible = in_array($extension, $allowedfileExtension);
                    if($compatible == false){
                        $validator->errors()->add('photos', 'Solo son compatibles las imagenes del formato .png y .jpg');
                    }

                    if($photo->getSize() >= 2097152){
                        $validator->errors()->add('photos', 'El tamaño máximo de la imagen es de 2 MB');
                    }
                }
            }

            /*if (! empty($currentPassword) && ! Hash::check($currentPassword, $this->user()->password)) {
                $validator->errors()->add('current_password', 'Текущий пароль не совпадает с указанным паролем.');
            }

            if (! empty($currentPassword) && ! strcmp($currentPassword, $this->password)) {
                $validator->errors()->add('password', 'Новый пароль не может совпадать с текущим паролем.');
            }

            if (! empty($this->password) && mb_strlen($this->password) < 6) {
                $validator->errors()->add('password', 'Пароль должен содержать минимум 6 символов.');
            }*/
        });
    }
}
