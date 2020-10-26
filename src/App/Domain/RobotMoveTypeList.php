<?php

namespace MarsDiscovery\App\Domain;

class RobotMoveTypeList
{
    public const ROTATE_LEFT = 'L';
    public const ROTATE_RIGHT = 'R';
    public const MOVE = 'M';

    public static function list(): array
    {
        return [
            self::ROTATE_LEFT,
            self::ROTATE_RIGHT,
            self::MOVE,
        ];
    }

}
