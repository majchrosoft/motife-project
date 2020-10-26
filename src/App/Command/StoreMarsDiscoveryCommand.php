<?php

namespace MarsDiscovery\App\Command;

class StoreMarsDiscoveryCommand
{
    /**
     * @var int
     */
    private $areaRightUpperCornerX;
    /**
     * @var int
     */
    private $areaRightUpperCornerY;
    /**
     * @var array
     */
    private $robotStartCoordinatesAndDirectionAndMovementList;
    /**
     * @var array
     */
    private $robotMovementList;
    /**
     * @var int
     */
    private $marsDiscoveryId;

    public function __construct(
        int $marsDiscoveryId,
        int $areaRightUpperCornerX,
        int $areaRightUpperCornerY,
        array $robotStartCoordinatesAndDirectionAndMovementList
    ) {
        $this->areaRightUpperCornerX = $areaRightUpperCornerX;
        $this->areaRightUpperCornerY = $areaRightUpperCornerY;
        $this->robotStartCoordinatesAndDirectionAndMovementList = $robotStartCoordinatesAndDirectionAndMovementList;
        $this->marsDiscoveryId = $marsDiscoveryId;
    }

    /**
     * @return int
     */
    public function areaRightUpperCornerX(): int
    {
        return $this->areaRightUpperCornerX;
    }

    /**
     * @return int
     */
    public function areaRightUpperCornerY(): int
    {
        return $this->areaRightUpperCornerY;
    }

    /**
     * @return array
     */
    public function robotStartCoordinatesAndDirectionList(): array
    {
        return $this->robotStartCoordinatesAndDirectionAndMovementList;
    }

    /**
     * @return array
     */
    public function robotMovementList(): array
    {
        return $this->robotMovementList;
    }

    /**
     * @return int
     */
    public function marsDiscoveryId(): int
    {
        return $this->marsDiscoveryId;
    }

}
