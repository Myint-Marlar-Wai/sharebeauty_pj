<?php

namespace App\Services;

class ProfileService
{
    public function editProfile($once, $profile, $request)
    {
        $profile->once_id = $once->id;
        $profile->name = $request->name;
        $profile->disp_name = $request->disp_name;
        (int)$gender = $request->gender;
        $profile->gender = $gender;
        $year = $request->year;
        $month = $request->month;
        $day = $request->day;
        $profile->birthday = $year. '-'. $month. '-'. $day;
        (int)$zip = $request->zip;
        $profile->zip = $zip;
        $profile->pref_code = $request->pref_code;
        $profile->address = $request->address;
        $profile->address_other = $request->address_other;
        (int)$tel = $request->tel;
        $profile->tel = $tel;
        $profile->image = $request->image;
        $profile->introduction = $request->introduction;
        // debug マスタテーブル作成する必要あり
        $profile->category = $request->category;
        $profile->store_name = $request->store_name;
        $profile->lastmodified_id = $once->id;
        $profile->save();

        return $profile;
    }
}