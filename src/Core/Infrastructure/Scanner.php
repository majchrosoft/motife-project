<?php

namespace MarsDiscovery\Core\Infrastructure;

class Scanner
{
    public function nextInt(): int
    {
        return intval(trim(fgets(STDIN)));
    }

    public function readline(): string
    {
        return readline("Command: ");
    }
}
