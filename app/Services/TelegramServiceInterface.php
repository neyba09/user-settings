<?php

namespace App\Services;

use App\Models\ConfirmationCode;
use App\Models\User;

class TelegramServiceInterface implements ConfirmationServiceInterface
{
    public function sendCode(User $user, string $method)
    {
        $code = rand(11111, 99999);
        ConfirmationCode::create(['user_id' => $user->id, 'code' => $code, 'type' => $method]);
    }

    public function verifyCode($user, string $code, string $method): bool
    {
        $confirmationCode = ConfirmationCode::where('user_id', $user->id)
            ->where('type', $method)
            ->latest()
            ->first();

        return $confirmationCode && $confirmationCode->code === $code;
    }
}
