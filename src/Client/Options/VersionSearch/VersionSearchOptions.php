<?php

namespace Aternos\HangarApi\Client\Options\VersionSearch;

use Aternos\HangarApi\Client\Project;
use Aternos\HangarApi\Model\Platform;

/**
 * Class VersionSearchOptions
 *
 * @package Aternos\HangarApi\Client\Options\VersionSearch
 * @description Options for searching versions. Only the namespace is required.
 */
class VersionSearchOptions
{
    protected string $projectSlugOrId;

    protected ?Project $project = null;

    protected int $offset = 0;

    protected int $limit = 25;

    protected ?string $channel = null;

    protected ?Platform $platform = null;

    protected bool $includeHiddenChannels = true;

    public function __construct(string $projectSlugOrId)
    {
        $this->projectSlugOrId = $projectSlugOrId;
    }

    /**
     * @return string
     */
    public function getProjectSlugOrId(): string
    {
        return $this->projectSlugOrId;
    }

    /**
     * @param string $projectSlugOrId
     * @return $this
     */
    public function setProjectSlugOrId(string $projectSlugOrId): static
    {
        $this->projectSlugOrId = $projectSlugOrId;
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
     * @param Project $project
     * @return $this
     */
    public function setProject(Project $project): static
    {
        $this->project = $project;
        $this->setProjectSlugOrId($project->getId());
        return $this;
    }

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
     * @return string|null
     */
    public function getChannel(): ?string
    {
        return $this->channel;
    }

    /**
     * @param string|null $channel
     * @return $this
     */
    public function setChannel(?string $channel): static
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
     * @return $this
     */
    public function setPlatform(?Platform $platform): static
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIncludeHiddenChannels(): bool
    {
        return $this->includeHiddenChannels;
    }

    /**
     * @param bool $includeHiddenChannels
     * @return $this
     */
    public function setIncludeHiddenChannels(bool $includeHiddenChannels): static
    {
        $this->includeHiddenChannels = $includeHiddenChannels;
        return $this;
    }
}
