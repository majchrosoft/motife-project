<?php

namespace MarsDiscovery\App\Domain;

use MarsDiscovery\App\Domain\Exception\InvalidRobotDirectionTypeException;

class RobotDirection
{
    /**
     * @var string
     */
    private $robotDirection;

    public function __construct(string $robotDirection)
    {
        $this->assertIsRobotDirection($robotDirection);

        $this->robotDirection = $robotDirection;
    }

    private function assertIsRobotDirection(string $robotDirection): void
    {
        if (!in_array($robotDirection, RobotDirectionTypeList::list())) {
            throw new InvalidRobotDirectionTypeException('InvalidRobotDirectionType');
        }
    }

    /**
     * @return string
     */
    public function robotDirection(): string
    {
        return $this->robotDirection;
    }

}
