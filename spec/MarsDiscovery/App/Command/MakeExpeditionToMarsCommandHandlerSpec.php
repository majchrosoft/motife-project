<?php

namespace spec\MarsDiscovery\App\Command;

use MarsDiscovery\App\Command\MakeExpeditionToMarsCommand;
use MarsDiscovery\App\Command\MakeExpeditionToMarsCommandHandler;
use MarsDiscovery\App\Domain\Area;
use MarsDiscovery\App\Domain\CoordinateIsInAreaAssertion;
use MarsDiscovery\App\Domain\MarsDiscoveryPlan;
use MarsDiscovery\App\Domain\MarsDiscoveryRepository;
use MarsDiscovery\App\Domain\MarsDiscoveryResultFactory;
use MarsDiscovery\App\Domain\MarsDiscoveryResultRepository;
use MarsDiscovery\App\Domain\RobotActivityDefinition;
use MarsDiscovery\App\Domain\RobotDirection;
use MarsDiscovery\App\Domain\RobotDiscoveryResult;
use MarsDiscovery\App\Domain\RobotDiscoveryResultFactory;
use MarsDiscovery\App\Domain\RobotMove;
use MarsDiscovery\App\Domain\RobotMoveCalculator;
use MarsDiscovery\App\Domain\RobotMoveTypeList;
use MarsDiscovery\Core\Vo\Coordinate;
use PhpSpec\ObjectBehavior;

class MakeExpeditionToMarsCommandHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MakeExpeditionToMarsCommandHandler::class);
    }

    public function let(
        MarsDiscoveryRepository $marsDiscoveryRepository,
        MarsDiscoveryResultRepository $marsDiscoveryResultRepository,
        RobotMoveCalculator $robotMoveCalculator,
        CoordinateIsInAreaAssertion $coordinateIsInAreaAssertion,
        MarsDiscoveryResultFactory $marsDiscoveryResultFactory,
        RobotDiscoveryResultFactory $robotDiscoveryResultFactory
    ) {
        $this->beConstructedWith(
            $marsDiscoveryRepository,
            $marsDiscoveryResultRepository,
            $robotMoveCalculator,
            $coordinateIsInAreaAssertion,
            $marsDiscoveryResultFactory,
            $robotDiscoveryResultFactory
        );
    }

    public function it_should_make_an_expedition_and_store_results(
        MarsDiscoveryRepository $marsDiscoveryRepository,
        MarsDiscoveryResultRepository $marsDiscoveryResultRepository,
        RobotMoveCalculator $robotMoveCalculator,
        CoordinateIsInAreaAssertion $coordinateIsInAreaAssertion,
        MarsDiscoveryResultFactory $marsDiscoveryResultFactory,
        RobotDiscoveryResultFactory $robotDiscoveryResultFactory,
        MakeExpeditionToMarsCommand $command,
        MarsDiscoveryPlan $marsDiscovery,
        RobotActivityDefinition $robotActivityDefinition,
        RobotMove $robotMove,
        Coordinate $coordinateFromCalc,
        RobotDirection $robotDirectionFromCalc,
        RobotDiscoveryResult $robotDiscoveryResult,
        Coordinate $robotStartCoordinates,
        RobotDirection $robotStartDirection,
        Area $area
    ): void {
        $marsDiscoveryId = 1;
        $robotMoveString = RobotMoveTypeList::MOVE;
        $command->marsDiscoveryId()->willReturn($marsDiscoveryId);

        $robotMove
            ->move()
            ->shouldBeCalledOnce()
            ->willReturn($robotMoveString);
        $robotMoves = [$robotMove];

        $robotActivityDefinition
            ->startDirection()
            ->shouldBeCalledOnce()
            ->willReturn($robotStartDirection);

        $robotActivityDefinition
            ->start()
            ->shouldBeCalledOnce()
            ->willReturn($robotStartCoordinates);

        $robotActivityDefinition
            ->moves()
            ->shouldBeCalledOnce()
            ->willReturn($robotMoves);

        $robotActivityDefinitionList = [
            $robotActivityDefinition,
        ];

        $marsDiscovery
            ->id()
            ->shouldBeCalledOnce()
            ->willReturn($marsDiscoveryId);

        $marsDiscovery
            ->robotActivity()
            ->shouldBeCalledOnce()
            ->willReturn($robotActivityDefinitionList);

        $marsDiscoveryRepository
            ->ofId($marsDiscoveryId)
            ->shouldBeCalledOnce()
            ->willReturn($marsDiscovery);

        $mockedCalculator = [
            $robotMoveString => function ()
            use (
                $coordinateFromCalc,
                $robotDirectionFromCalc
            ) {
                return [
                    $coordinateFromCalc->getWrappedObject(),
                    $robotDirectionFromCalc->getWrappedObject(),
                ];
            },
        ];

        $robotMoveCalculator
            ->list()
            ->shouldBeCalledOnce()
            ->willReturn($mockedCalculator);

        $marsDiscovery
            ->area()
            ->shouldBeCalledOnce()
            ->willReturn($area);

        $coordinateIsInAreaAssertion
            ->assert($coordinateFromCalc, $area)
            ->shouldBeCalledOnce();

        $robotDiscoveryResultFactory
            ->create(
                $coordinateFromCalc,
                $robotDirectionFromCalc
            )
            ->shouldBeCalledOnce()
            ->willReturn($robotDiscoveryResult);

        $marsDiscoveryResultFactory
            ->create(
                $marsDiscoveryId,
                $robotDiscoveryResultList
                    = [
                    $robotDiscoveryResult,
                ]
            )
            ->shouldBeCalledOnce();

        $this->beConstructedWith(
            $marsDiscoveryRepository,
            $marsDiscoveryResultRepository,
            $robotMoveCalculator,
            $coordinateIsInAreaAssertion,
            $marsDiscoveryResultFactory,
            $robotDiscoveryResultFactory
        );

        $this->handle($command);
    }

}
