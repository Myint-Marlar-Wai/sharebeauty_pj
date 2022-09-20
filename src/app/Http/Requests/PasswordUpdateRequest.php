<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @deprecated old
 */
class PasswordUpdateRequest extends FormRequest
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
            'password' => 'required|min:8|regex:/^[a-zA-Z0-9!-~]+$/',
            'new_password' => 'required|min:8|regex:/^[a-zA-Z0-9!-~]+$/',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => '現在のパスワードは必須項目です。',
            'password.min' => '現在のパスワードは半角英数字8文字以上で設定してください。',
            'password.regex' => '現在のパスワードは半角英数字8文字以上で設定してください。',
            'new_password.required' => '新しいパスワードは必須項目です。',
            'new_password.min' => '新しいパスワードは半角英数字8文字以上で設定してください。',
            'new_password.regex' => '新しいパスワードは半角英数字8文字以上で設定してください。',
        ];
    }
}
