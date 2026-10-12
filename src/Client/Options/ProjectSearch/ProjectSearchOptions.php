<?php

namespace Aternos\HangarApi\Client\Options\ProjectSearch;

use Aternos\HangarApi\Model\Category;
use Aternos\HangarApi\Model\Platform;
use Aternos\HangarApi\Model\Tag;

/**
 * Class ProjectSearchOptions
 *
 * @package Aternos\HangarApi\Client\Options\ProjectSearch
 * @description Options for searching projects. All options are optional.
 */
class ProjectSearchOptions
{
    protected int $offset = 0;
    protected int $limit = 25;
    protected bool $prioritizeExactMatch = true;
    protected ?ProjectSortField $sortField = null;
    protected ProjectSortOrder $sortOrder = ProjectSortOrder::ASC;
    protected ?Category $category = null;
    protected ?Platform $platform = null;
    protected ?string $owner = null;
    protected ?string $query = null;
    protected ?string $license = null;
    protected ?string $version = null;
    protected ?Tag $tag = null;

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return $this
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
     * @return $this
     */
    public function setLimit(int $limit): static
    {
        $this->limit = $limit;
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
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return $this
     */
    public function setCategory(?Category $category): static
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
     * @return string|null name of the project owner (user or organization), not the id
     */
    public function getOwner(): ?string
    {
        return $this->owner;
    }

    /**
     * Only return projects owned by this user or organization
     * @param string|null $owner name of the project owner, not the id
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
     * @return Tag|null
     */
    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    /**
     * @param Tag|null $tag
     * @return $this
     */
    public function setTag(?Tag $tag): static
    {
        $this->tag = $tag;
        return $this;
    }
}