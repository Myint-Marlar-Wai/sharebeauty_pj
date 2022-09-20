<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendContactRequest extends FormRequest
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
            'contact_category' => 'required',
            'name' => 'required_if:is_not_login,1|max:100',
            'email' => 'required_if:is_not_login,1|email',
            'content' => 'required|string|max:10000'
        ];
    }

    public function messages()
    {
        return [
            'contact_category.required' => '選択してください。',
            'name.required_if' => '入力してください。',
            'name.max' => 'ご担当者名は100文字まで入力できます。',
            'email.required_if' => '入力してください。',
            'email.email' => '正しいメールアドレスを入力して下さい。',
            'content.required' => '入力してください。',
            'content.max' => 'お問い合わせ内容は10,000文字まで入力できます。',
        ];
    }
}
