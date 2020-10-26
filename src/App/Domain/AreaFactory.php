<?php

namespace MarsDiscovery\App\Domain;

use MarsDiscovery\Core\Vo\Coordinate;

class AreaFactory
{

    public function create(Coordinate $upperRight): Area
    {
        return new Area(
            $lowerLeftCorner = new AreaStartCoordinate(),
            $upperRight
        );
    }

}
