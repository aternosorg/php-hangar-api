<?php

namespace Aternos\HangarApi\Client;

class JWT
{
    protected string $token;

    protected int $expiresAt;

    public function __construct(string $token, int $expiresIn)
    {
        $this->token = $token;
        $this->expiresAt = time() + $expiresIn;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function isValid(): bool
    {
        return $this->expiresAt > time();
    }
}