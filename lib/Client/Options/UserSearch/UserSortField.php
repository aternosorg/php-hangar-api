<?php

namespace Aternos\HangarApi\Client\Options\UserSearch;

enum UserSortField: string
{
    case NAME = 'name';
    case CREATED_AT = 'createdAt';
    case PROJECT_COUNT = 'projectCount';
    case LOCKED = 'locked';
    case ORG = 'org';
    case ROLES = 'roles';
}