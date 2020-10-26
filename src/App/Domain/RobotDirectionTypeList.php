<?php

namespace MarsDiscovery\App\Domain;

class RobotDirectionTypeList
{
    public const NORTH = 'N';
    public const EAST = 'E';
    public const WEST = 'W';
    public const SOUTH = 'S';

    public static function list(): array
    {
        return [
            self::NORTH,
            self::EAST,
            self::WEST,
            self::SOUTH,
        ];
    }

}
