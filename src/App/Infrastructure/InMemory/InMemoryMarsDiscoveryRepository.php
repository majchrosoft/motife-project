<?php

namespace MarsDiscovery\App\Infrastructure\InMemory;

use MarsDiscovery\App\Domain\Exception\MarsDiscoveryNotFoundMarsDiscoveryRepositoryException;
use MarsDiscovery\App\Domain\MarsDiscoveryPlan;
use MarsDiscovery\App\Domain\MarsDiscoveryRepository;

class InMemoryMarsDiscoveryRepository implements MarsDiscoveryRepository
{
    /**
     * @var array|MarsDiscoveryPlan[]
     */
    private $items = [];

    /**
     * @return MarsDiscoveryPlan[]|array
     */
    public function all(): array
    {
        return $this->items;
    }

    public function ofId(int $id): MarsDiscoveryPlan
    {
        $filtered = array_filter(
            $this->items,
            function (MarsDiscoveryPlan $item) use ($id) {
                return $item->id() === $id;
            }
        );

        $item = reset($filtered);

        if (!$item) {
            throw new MarsDiscoveryNotFoundMarsDiscoveryRepositoryException('MarsDiscoveryNotFound');
        }

        return $item;
    }

    public function add(MarsDiscoveryPlan $marsDiscovery): void
    {
        $this->items[] = $marsDiscovery;
    }

    public function remove(int $id): void
    {
        $this->items = array_filter(
            $this->items,
            function (MarsDiscoveryPlan $item) use ($id) {
                return $item->id() !== $id;
            }
        );
    }
}
