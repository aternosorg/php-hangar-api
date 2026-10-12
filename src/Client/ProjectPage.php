<?php

namespace Aternos\HangarApi\Client;

use Aternos\HangarApi\ApiException;

class ProjectPage
{
    protected ?Project $project = null;

    public function __construct(
        protected HangarAPIClient $client,
        protected string          $projectSlugOrId,
        protected string          $content,
        protected string          $path = "",
    )
    {
    }

    /**
     * Get the page content (markdown)
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the page content (markdown)
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get the project this page belongs to
     * This method will make an API request if the project is not set
     * @return Project
     * @throws ApiException
     */
    public function getProject(): Project
    {
        return $this->project ??= $this->client->getProject($this->projectSlugOrId);
    }

    /**
     * Get the project id or slug
     * This method will return the project id if the project is set, otherwise the slug or id passed to the constructor
     * @return string|int
     */
    public function getProjectIdOrSlug(): string|int
    {
        return $this->project?->getId() ?? $this->projectSlugOrId;
    }

    /**
     * Set the project this page belongs to
     * @param Project|null $project
     * @return $this
     */
    public function setProject(?Project $project): static
    {
        $this->project = $project;
        return $this;
    }

    /**
     * Get the path to this page
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Set the path to this page
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): static
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Save the page content
     * @return $this
     * @throws ApiException
     */
    public function save(): static
    {
        $this->client->editProjectPage($this->getProjectIdOrSlug(), $this->path, $this->content);
        return $this;
    }
}
