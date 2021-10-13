<?php

namespace App;

class RegisterValidator
{
    private array $errors;

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function __construct()
    {
        $this->errors = [];
    }

    public function validate(array $fields): bool
    {
        if (strpos($fields["username"], " ") !== false)
        {
            $this->errors[] = "Username cannot contain whitespaces";
        }
        if (strlen($fields["username"]) < 5)
        {
            $this->errors[] = "Username must be at least 5 characters long";
        }
        if (strlen($fields["password"]) < 8)
        {
            $this->errors[] = "Password must be at least 8 characters long";
        }
        if ($fields["password"] !== $fields["repeatPassword"])
        {
            $this->errors[] = "Passwords do not match";
        }
        if (empty($this->errors)) return true;
        throw new \App\Exceptions\RegisterValidationException();
    }
}
