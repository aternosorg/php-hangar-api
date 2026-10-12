<?php

namespace Aternos\HangarApi\Client\Options;

enum Tag: string
{
    case ADDON = 'ADDON';
    case LIBRARY = 'LIBRARY';
    case SUPPORTS_FOLIA = 'SUPPORTS_FOLIA';
}