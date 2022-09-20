<?php

namespace App\Services;

class OnceService
{
    public function editAccount($once, $email)
    {
        $once->email = $email;
        $once->email_verified_at = null;
        $once->save();

        return $once;
    }
}