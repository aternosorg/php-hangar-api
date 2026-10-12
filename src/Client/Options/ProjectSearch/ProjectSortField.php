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
    case ONLY_RELEVANCE = 'only_relevance';
    case RECENT_VIEWS = 'recent_views';
    case RECENT_DOWNLOADS = 'recent_downloads';
}
