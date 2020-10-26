<?php

namespace MarsDiscovery\App\Domain;

use MarsDiscovery\Core\Vo\Coordinate;

class RobotActivityDefinition
{
    /**
     * @var Coordinate
     */
    private $start;

    private $startDirection;

    /**
     * @var array|RobotMove[]
     */
    private $moves;

    public function __construct(
        Coordinate $start,
        RobotDirection $startDirection,
        array $moves
    ) {
        $this->start = $start;
        $this->moves = $moves;
        $this->startDirection = $startDirection;
    }

    /**
     * @return Coordinate
     */
    public function start(): Coordinate
    {
        return $this->start;
    }

    /**
     * @return RobotDirection
     */
    public function startDirection(): RobotDirection
    {
        return $this->startDirection;
    }

    /**
     * @return RobotMove[]|array
     */
    public function moves()
    {
        return $this->moves;
    }

}
