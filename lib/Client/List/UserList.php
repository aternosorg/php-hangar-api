<?php

namespace Aternos\HangarApi\Client\List;

use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\Options\UserSearch\UserSearchOptions;
use Aternos\HangarApi\Client\User;
use Aternos\HangarApi\Model\PaginatedResultUser;
use Aternos\HangarApi\Model\User as UserModel;

/**
 * Class UserList
 *
 * @package Aternos\HangarApi\Client\List
 * @description A paginated list of users
 * @extends ResultList<User>
 */
class UserList extends ResultList
{
    public function __construct(
        protected HangarAPIClient $client,
        PaginatedResultUser $result,
        protected ?UserSearchOptions $options,
    )
    {
        parent::__construct($result->getPagination(), array_map(function (UserModel $user) {
            return new User($this->client, $user);
        }, $result->getResult()));
    }

    public function getOffset(int $offset): static
    {
        $options = clone $this->options;
        $options->setOffset($offset);
        return $this->client->getUsers($options);
    }
}