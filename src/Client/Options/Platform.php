<?php

namespace Aternos\HangarApi\Client\Options;

/**
 * Class Platform
 *
 * @package Aternos\HangarApi\Client\Options
 * @description A platform that's supported by hangar
 */
enum Platform: string
{
    case PAPER = 'PAPER';
    case WATERFALL = 'WATERFALL';
    case VELOCITY = 'VELOCITY';
}