<?php

namespace App\Services;

use App\Models\SellerProfile;
use App\Models\ShopProduct;

class ShopService
{
    public function shopCreate($once, $shop, $request)
    {
        $shop->display_shop_id = $request->shop_create_name;
        $shop->once_id = $once->id;
        $shop->parent_shop_id = null;
        $shop->shop_name = $request->shop_create_result;
        $shop->shop_text = $request->shop_introduction;
        $shop->image1 = $request->image1;
        $shop->image2 = $request->image2;
        $shop->shop_type = 0;
        $shop->franchise_flag = 0;
        $shop->template_id = 0;
        $shop->display_flag = 0;
        $shop->delete_flag = 0;
        $shop->lastmodified_id = $once->id;
        $shop->save();
        return $shop;
    }

    public function shopPublish($user, $shop, $pattern)
    {
        if($pattern == 0) {
            // 非公開
            //指定ショップのオーナーである
            if($user->id !== $shop->once_id) {
                $message = 'ご指定のショップの公開設定はできません';
                return view('shop.publishing-settings', compact('message'));
            }
            // プロフィール登録確認
            $profile = SellerProfile::where('once_id', '=', $shop->once_id)
                ->where('delete_flag', '=', 0)
                ->first();
            if(is_null($profile)) {
                $message = 'ショップ公開にはプロフィールの登録が必要です。プロフィール画面へ遷移します。';
                return view('auth.profile', compact('message'));
            }
            // 指定ショップの公開ステータスが「公開」もしくは「休止中」である
            if($shop->display_flag == 0) {
                $message = 'ご指定のショップは既に非公開に設定されています';
                return view('shop.shop-create', compact('message'));
            }
            $shop->display_flag = (int)$pattern;
            $shop->lastmodified_id = $user->id;
            $shop->save();
        } elseif($pattern == 1) {
            // 公開
            //指定ショップのオーナーである
            if($user->id !== $shop->once_id) {
                $message = 'ご指定のショップの公開設定はできません';
                return view('shop.publishing-settings', compact('message'));
            }
            // プロフィール登録確認
            $profile = SellerProfile::where('once_id', '=', $shop->once_id)
                ->where('delete_flag', '=', 0)
                ->first();
            if(is_null($profile)) {
                $message = 'ショップ公開にはプロフィールの登録が必要です。プロフィール画面へ遷移します。';
                return view('auth.profile', compact('message'));
            }
            // 指定ショップの公開ステータスが「非公開」もしくは「休止中」である
            if($shop->display_flag == 1) {
                $message = 'ご指定のショップは既に公開に設定されています';
                return view('shop.shop-create', compact('message'));
            }
            // 販売商品が1つ以上登録されている
            $shopProduct = ShopProduct::where('shop_id', '=', $shop->id)->first();
            if($shopProduct <= 0) {
               // 販売商品が1つ以上登録されていない場合
                dd('どうする？');
            }
            $shop->display_flag = (int)$pattern;
            $shop->display_date = now();
            $shop->lastmodified_id = $user->id;
            $shop->save();
        } elseif($pattern == 2) {
            // 休止
            //指定ショップのオーナーである
            if($user->id !== $shop->once_id) {
                $message = 'ご指定のショップの公開設定はできません';
                return view('shop.publishing-settings', compact('message'));
            }
            // プロフィール登録確認
            $profile = SellerProfile::where('once_id', '=', $shop->once_id)
                ->where('delete_flag', '=', 0)
                ->first();
            if(is_null($profile)) {
                $message = 'ショップ公開にはプロフィールの登録が必要です。プロフィール画面へ遷移します。';
                return view('auth.profile', compact('message'));
            }
            // 指定ショップの公開ステータスが「非公開」もしくは「公開」である
            if($shop->display_flag == 2) {
                $message = 'ご指定のショップは既に休止に設定されています';
                return view('shop.shop-create', compact('message'));
            }
            $shop->display_flag = (int)$pattern;
            $shop->lastmodified_id = $user->id;
            $shop->save();
        }
        return $shop;
    }
}
