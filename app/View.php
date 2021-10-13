<?php

namespace App;

class View
{
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    private array $args;

    public function getArgs(): array
    {
        return $this->args;
    }

    public function __construct(string $name, array $args)
    {
        $this->name = $name;
        $this->args = $args;
    }
}
