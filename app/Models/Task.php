<?php

namespace App\Models;

class Task
{
    private string $description;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        if (trim($description) === "")
        {
            throw new \LengthException("Task description cannot be empty");
        }
        $this->description = $description;
    }

    public function __construct(string $description)
    {
        if (trim($description) === "")
        {
            throw new \LengthException("Task description cannot be empty");
        }
        $this->description = $description;
    }
}
