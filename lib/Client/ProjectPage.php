<?php

namespace Aternos\HangarApi\Client;

use Aternos\HangarApi\ApiException;

class ProjectPage
{
    protected ?Project $project = null;

    public function __construct(
        protected HangarAPIClient $client,
        protected string $owner,
        protected string $slug,
        protected string $content,
        protected string $path = "",
    )
    {
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return Project
     * @throws ApiException
     */
    public function getProject(): Project
    {
        return $this->project ??= $this->client->getProject($this->owner, $this->slug);
    }

    /**
     * @param Project|null $project
     * @return ProjectPage
     */
    public function setProject(?Project $project): ProjectPage
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}