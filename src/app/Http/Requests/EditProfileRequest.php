<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
            'name' => 'required|max:30',
            'disp_name' => 'required|max:20',
            'gender' => 'required',
            'zip' => 'required|numeric|regex:/^\d{7}$/',
            'pref_code' => 'required',
            'address' => 'required|max:255',
            'address_other' => 'required|max:255',
            'tel' => 'required|numeric|digits_between:8,11',
            'introduction' => 'required|max:400',
            'category' => 'required',
            'store_name' => 'required|max:60',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前は必須項目です。',
            'disp_name.required' => '表示名は必須項目です。',
            'disp_name.max' => '表示名は最大20文字以内で入力して下さい。',
            'gender.required' => '性別は必須項目です。',
            'zip.required' => '郵便番号は必須項目です。',
            'zip.numeric' => '郵便番号は数字で入力してください。',
            'zip.regex' => '郵便番号は7桁で入力してください。',
            'pref_code.required' => '都道府県は必須項目です。',
            'address.required' => '住所は必須項目です。',
            'address.max' => '住所は最大255文字以内で入力して下さい。',
            'address_other.required' => '住所その他は必須項目です。',
            'address_other.max' => '住所その他は最大255文字以内で入力して下さい。',
            'tel.required' => '電話番号は必須項目です。',
            'tel.numeric' => '電話番号は半角数字で入力して下さい。',
            'tel.digits_between' => '電話番号は8〜11桁で入力して下さい。',
            'introduction.required' => '紹介文は必須項目です。',
            'introduction.max' => '紹介文は最大400文字以内で入力して下さい。',
            'category.required' => '業種は必須項目です。',
            'store_name.required' => '店舗名は必須項目です。',
            'store_name.max' => '店舗名は最大60文字以内で入力して下さい。',
        ];
    }
}
