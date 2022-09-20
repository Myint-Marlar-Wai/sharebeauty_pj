<?php

namespace App\Services;

class AccountService
{
    public function editAccount($once, $account, $request)
    {
        $account->once_id = $once->id;
        (int)$bank_code = $request->bank_code;
        $account->bank_code = $bank_code;
        $account->bank_name = $request->bank_name;
        (int)$branch_code = $request->branch_code;
        $account->branch_code = $branch_code;
        $account->branch_name = $request->branch_name;
        (int)$account_type = $request->account_type;
        $account->account_type = $account_type;
        (int)$account_number = $request->account_number;
        $account->account_number = $account_number;
        $account->account_name = $request->account_name;
        $account->account_kana = $request->account_kana;
        $account->account_memo = $request->account_memo;
        $account->alert_flag = 0;
        $account->alert_message = $request->alert_message;
        $account->delete_flag = 0;
        $account->lastmodified_id = $once->id;
        $account->save();

        return $account;
    }
}