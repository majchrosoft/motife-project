<?php

namespace MarsDiscovery\App\Domain;

use MarsDiscovery\Core\Vo\Coordinate;

class RobotMoveCalculator
{
    private const ROTATE_ORDER_DEFINITION = [
        RobotDirectionTypeList::NORTH,
        RobotDirectionTypeList::EAST,
        RobotDirectionTypeList::SOUTH,
        RobotDirectionTypeList::WEST,
    ];

    private function moveList(): array
    {
        return [
            RobotDirectionTypeList::NORTH => function (Coordinate $coordinate): Coordinate {
                return new Coordinate(
                    $coordinate->x(),
                    $coordinate->y() + 1
                );
            },
            RobotDirectionTypeList::EAST => function (Coordinate $coordinate): Coordinate {
                return new Coordinate(
                    $coordinate->x() + 1,
                    $coordinate->y()
                );
            },
            RobotDirectionTypeList::SOUTH => function (Coordinate $coordinate): Coordinate {
                return new Coordinate(
                    $coordinate->x(),
                    $coordinate->y() - 1
                );
            },
            RobotDirectionTypeList::WEST => function (Coordinate $coordinate): Coordinate {
                return new Coordinate(
                    $coordinate->x() - 1,
                    $coordinate->y()
                );
            },
        ];
    }

    public function list(): array
    {
        return [
            RobotMoveTypeList::ROTATE_LEFT => function (Coordinate $coordinate, RobotDirection $robotDirection): array {
                $rotateOrderIndex = array_search($robotDirection->robotDirection(), self::ROTATE_ORDER_DEFINITION);

                $rotatedLeftIndex = (function ()
                use (
                    $robotDirection,
                    $rotateOrderIndex
                ) {
                    $degraded = $rotateOrderIndex - 1;
                    if ($degraded < 0) {
                        return count(self::ROTATE_ORDER_DEFINITION) - 1;
                    }

                    return $degraded;
                })();

                return [
                    $coordinate,
                    new RobotDirection(self::ROTATE_ORDER_DEFINITION[$rotatedLeftIndex]),
                ];
            },
            RobotMoveTypeList::ROTATE_RIGHT => function (
                Coordinate $coordinate,
                RobotDirection $robotDirection
            ): array {
                $rotateOrderIndex = array_search($robotDirection->robotDirection(), self::ROTATE_ORDER_DEFINITION);

                $rotatedRightIndex = (function ()
                use (
                    $robotDirection,
                    $rotateOrderIndex
                ) {
                    $incrementated = $rotateOrderIndex + 1;
                    if ($incrementated >= count(self::ROTATE_ORDER_DEFINITION)) {
                        return 0;
                    }

                    return $incrementated;
                })();

                return [
                    $coordinate,
                    new RobotDirection(self::ROTATE_ORDER_DEFINITION[$rotatedRightIndex]),
                ];
            },
            RobotMoveTypeList::MOVE => function (Coordinate $coordinate, RobotDirection $robotDirection): array {
                return [
                    $this->moveList()[$robotDirection->robotDirection()]($coordinate),
                    clone $robotDirection,
                ];
            },
        ];
    }

}
