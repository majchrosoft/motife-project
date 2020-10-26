<?php

namespace MarsDiscovery\App\Command;

use MarsDiscovery\App\Domain\Area;
use MarsDiscovery\App\Domain\CoordinateIsInAreaAssertion;
use MarsDiscovery\App\Domain\MarsDiscoveryPlan;
use MarsDiscovery\App\Domain\MarsDiscoveryRepository;
use MarsDiscovery\App\Domain\MarsDiscoveryResult;
use MarsDiscovery\App\Domain\MarsDiscoveryResultFactory;
use MarsDiscovery\App\Domain\MarsDiscoveryResultRepository;
use MarsDiscovery\App\Domain\RobotActivityDefinition;
use MarsDiscovery\App\Domain\RobotDirection;
use MarsDiscovery\App\Domain\RobotDiscoveryResult;
use MarsDiscovery\App\Domain\RobotDiscoveryResultFactory;
use MarsDiscovery\App\Domain\RobotMove;
use MarsDiscovery\App\Domain\RobotMoveCalculator;
use MarsDiscovery\Core\Vo\Coordinate;

class MakeExpeditionToMarsCommandHandler
{
    /**
     * @var MarsDiscoveryRepository
     */
    private $marsDiscoveryRepository;
    /**
     * @var MarsDiscoveryResultRepository
     */
    private $marsDiscoveryResultRepository;
    /**
     * @var RobotMoveCalculator
     */
    private $robotMoveCalculator;
    /**
     * @var CoordinateIsInAreaAssertion
     */
    private $coordinateIsInAreaAssertion;
    /**
     * @var MarsDiscoveryResultFactory
     */
    private $marsDiscoveryResultFactory;
    /**
     * @var RobotDiscoveryResultFactory
     */
    private $robotDiscoveryResultFactory;

    public function __construct(
        MarsDiscoveryRepository $marsDiscoveryRepository,
        MarsDiscoveryResultRepository $marsDiscoveryResultRepository,
        RobotMoveCalculator $robotMoveCalculator,
        CoordinateIsInAreaAssertion $coordinateIsInAreaAssertion,
        MarsDiscoveryResultFactory $marsDiscoveryResultFactory,
        RobotDiscoveryResultFactory $robotDiscoveryResultFactory
    ) {
        $this->marsDiscoveryRepository = $marsDiscoveryRepository;
        $this->marsDiscoveryResultRepository = $marsDiscoveryResultRepository;
        $this->robotMoveCalculator = $robotMoveCalculator;
        $this->coordinateIsInAreaAssertion = $coordinateIsInAreaAssertion;
        $this->marsDiscoveryResultFactory = $marsDiscoveryResultFactory;
        $this->robotDiscoveryResultFactory = $robotDiscoveryResultFactory;
    }

    public function handle(MakeExpeditionToMarsCommand $command): void
    {
        /** @var MarsDiscoveryPlan $marsDiscovery */
        $marsDiscovery = $this->marsDiscoveryRepository->ofId($command->marsDiscoveryId());


        $marsDiscoveryResult = $this->marsDiscoveryResultFactory->create(
            $marsDiscovery->id(),
            array_map(
                function (RobotActivityDefinition $robotActivityDefinition)
                use (
                    $marsDiscovery
                ) {
                    $calculateCoordinatesAndDirection = $this->trip(
                        $area = $marsDiscovery->area(),
                        $robotActivityDefinition
                    );

                    return $this->robotDiscoveryResultFactory->create(
                        $calculateCoordinatesAndDirection[0],
                        $calculateCoordinatesAndDirection[1]
                    );
                },
                $marsDiscovery->robotActivity()
            )
        );

        $this->marsDiscoveryResultRepository->add($marsDiscoveryResult);
    }

    /**
     * @param Area                    $area
     * @param RobotActivityDefinition $robotActivityDefinition
     *
     * @return Coordinate
     */
    private function trip(
        Area $area,
        RobotActivityDefinition $robotActivityDefinition
    ): array {
        return array_reduce(
            $robotActivityDefinition->moves(),
            function (array $coordinateAndDirection, RobotMove $robotMove)
            use (
                $area
            ): array {
                /** @var Coordinate $coords */
                $coords = clone $coordinateAndDirection[0];
                /** @var RobotDirection $robotDirection */
                $robotDirection = clone $coordinateAndDirection[1];

                $coordinateAndDirectionReturned = $this->robotMoveCalculator->list()[$robotMove->move()](
                    $coords,
                    $robotDirection
                );

                $this->assertCoordinateIsInArea($coordinateAndDirectionReturned[0], $area);
                return $coordinateAndDirectionReturned;
            },
            [clone $robotActivityDefinition->start(), clone $robotActivityDefinition->startDirection()]
        );
    }

    private function assertCoordinateIsInArea(Coordinate $coordinate, Area $area)
    {
        $this->coordinateIsInAreaAssertion->assert($coordinate, $area);
    }

}
