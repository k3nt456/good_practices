<?php

namespace App\Http\Requests;

use App\Traits\HasResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FoodCreateRequest extends FormRequest
{
    use HasResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'amount'    => ['required', 'string', 'max:3'],
            'kcal'      => ['required', 'string', 'regex:/^\d{1,5}(\.\d{1,3})?$/'],
            'protein'   => ['required', 'string', 'regex:/^\d{1,5}(\.\d{1,3})?$/'],
            'fat'       => ['required', 'string', 'regex:/^\d{1,5}(\.\d{1,3})?$/'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse('Formato inválido.', 400, $validator->errors()));
    }
}
