<?php

namespace Rockbuzz\LaraClient;

final class Token
{
    public static function publicKey(): string
    {
        return strtoupper(str_random(32));
    }

    public static function secretKey(): string
    {
        return str_random(64);
    }
}
