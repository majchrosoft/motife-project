<?php

use MarsDiscovery\App\Domain\MarsDiscoveryRepository;
use MarsDiscovery\App\Domain\RobotDiscoveryResult;

ini_set("display_errors", 1);
error_reporting(E_ALL);

// Include autoloading file
require "vendor/autoload.php";

$builder = new \DI\ContainerBuilder();

$builder->addDefinitions(
    [
        \MarsDiscovery\App\Domain\MarsDiscoveryRepository::class => new \MarsDiscovery\App\Infrastructure\InMemory\InMemoryMarsDiscoveryRepository(
        ),
        \MarsDiscovery\App\Domain\MarsDiscoveryResultRepository::class => new \MarsDiscovery\App\Infrastructure\InMemory\InMemoryMarsDiscoveryResultRepository(
        ),
    ]
);
$container = $builder->build();

$storeMarsDiscoveryCommandHandler = $container->get(\MarsDiscovery\App\Command\StoreMarsDiscoveryCommandHandler::class);
$makeTripHandler = $container->get(\MarsDiscovery\App\Command\MakeExpeditionToMarsCommandHandler::class);
$tripHandlerRepository = $container->get(\MarsDiscovery\App\Domain\MarsDiscoveryResultRepository::class);

/** @var \MarsDiscovery\Core\Infrastructure\Scanner $scanner */
$scanner = $container->get(\MarsDiscovery\Core\Infrastructure\Scanner::class);
$rightUpperCoordinatesString = $scanner->readline();

$rightUpperCoordinates = array_map(
    function (string $val) {
        return (int)$val;
    },
    explode(" ", $rightUpperCoordinatesString)
);

$robots = [];

for ($i = 1; '' != ($line = $scanner->readline()); $i++) {
    if ($i % 2) {
        $robots[$i % 2][] = explode(" ", $line);
    } else {
        $robots[$i % 2][] = $line;
    }
}

$iki = 0;
$robotStartCoordinatesAndDirectionAndMovementList =
    array_map(
        function ($moves)
        use (
            $robots,
            &$iki
        ) {
            $arr = array_merge($robots[1][$iki], [$moves]);
            $iki++;
            return $arr;
        },
        $robots[0]
    );

$storeMarsDiscoveryCommandHandler->handle(
    new \MarsDiscovery\App\Command\StoreMarsDiscoveryCommand(
        $id = 1,
        $areaRightUpperCornerX = $rightUpperCoordinates[0],
        $areaRightUpperCornerY = $rightUpperCoordinates[1],
        $robotStartCoordinatesAndDirectionAndMovementList
    )
);

$makeExpeditionToMarsCommand = new \MarsDiscovery\App\Command\MakeExpeditionToMarsCommand(
    $id
);

$makeTripHandler->handle($makeExpeditionToMarsCommand);

$tripHandlerRepository = $container->get(\MarsDiscovery\App\Domain\MarsDiscoveryResultRepository::class);
$tripHandlerResult = $tripHandlerRepository->ofMarsDiscoveryId($id);

echo implode(
    "\r\n",
    array_map(
        function (RobotDiscoveryResult $robotEndup) {
            return $robotEndup->endCoordinate()->x() . ' ' . $robotEndup->endCoordinate()->y(
                ) . ' ' . $robotEndup->endDirection()->robotDirection();
        },
        $tripHandlerResult->robotDiscoveryResultList()
    )
);
