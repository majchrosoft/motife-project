<?php

namespace MarsDiscovery\App\Command;

use MarsDiscovery\App\Command\Exception\MarsDiscoveryWithGivenIdAlreadyExistStoreMarsDiscoveryCommandHandler;
use MarsDiscovery\App\Domain\Area;
use MarsDiscovery\App\Domain\AreaFactory;
use MarsDiscovery\App\Domain\CoordinateIsInAreaAssertion;
use MarsDiscovery\App\Domain\Exception\MarsDiscoveryNotFoundMarsDiscoveryRepositoryException;
use MarsDiscovery\App\Domain\MarsDiscoveryPlan;
use MarsDiscovery\App\Domain\MarsDiscoveryRepository;
use MarsDiscovery\App\Domain\RobotActivityDefinition;
use MarsDiscovery\App\Domain\RobotDirection;
use MarsDiscovery\App\Domain\RobotMove;
use MarsDiscovery\Core\Vo\Coordinate;

class StoreMarsDiscoveryCommandHandler
{
    /**
     * @var MarsDiscoveryRepository
     */
    private $marsDiscoveryRepository;
    /**
     * @var AreaFactory
     */
    private $areaFactory;
    /**
     * @var CoordinateIsInAreaAssertion
     */
    private $coordinateIsInAreaAssertion;

    public function __construct(
        MarsDiscoveryRepository $marsDiscoveryRepository,
        AreaFactory $areaFactory,
        CoordinateIsInAreaAssertion $coordinateIsInAreaAssertion
    ) {
        $this->marsDiscoveryRepository = $marsDiscoveryRepository;
        $this->areaFactory = $areaFactory;
        $this->coordinateIsInAreaAssertion = $coordinateIsInAreaAssertion;
    }

    public function handle(StoreMarsDiscoveryCommand $command): void
    {
        $id = $command->marsDiscoveryId();
        $this->assertNotExist($id);

        $marsDiscovery = new MarsDiscoveryPlan(
            $id,
            $area = $this->areaFactory->create(
                new Coordinate(
                    $command->areaRightUpperCornerX(),
                    $command->areaRightUpperCornerY()
                )
            ),
            array_map(
                function (array $robotStartCoordinatesAndDirection) use ($area): RobotActivityDefinition {
                    $start = new Coordinate(
                        $robotStartCoordinatesAndDirection[0],
                        $robotStartCoordinatesAndDirection[1]
                    );

                    $this->assertCoordinateIsInArea($start, $area);

                    return new RobotActivityDefinition(
                        $start,
                        $startDirection = new RobotDirection($robotStartCoordinatesAndDirection[2]),
                        $moves = array_map(
                            function (string $move): RobotMove {
                                return new RobotMove(
                                    $move
                                );
                            },
                            str_split($robotStartCoordinatesAndDirection[3])
                        )
                    );
                },
                $command->robotStartCoordinatesAndDirectionList()
            )
        );

        $this->marsDiscoveryRepository->add($marsDiscovery);
    }

    private function assertNotExist(int $id): void
    {
        try {
            $this->marsDiscoveryRepository->ofId($id);
            throw new MarsDiscoveryWithGivenIdAlreadyExistStoreMarsDiscoveryCommandHandler(
                'MarsDiscoveryWithGivenIdAlreadyExist'
            );
        } catch (MarsDiscoveryNotFoundMarsDiscoveryRepositoryException $e) {
        }
    }

    private function assertCoordinateIsInArea(Coordinate $coordinate, Area $area)
    {
        $this->coordinateIsInAreaAssertion->assert($coordinate, $area);
    }

}
