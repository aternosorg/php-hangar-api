<?php

namespace Aternos\HangarApi\Client\List;

use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\Options\UserSearch\UserSearchOptions;
use Aternos\HangarApi\Client\User;
use Aternos\HangarApi\Model\PaginatedResultUser;
use Aternos\HangarApi\Model\Pagination;

/**
 * Class UserList
 *
 * @package Aternos\HangarApi\Client\List
 * @description A paginated list of users
 */
class UserList extends ResultList
{
    /**
     * @var User[]
     */
    protected array $results = [];

    public function __construct(
        protected HangarAPIClient $client,
        protected PaginatedResultUser $result,
        protected ?UserSearchOptions $options,
    )
    {
        $this->results = array_map(function (\Aternos\HangarApi\Model\User $user) {
            return new User($this->client, $user);
        }, $result->getResult());
    }

    /**
     * @return User[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    public function getPagination(): ?Pagination
    {
        return $this->result->getPagination();
    }

    public function getOffset(int $offset): static
    {
        $options = clone $this->options;
        $options->setOffset($offset);
        return $this->client->getUsers($options);
    }
}