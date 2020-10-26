<?php

namespace MarsDiscovery\App\Domain;

use MarsDiscovery\App\Domain\Exception\MarsDiscoveryResultNotFoundMarsDiscoveryResultRepositoryException;

interface MarsDiscoveryResultRepository
{

    /**
     * @return array|MarsDiscoveryResult[]
     */
    public function all(): array;

    /**
     * @param int $id
     *
     * @return MarsDiscoveryResult
     * @throws MarsDiscoveryResultNotFoundMarsDiscoveryResultRepositoryException
     */
    public function ofMarsDiscoveryId(int $id): MarsDiscoveryResult;

    public function add(MarsDiscoveryResult $marsDiscovery): void;

    public function remove(int $id): void;

}
