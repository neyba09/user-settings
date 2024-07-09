<?php

namespace App\Repositories;

use App\Models\ConfirmationCode;

class ConfirmationCodeRepository
{
    public function create(array $data)
    {
        return ConfirmationCode::create($data);
    }
}
