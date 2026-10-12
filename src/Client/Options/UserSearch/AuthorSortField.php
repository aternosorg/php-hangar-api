<?php

namespace Aternos\HangarApi\Client\Options\UserSearch;

/**
 * Class AuthorSortField
 *
 * @package Aternos\HangarApi\Client\Options\UserSearch
 * @description The field to sort the author search results by.
 */
enum AuthorSortField: string
{
    case NAME = 'name';
    case CREATED_AT = 'createdAt';
    case PROJECT_COUNT = 'projectCount';
}
