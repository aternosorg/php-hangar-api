<?php

namespace Aternos\HangarApi\Client\List;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Model\Pagination;

/**
 * Class ResultList
 *
 * @package Aternos\HangarApi\Client\List
 * @description A paginated list of results
 */
abstract class ResultList
{
    /**
     * @return Pagination|null
     */
    public abstract function getPagination(): ?Pagination;

    /**
     * @param int $offset
     * @return $this
     * @throws ApiException
     */
    public abstract function getOffset(int $offset): static;

    /**
     * returns true if there is a next page with results on it
     * @return bool
     */
    public function hasNextPage(): bool
    {
        return $this->getPagination()->getCount() > $this->getNextOffset();
    }

    /**
     * get the next page
     * returns null if there is no next page
     * @return static|null
     * @throws ApiException
     */
    public function getNextPage(): ?static
    {
        if (!$this->hasNextPage()) {
            return null;
        }

        return $this->getOffset($this->getNextOffset());
    }

    /**
     * get the offset of the next page
     * @return int
     */
    protected function getNextOffset(): int
    {
        return $this->getPagination()->getOffset() + $this->getPagination()->getLimit();
    }

    /**
     * returns true if there is a previous page with results on it
     * @return bool
     */
    public function hasPreviousPage(): bool
    {
        return $this->getPagination()->getOffset() > 0;
    }

    /**
     * get the offset of the previous page
     * returns 0 if there is no previous page
     * @return int
     */
    protected function getPreviousOffset(): int
    {
        return max(0, $this->getPagination()->getOffset() - $this->getPagination()->getLimit());
    }

    /**
     * get the previous page
     * returns null if there is no previous page
     * @return static|null
     * @throws ApiException
     */
    public function getPreviousPage(): ?static
    {
        if (!$this->hasPreviousPage()) {
            return null;
        }

        return $this->getOffset($this->getPreviousOffset());
    }
}