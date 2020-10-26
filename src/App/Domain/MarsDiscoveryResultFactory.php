<?php

namespace MarsDiscovery\App\Domain;

class MarsDiscoveryResultFactory
{
    public function create(
        int $marsDiscoveryId,
        array $robotDiscoveryResultList
    ): MarsDiscoveryResult {
        return new MarsDiscoveryResult(
            $marsDiscoveryId,
            $robotDiscoveryResultList
        );
    }

}
