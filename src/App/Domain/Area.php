<?php

namespace MarsDiscovery\App\Domain;

use MarsDiscovery\Core\Vo\Coordinate;

class Area
{
    /**
     * @var Coordinate
     */
    private $lowerLeftCorner;
    /**
     * @var Coordinate
     */
    private $upperRightCorner;

    public function __construct(
        Coordinate $lowerLeftCorner,
        Coordinate $upperRightCorner

    ) {
        $this->lowerLeftCorner = $lowerLeftCorner;
        $this->upperRightCorner = $upperRightCorner;
    }

    /**
     * @return Coordinate
     */
    public function lowerLeftCorner(): Coordinate
    {
        return $this->lowerLeftCorner;
    }

    /**
     * @return Coordinate
     */
    public function upperRightCorner(): Coordinate
    {
        return $this->upperRightCorner;
    }

}
