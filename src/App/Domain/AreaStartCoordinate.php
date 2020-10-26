<?php

namespace MarsDiscovery\App\Domain;

use MarsDiscovery\Core\Vo\Coordinate;

class AreaStartCoordinate extends Coordinate
{

    public function __construct()
    {
        parent::__construct(0, 0);
    }

}
