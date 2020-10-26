<?php

namespace MarsDiscovery\App\Domain;

use MarsDiscovery\App\Domain\Exception\InvalidRobotMoveTypeException;

class RobotMove
{
    /**
     * @var string
     */
    private $move;

    public function __construct(string $move)
    {
        $this->assertIsRobotMove($move);
        $this->move = $move;
    }

    private function assertIsRobotMove(string $move): void
    {
        if (!in_array($move, RobotMoveTypeList::list())) {
            throw new InvalidRobotMoveTypeException('InvalidRobotMoveType');
        }
    }

    /**
     * @return string
     */
    public function move(): string
    {
        return $this->move;
    }

}
