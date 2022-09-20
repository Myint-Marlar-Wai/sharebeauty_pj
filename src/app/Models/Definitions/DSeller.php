<?php

declare(strict_types=1);

namespace App\Models\Definitions;

class DSeller extends BaseDefinition
{
    public string $id;

    public string $email;

    public string $email_verified_at;

    public string $google_id;

    public string $migrated_at;

    public string $registration_completed_at;

    public string $last_modified_admin_id;
}
