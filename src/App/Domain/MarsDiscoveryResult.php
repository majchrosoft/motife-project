<?php

namespace MarsDiscovery\App\Domain;

class MarsDiscoveryResult
{
    /**
     * @var array|RobotDiscoveryResult
     */
    private $robotDiscoveryResultList;
    /**
     * @var int
     */
    private $marsDiscoveryId;

    public function __construct(
        int $marsDiscoveryId,
        array $robotDiscoveryResultList
    ) {
        foreach ($robotDiscoveryResultList as $robotDiscoveryResult) {
            $this->assertIdRobotDiscoveryResult($robotDiscoveryResult);
            $this->robotDiscoveryResultList[] = $robotDiscoveryResult;
        }
        $this->marsDiscoveryId = $marsDiscoveryId;
    }

    /**
     * @return array|RobotDiscoveryResult
     */
    public function robotDiscoveryResultList()
    {
        return $this->robotDiscoveryResultList;
    }

    /**
     * @return int
     */
    public function marsDiscoveryId(): int
    {
        return $this->marsDiscoveryId;
    }

    private function assertIdRobotDiscoveryResult(RobotDiscoveryResult $robotDiscoveryResult): void
    {
        return;
    }

}
