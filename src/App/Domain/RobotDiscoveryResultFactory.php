<?php

namespace MarsDiscovery\App\Domain;

use MarsDiscovery\Core\Vo\Coordinate;

class RobotDiscoveryResultFactory
{
    public function create(
        Coordinate $endCoordinate,
        RobotDirection $endDirection
    ): RobotDiscoveryResult {
        return new RobotDiscoveryResult(
            $endCoordinate,
            $endDirection
        );
    }

}
