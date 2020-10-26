<?php

namespace MarsDiscovery\App\Domain;

use MarsDiscovery\Core\Vo\Coordinate;

class RobotDiscoveryResult
{
    /**
     * @var Coordinate
     */
    private $endCoordinate;
    /**
     * @var RobotDirection
     */
    private $endDirection;

    public function __construct(
        Coordinate $endCoordinate,
        RobotDirection $endDirection
    ) {
        $this->endCoordinate = $endCoordinate;
        $this->endDirection = $endDirection;
    }

    /**
     * @return Coordinate
     */
    public function endCoordinate(): Coordinate
    {
        return $this->endCoordinate;
    }

    /**
     * @return RobotDirection
     */
    public function endDirection(): RobotDirection
    {
        return $this->endDirection;
    }

}
