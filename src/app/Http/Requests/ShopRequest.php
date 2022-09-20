<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'shop_create_name' => 'required|max:60',
            'shop_create_result' => 'required|max:20',
            'shop_introduction' => 'required|max:400',
            // 'image1' => 'required',
            // 'image2' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'shop_create_name.required' => '表示ショップ名は必須項目です。',
            'shop_create_name.max' => '表示ショップ名は最大60文字以内で入力してください。',
            'shop_create_result.required' => 'ショップURLは必須項目です。',
            'shop_create_result.max' => 'ショップURLは最大20文字以内で入力してください。',
            'shop_introduction.required' => 'ショップ紹介文は必須項目です。',
            'shop_introduction.max' => 'ショップ紹介文は最大400文字以内で入力してください。',
        ];
    }
}
