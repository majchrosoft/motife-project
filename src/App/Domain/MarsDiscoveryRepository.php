<?php

namespace MarsDiscovery\App\Domain;

use MarsDiscovery\App\Domain\Exception\MarsDiscoveryNotFoundMarsDiscoveryRepositoryException;

interface MarsDiscoveryRepository
{

    /**
     * @return array|MarsDiscoveryPlan[]
     */
    public function all(): array;

    /**
     * @param int $id
     *
     * @return MarsDiscoveryPlan
     * @throws MarsDiscoveryNotFoundMarsDiscoveryRepositoryException
     */
    public function ofId(int $id): MarsDiscoveryPlan;

    public function add(MarsDiscoveryPlan $marsDiscovery): void;

    public function remove(int $id): void;

}
