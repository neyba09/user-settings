<?php

namespace App\Services;

use App\Models\User;

interface ConfirmationServiceInterface
{
    public function sendCode(User $user, string $method);

    public function verifyCode(User $user, string $code, string $method): bool;
}
