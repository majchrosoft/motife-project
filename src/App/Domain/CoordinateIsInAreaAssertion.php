<?php

namespace MarsDiscovery\App\Domain;

use MarsDiscovery\Core\Vo\Coordinate;

class CoordinateIsInAreaAssertion
{
    public function assert(Coordinate $coordinate, Area $area): void
    {
        $isInArea =
            $coordinate->x() >= $area->lowerLeftCorner()->x()
            && $coordinate->x() <= $area->upperRightCorner()->x()
            && $coordinate->y() >= $area->lowerLeftCorner()->y()
            && $coordinate->y() <= $area->upperRightCorner()->y();

        if (!$isInArea) {
            throw new \MarsDiscovery\App\Command\Exception\RobotCoordinateOutsideAreaBoundMakeExpeditionToMarsCommandHandlerException(
                'RobotCoordinateOutsideAreaBound'
            );
        }
    }

}
