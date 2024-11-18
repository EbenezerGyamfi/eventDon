<?php

namespace App\Support\Ussd;

use App\Models\Event;

interface UssdSessionContract
{
    public function handleUssdSession(array $requestBody): array;

    public function handleNewUssdSession(array $requestBody): array;

    public function handleSubsequentUssdSessions(array $requestBody): array;

    public function eventCodeExists(string $eventCode): ?Event;
}
