<?php

namespace App\Models;

class User
{
    private string $username;

    private string $password;

    public function __construct(string $username, string $password)
    {
        if (strpos($_POST["username"], " ") !== false)
        {
            throw new \App\Exceptions\UsernameWhitespaceException("Username cannot contain whitespaces");
        }
        if (strlen($_POST["username"]) < 5)
        {
            throw new \LengthException("Username must be at least 5 characters long");
        }
        if (strlen($_POST["password"]) < 8)
        {
            throw new \LengthException("Password must be at least 8 characters long");
        }
        if ($_POST["password"] !== $_POST["repeatPassword"])
        {
            throw new \App\Exceptions\UnmatchingPasswordsException("Passwords do not match");
        }
        $this->username = $username;
        $this->password = $password;
    }
}
