<?php

namespace Aternos\HangarApi\Client;

/**
 * Class JWT
 *
 * @package Aternos\HangarApi\Client
 * @description A Json Web Token used for authentication. This class is used internally and should not be used directly.
 */
class JWT
{
    protected string $token;

    protected int $expiresAt;

    /**
     * @param string $token JWT token
     * @param int $expiresIn time until expiration in seconds
     */
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