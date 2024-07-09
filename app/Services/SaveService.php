<?php

namespace App\Services;

use App\Models\ConfirmationCode;
use Illuminate\Support\Facades\Auth;

class SaveService
{
    public function save($userId, $method)
    {
        $existingRecord = ConfirmationCode::query()
            ->where('user_id', $userId)
            ->where('type', $method)
            ->first();

        if ($existingRecord) {
            return null;
        } else {
            $data = [
                'user_id' => $userId,
                'type' => $method,
                'code' => rand(11111, 99999),
            ];
            return ConfirmationCode::query()->create($data);
        }
    }
}
