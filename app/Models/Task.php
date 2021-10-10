<?php

namespace App\Models;

class Task
{
    private string $description;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function __construct(string $description)
    {
        $this->description = $description;
    }
}
