<?php

namespace Aternos\HangarApi\Client\Options\UserSearch;

/**
 * Class UserSortField
 *
 * @package Aternos\HangarApi\Client\Options\UserSearch
 * @description The field to sort the user search results by.
 */
enum UserSortField: string
{
    case NAME = 'name';
    case CREATED_AT = 'createdAt';
    case PROJECT_COUNT = 'projectCount';
    case LOCKED = 'locked';
    case ORG = 'org';
    case ROLES = 'roles';
}