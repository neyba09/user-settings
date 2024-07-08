<?php

namespace App\Services;

use App\Models\User;
use Twilio\Rest\Client;
use App\Models\ConfirmationCode;

class SmsServiceInterface implements ConfirmationServiceInterface
{
    public function sendCode(User $user, string $method)
    {
        $code = rand(11111, 99999);

        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        $twilio->messages->create($user->phone_number, [
            'from' => env('TWILIO_FROM'),
            'body' => "Ваш код подтверждения: {$code}"
        ]);
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
