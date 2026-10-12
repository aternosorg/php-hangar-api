<?php

namespace Aternos\HangarApi\Client\Options\UserSearch;

/**
 * Class UserSearchOptions
 *
 * @package Aternos\HangarApi\Client\Options\UserSearch
 * @description Options for searching users. All options are optional.
 */
class UserSearchOptions
{
    protected int $offset = 0;

    protected int $limit = 25;

    protected string $query = '';

    protected ?UserSortField $sort = null;

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return static
     */
    public function setOffset(int $offset): static
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return static
     */
    public function setLimit(int $limit): static
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     * @return UserSearchOptions
     */
    public function setQuery(string $query): UserSearchOptions
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return UserSortField|null
     */
    public function getSort(): ?UserSortField
    {
        return $this->sort;
    }

    /**
     * @param UserSortField|null $sort
     * @return UserSearchOptions
     */
    public function setSort(?UserSortField $sort): UserSearchOptions
    {
        $this->sort = $sort;
        return $this;
    }
}