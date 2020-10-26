<?php

namespace MarsDiscovery\App\Domain;

class MarsDiscoveryPlan
{
    /**
     * @var Area
     */
    private $area;
    /**
     * @var array|RobotActivityDefinition
     */
    private $robotActivity;
    /**
     * @var int
     */
    private $id;

    public function __construct(
        int $id,
        Area $area,
        array $robotActivity
    ) {
        $this->area = $area;
        $this->robotActivity = $robotActivity;
        $this->id = $id;
    }

    /**
     * @return Area
     */
    public function area(): Area
    {
        return $this->area;
    }

    /**
     * @return array|RobotActivityDefinition[]
     */
    public function robotActivity()
    {
        return $this->robotActivity;
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

}
