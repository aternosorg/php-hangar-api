<?php

namespace Aternos\HangarApi\Client\Options;

enum ProjectCategory: string
{
    case ADMIN_TOOLS = 'admin_tools';
    case CHAT = 'chat';
    case DEV_TOOLS = 'dev_tools';
    case ECONOMY = 'economy';
    case GAMEPLAY = 'gameplay';
    case GAMES = 'games';
    case PROTECTION = 'protection';
    case ROLE_PLAYING = 'role_playing';
    case WORLD_MANAGEMENT = 'world_management';
    case MISC = 'misc';
    case UNDEFINED = 'undefined';
}