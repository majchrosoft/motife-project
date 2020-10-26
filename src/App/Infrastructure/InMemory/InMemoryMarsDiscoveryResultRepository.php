<?php

namespace MarsDiscovery\App\Infrastructure\InMemory;

use MarsDiscovery\App\Domain\Exception\MarsDiscoveryResultNotFoundMarsDiscoveryResultRepositoryException;
use MarsDiscovery\App\Domain\MarsDiscoveryResult;
use MarsDiscovery\App\Domain\MarsDiscoveryResultRepository;

class InMemoryMarsDiscoveryResultRepository implements MarsDiscoveryResultRepository
{
    /**
     * @var array|MarsDiscoveryResult[]
     */
    private $items;

    public function all(): array
    {
        return $this->items;
    }

    public function ofMarsDiscoveryId(int $id): MarsDiscoveryResult
    {
        $filtered = array_filter(
            $this->items,
            function (MarsDiscoveryResult $item) use ($id) {
                return $item->marsDiscoveryId() === $id;
            }
        );

        $item = reset($filtered);

        if (!$item) {
            throw new MarsDiscoveryResultNotFoundMarsDiscoveryResultRepositoryException('MarsDiscoveryResultNotFound');
        }

        return $item;
    }

    public function add(MarsDiscoveryResult $marsDiscovery): void
    {
        $this->items[] = $marsDiscovery;
    }

    public function remove(int $id): void
    {
        $this->items = array_filter(
            $this->items,
            function (MarsDiscoveryResult $item) use ($id) {
                return $item->marsDiscoveryId() !== $id;
            }
        );
    }
}
