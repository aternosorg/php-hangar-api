<?php

namespace Aternos\HangarApi\Client\Options\UserSearch;

use Aternos\HangarApi\Model\RequestPagination;

/**
 * Class UserSearchOptions
 *
 * @package Aternos\HangarApi\Client\Options\UserSearch
 * @description Options for searching users. All options are optional.
 */
class UserSearchOptions
{
    protected RequestPagination $pagination;

    protected string $query = '';

    protected ?UserSortField $sort = null;

    public function __construct()
    {
        $this->pagination = (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);
    }

    /**
     * @return RequestPagination
     */
    public function getPagination(): RequestPagination
    {
        return $this->pagination;
    }

    /**
     * @param RequestPagination $pagination
     * @return UserSearchOptions
     */
    public function setPagination(RequestPagination $pagination): UserSearchOptions
    {
        $this->pagination = $pagination;
        return $this;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->pagination->getOffset();
    }

    /**
     * @param int $offset
     * @return static
     */
    public function setOffset(int $offset): static
    {
        $this->pagination->setOffset($offset);
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->pagination->getLimit();
    }

    /**
     * @param int $limit
     * @return static
     */
    public function setLimit(int $limit): static
    {
        $this->pagination->setLimit($limit);
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