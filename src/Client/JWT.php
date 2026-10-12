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

    /**
     * @var int expiration time as unix timestamp in seconds
     */
    protected int $expiresAt;

    /**
     * @param string $token JWT token
     * @param int $expiresIn time until expiration in milliseconds
     */
    public function __construct(string $token, int $expiresIn)
    {
        $expiresInSeconds = (int) ($expiresIn / 1000);

        $this->token = $token;
        $this->expiresAt = time() + $expiresInSeconds;
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
