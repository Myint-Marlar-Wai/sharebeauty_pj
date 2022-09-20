<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OnceRequest extends FormRequest
{
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
            'email' => 'required|email|regex:/^[a-zA-Z0-9!-~]+$/',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'IDは必須項目です。',
            'email.email' => '正しいIDを入力して下さい。',
            'email.regex' => 'IDは｛IDルール｝で入力してください',
        ];
    }
}
