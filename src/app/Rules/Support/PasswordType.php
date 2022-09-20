<?php

declare(strict_types=1);

namespace App\Rules\Support;

enum PasswordType
{
    case Strict;
    case Loose;
}
