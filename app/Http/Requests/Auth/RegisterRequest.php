<?php

namespace App\Http\Requests\Auth;

use App\Http\Controllers\api\ApiRespose;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class RegisterRequest extends FormRequest
{
    use ApiRespose;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'between:2,100'],
            'last_name' => ['required', 'string', 'between:2,100'],
            'emailOrNumber' => ['required','unique:users', 'email_or_phone'],
            'password' => ['required', 'string', 'min:6'],

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse(null, $validator->getMessageBag(), 422));
    }


}
