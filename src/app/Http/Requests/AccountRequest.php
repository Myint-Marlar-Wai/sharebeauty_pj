<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'bank_code' => 'required|numeric|regex:/^\d{4}$/',
            'bank_name' => 'required|max:15',
            'branch_code' => 'required|numeric|regex:/^\d{3}$/',
            'branch_name' => 'required|max:15',
            'account_type' => 'required|numeric',
            'account_number' => 'required|numeric|regex:/^\d{7}$/',
            'account_name' => 'required|max:30',
            'account_kana' => 'max:30',
            'account_memo' => 'max:400',
        ];
    }

    public function messages()
    {
        return [
            'bank_code.required' => '銀行コードは必須項目です。',
            'bank_code.numeric' => '銀行コードは半角数字で入力してください。',
            'bank_code.regex' => '銀行コードは4桁で入力してください。',
            'bank_name.required' => '銀行名は必須項目です。',
            'bank_name.max' => '銀行名は最大15文字以内で入力してください。',
            'branch_code.required' => '支店コードは必須項目です。',
            'branch_code.numeric' => '支店コードは半角数字で入力してください。',
            'branch_code.regex' => '支店コードは3桁で入力してください。',
            'branch_name.required' => '支店名は必須項目です。',
            'branch_name.max' => '支店名は最大15文字以内で入力してください。',
            'account_type.required' => '預金種別は必須項目です。',
            'account_number.required' => '口座番号は必須項目です。',
            'account_number.numeric' => '口座番号は半角数字で入力してください。',
            'account_number.regex' => '口座番号は7桁で入力してください。',
            'account_name.required' => '口座名義は必須項目です。',
            'account_name.max' => '口座名義は最大30文字以内で入力してください。',
            'account_kana.max' => '口座名義かなは最大30文字以内で入力してください。',
            'account_memo.max' => '備考は最大400文字以内で入力してください。',
        ];
    }
}
