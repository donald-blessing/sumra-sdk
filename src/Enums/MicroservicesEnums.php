<?php

namespace Sumra\SDK\Enums;

final class MicroservicesEnums
{
    const REFERRALS_MS = 1;
    const GLOBAL_IDENTITY_CENTER = 2;

    public static function checkMicroservice(string $microservice): bool
    {
        return in_array($microservice, [
            self::REFERRALS_MS,
            self::GLOBAL_IDENTITY_CENTER
        ]);
    }

}