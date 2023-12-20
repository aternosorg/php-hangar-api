<?php

namespace Aternos\HangarApi\Client\Options\VersionSearch;

use Aternos\HangarApi\Client\Options\Platform;
use Aternos\HangarApi\Client\Project;
use Aternos\HangarApi\Model\RequestPagination;

/**
 * Class VersionSearchOptions
 *
 * @package Aternos\HangarApi\Client\Options\VersionSearch
 * @description Options for searching versions. Only the namespace is required.
 */
class VersionSearchOptions
{
    protected string $projectSlug;

    protected ?Project $project = null;

    protected RequestPagination $pagination;

    protected ?string $channel = null;

    protected ?Platform $platform = null;

    protected ?string $platformVersion = null;

    public function __construct(string $projectSlug)
    {
        $this->pagination = (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);
        $this->projectSlug = $projectSlug;
    }

    /**
     * @return string
     */
    public function getProjectSlug(): string
    {
        return $this->projectSlug;
    }

    /**
     * @param string $projectSlug
     * @return VersionSearchOptions
     */
    public function setProjectSlug(string $projectSlug): VersionSearchOptions
    {
        $this->projectSlug = $projectSlug;
        return $this;
    }

    /**
     * @return Project|null
     */
    public function getProject(): ?Project
    {
        return $this->project;
    }

    /**
     * @param Project|null $project
     * @return VersionSearchOptions
     */
    public function setProject(?Project $project): VersionSearchOptions
    {
        $this->project = $project;
        $this->setProjectSlug($project->getSlug());
        return $this;
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
     * @return VersionSearchOptions
     */
    public function setPagination(RequestPagination $pagination): VersionSearchOptions
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
     * @return string|null
     */
    public function getChannel(): ?string
    {
        return $this->channel;
    }

    /**
     * @param string|null $channel
     * @return VersionSearchOptions
     */
    public function setChannel(?string $channel): VersionSearchOptions
    {
        $this->channel = $channel;
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
     * @return VersionSearchOptions
     */
    public function setPlatform(?Platform $platform): VersionSearchOptions
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlatformVersion(): ?string
    {
        return $this->platformVersion;
    }

    /**
     * @param string|null $platformVersion
     * @return VersionSearchOptions
     */
    public function setPlatformVersion(?string $platformVersion): VersionSearchOptions
    {
        $this->platformVersion = $platformVersion;
        return $this;
    }
}