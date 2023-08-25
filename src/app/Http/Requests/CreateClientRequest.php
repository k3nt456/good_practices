<?php

namespace App\Http\Requests;

use App\Traits\HasResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateClientRequest extends FormRequest
{
    use HasResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dni'       => ['required', 'numeric', 'digits:8'],
            'email'     => ['required', 'email'],
            'password'  => ['required', 'string', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[$@$!.#%*?&])[A-Za-z\d$@$!.#%*?&]{8,}$/'],
        ];
        /*
        Las reglas para la contraseña son:

        Al menos una letra mayúscula ((?=.*[A-Z])).
        Al menos una letra minúscula ((?=.*[a-z])).
        Al menos un dígito ((?=.*\d)).
        Al menos un carácter especial de los siguientes: $@$!.#%*?& ((?=.*[$@$!.#%*?&])).
        La longitud mínima de la contraseña debe ser de 8 caracteres ({8,}).
         */
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse('Formato inválido.', 400, $validator->errors()));
    }
}
