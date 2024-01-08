<?php

namespace Aternos\HangarApi\Client\Options\ProjectSearch;

use Aternos\HangarApi\Client\Options\Platform;
use Aternos\HangarApi\Client\Options\ProjectCategory;
use Aternos\HangarApi\Model\RequestPagination;

/**
 * Class ProjectSearchOptions
 *
 * @package Aternos\HangarApi\Client\Options\ProjectSearch
 * @description Options for searching projects. All options are optional.
 */
class ProjectSearchOptions
{
    protected RequestPagination $pagination;
    protected bool $prioritizeExactMatch = true;
    protected ?ProjectSortField $sortField = null;
    protected ProjectSortOrder $sortOrder = ProjectSortOrder::ASC;
    protected ?ProjectCategory $category = null;
    protected ?Platform $platform = null;
    protected ?string $owner = null;
    protected ?string $query = null;
    protected ?string $license = null;
    protected ?string $version = null;
    protected ?string $tag = null;

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
     * @return $this
     */
    public function setPagination(RequestPagination $pagination): static
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
     * @return $this
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
     * @return $this
     */
    public function setLimit(int $limit): static
    {
        $this->pagination->setLimit($limit);
        return $this;
    }

    /**
     * @return bool
     */
    public function isPrioritizeExactMatch(): bool
    {
        return $this->prioritizeExactMatch;
    }

    /**
     * @param bool $prioritizeExactMatch
     * @return $this
     */
    public function setPrioritizeExactMatch(bool $prioritizeExactMatch): static
    {
        $this->prioritizeExactMatch = $prioritizeExactMatch;
        return $this;
    }

    /**
     * @return ProjectSortField|null
     */
    public function getSortField(): ?ProjectSortField
    {
        return $this->sortField;
    }

    /**
     * @param ProjectSortField|null $sort
     * @return $this
     */
    public function setSortField(?ProjectSortField $sort): static
    {
        $this->sortField = $sort;
        return $this;
    }

    /**
     * @return ProjectSortOrder
     */
    public function getSortOrder(): ProjectSortOrder
    {
        return $this->sortOrder;
    }

    /**
     * @param ProjectSortOrder $sortOrder
     * @return $this
     */
    public function setSortOrder(ProjectSortOrder $sortOrder): static
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * Get the sort parameter for the API request
     *
     * Returns the sort field value with a minus sign in front if the sort order is descending.
     * If no sort field is set, null is returned.
     * @return string|null
     */
    public function getSortParameter(): ?string
    {
        if ($this->sortField === null) {
            return null;
        }

        if ($this->sortOrder === ProjectSortOrder::DESC) {
            return '-' . $this->sortField->value;
        }

        return $this->sortField->value;
    }

    /**
     * @return ProjectCategory|null
     */
    public function getCategory(): ?ProjectCategory
    {
        return $this->category;
    }

    /**
     * @param ProjectCategory|null $category
     * @return $this
     */
    public function setCategory(?ProjectCategory $category): static
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return Platform|null
     */
    public function getPlatform(): ?Platform
    {
        return $this->platform;
    }

    /**
     * @param Platform|null $platform
     * @return $this
     */
    public function setPlatform(?Platform $platform): static
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOwner(): ?string
    {
        return $this->owner;
    }

    /**
     * @param string|null $owner
     * @return $this
     */
    public function setOwner(?string $owner): static
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQuery(): ?string
    {
        return $this->query;
    }

    /**
     * @param string|null $query
     * @return $this
     */
    public function setQuery(?string $query): static
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLicense(): ?string
    {
        return $this->license;
    }

    /**
     * @param string|null $license
     * @return $this
     */
    public function setLicense(?string $license): static
    {
        $this->license = $license;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * @param string|null $version
     * @return $this
     */
    public function setVersion(?string $version): static
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @param string|null $tag
     * @return $this
     */
    public function setTag(?string $tag): static
    {
        $this->tag = $tag;
        return $this;
    }
}