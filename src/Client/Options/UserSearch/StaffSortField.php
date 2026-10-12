<?php

namespace Aternos\HangarApi\Client\Options\UserSearch;

/**
 * Class StaffSortField
 *
 * @package Aternos\HangarApi\Client\Options\UserSearch
 * @description The field to sort the staff search results by.
 */
enum StaffSortField: string
{
    case NAME = 'name';
    case CREATED_AT = 'createdAt';
    case ROLES = 'roles';
}
