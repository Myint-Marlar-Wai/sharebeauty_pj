<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
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
            'token' => 'required',
            'email' => 'required|email|regex:/^[a-zA-Z0-9!-~]+$/',
            'password' => 'required|min:8|regex:/^[a-zA-Z0-9!-~]+$/',
        ];
    }

    public function messages()
    {
        return [
            'token.required' => '最初からやり直して下さい',
            'email.required' => 'IDは必須項目です。',
            'email.email' => '正しいIDを入力して下さい。',
            'email.regex' => 'IDは｛IDルール｝で入力してください',
            'password.required' => 'パスワードは必須項目です。',
            'password.min' => 'パスワードは半角英数字8文字以上で設定してください。',
            'password.regex' => 'パスワードは半角英数字8文字以上で設定してください。',
        ];
    }
}
