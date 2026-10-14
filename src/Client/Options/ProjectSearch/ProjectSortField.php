<?php

namespace Aternos\HangarApi\Client\Options\ProjectSearch;

/**
 * Class ProjectSortField
 *
 * @package Aternos\HangarApi\Client\Options\ProjectSearch
 * @description The field to sort the project search results by.
 */
enum ProjectSortField: string
{
    case STARS = 'stars';
    case DOWNLOADS = 'downloads';
    case VIEWS = 'views';
    case NEWEST = 'newest';
    case UPDATED = 'updated';
    case RECENT_VIEWS = 'recent_views';
    case RECENT_DOWNLOADS = 'recent_downloads';
    case SLUG = 'slug';

    /**
     * Get the sort parameter for an API request
     *
     * Returns the sort field value with a minus sign in front if the sort order is descending.
     * @param ProjectSortOrder $sortOrder
     * @return string
     */
    public function getSortParameter(ProjectSortOrder $sortOrder = ProjectSortOrder::ASC): string
    {
        if ($sortOrder === ProjectSortOrder::DESC) {
            return '-' . $this->value;
        }

        return $this->value;
    }
}
