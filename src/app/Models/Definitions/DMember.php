<?php

declare(strict_types=1);

namespace App\Models\Definitions;

class DMember extends BaseDefinition
{
    public string $id;

    public string $display_member_id;

    public string $email;

    public string $email_verified_at;

    public string $purchased_at;

    public string $registration_completed_at;

    public string $last_modified_admin_id;

}
