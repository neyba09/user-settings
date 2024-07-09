<?php

namespace App\Services;

use App\Mail\ConfirmationCodeEmail;
use App\Models\ConfirmationCode;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailServiceInterface implements ConfirmationServiceInterface
{
    public function sendCode(User $user, string $method)
    {
        $code = rand(11111, 99999);
        Mail::to($user->email)->send(new ConfirmationCodeEmail($user, $code));
        if(ConfirmationCode::query()->where('type', 'email')) {
            return ConfirmationCode::query()->update(['code' => $code]);
        }
        return ConfirmationCode::create(['user_id' => $user->id, 'code' => $code, 'type' => $method]);
    }

    public function verifyCode(User $user, string $code, string $method): bool
    {
        $confirmationCode = ConfirmationCode::where('user_id', $user->id)
            ->where('method', $method)
            ->latest()
            ->first();

        return $confirmationCode && $confirmationCode->code === $code;
    }
}
