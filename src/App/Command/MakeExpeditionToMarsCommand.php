<?php

namespace MarsDiscovery\App\Command;

class MakeExpeditionToMarsCommand
{
    /**
     * @var int
     */
    private $marsDiscoveryId;

    public function __construct(
        int $marsDiscoveryId
    ) {
        $this->marsDiscoveryId = $marsDiscoveryId;
    }

    /**
     * @return int
     */
    public function marsDiscoveryId(): int
    {
        return $this->marsDiscoveryId;
    }

}
