<?php

declare(strict_types=1);

namespace App\Models\Definitions;

class DMemberProfile extends BaseDefinition
{
    public string $id;

    public string $member_id;

    public string $last_name;

    public string $first_name;

    public string $last_name_kana;

    public string $first_name_kana;

    public string $zip;

    public string $pref_code;

    public string $address;

    public string $address_other;

    public string $tel;

    public string $gender;

    public string $birthday;

    public string $last_modified_admin_id;

}
