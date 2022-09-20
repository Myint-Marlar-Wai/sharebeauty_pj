<?php

namespace App\Services;

use App\Auth\SellerAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Seller;
use App\Models\SellerPassword as OncePassword;
use App\Models\PasswordReset;

/**
 * @deprecated legacy
 */
class PasswordService
{
    public function resetPassword($token, $email, $password)
    {
        $reset_data = PasswordReset::where('email', $email)->first();
        if(is_null($reset_data)) {
            return dd('申請URLが正しくありません');;
            return redirect('/');
        }
        $reset_token = $reset_data->token;
        $result = Hash::check($token, $reset_token);
        if (is_null($result) || $result === false) {
            // パスワードが不一致
            dd('登録したIDを入力してください');
            back()->withErrors(['email' => '登録したIDを入力してください']);
        }
        $once = Seller::where('email', '=', $email)->first();
        if(is_null($once)) {
            return dd('だめ');;
            return redirect('/');
        }
        $once_password = OncePassword::where('once_id', '=', $once->id)->first();
        $new_password = Hash::make($password);
        $once_password->password = $new_password;
        $once_password->save();
        return $once_password;
    }

    public function updatePassword($password, $new_password)
    {
        // debug ログインユーザ取得
        $once = SellerAuth::user();
        if(is_null($once)) {
            dd('IDが登録されていません');
        }
        $once_password = OncePassword::where('once_id', '=', $once->id)->first();
        $result = Hash::check($password, $once_password->password);
        // dd($result);
        if(!$result) {
            // パスワードが一致しない場合
            dd('一致しないよ');
        }
        $new_password = Hash::make($new_password);
        $once_password->password = $new_password;
        $once_password->save();
        return $once_password;
    }
}
