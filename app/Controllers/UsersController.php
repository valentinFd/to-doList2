<?php

namespace App\Controllers;

use App\Models\User;
use App\Storages\CSVUsersStorage;

class UsersController
{
    public static function index(): void
    {
        if (empty($_SESSION["user"]))
        {
            require_once("app/Views/index.template.php");
        }
        else
        {
            header("Location: /tasks");
        }
    }

    public static function signIn(): void
    {
        try
        {
            $storage = new CSVUsersStorage("storages/users.csv");
            if ($storage->validate($_POST["username"], $_POST["password"]))
            {
                $_SESSION["user"] = $_POST["username"];
                header("Location: /tasks");
            }
            else
            {
                throw new \Exception("Incorrect username or password");
            }
        }
        catch (\Exception $e)
        {
            $_SESSION["errors"][] = $e->getMessage();
            header("Location:/ ");
        }
    }

    public static function register(): void
    {
        if (empty($_SESSION["loggedIn"]))
        {
            require_once("app/Views/register.template.php");
        }
        else
        {
            header("Location: /tasks");
        }
    }

    public static function create(): void
    {
        try
        {
            if (strpos($_POST["username"], " ") !== false)
            {
                throw new \App\Exceptions\UsernameWhitespaceException("Username cannot contain whitespaces");
            }
            elseif (strlen($_POST["username"]) < 5)
            {
                throw new \App\Exceptions\UsernameLengthException("Username must be at least 5 characters long");
            }
            if (trim($_POST["password"]) === "")
            {
                throw new \App\Exceptions\EmptyPasswordException("Password cannot be empty");
            }
            elseif (strlen($_POST["password"]) < 8)
            {
                throw new \App\Exceptions\PasswordLengthException("Password must be at least 5 characters long");
            }
            if ($_POST["password"] === $_POST["repeatPassword"])
            {
                $storage = new CSVUsersStorage("storages/users.csv");
                $storage->add(new User($_POST["username"], $_POST["password"]));
                header("Location: /");
            }
            else
            {
                throw new \App\Exceptions\UnmatchingPasswordsException("Passwords do not match");
            }
        }
        catch (\App\Exceptions\UsernameWhitespaceException | \App\Exceptions\UsernameLengthException
        | \App\Exceptions\EmptyPasswordException | \App\Exceptions\PasswordLengthException |
        \App\Exceptions\UnmatchingPasswordsException$e)
        {
            $_SESSION["errors"][] = $e->getMessage();
            header("Location: /register");
        }
    }

    public static function logOut(): void
    {
        session_destroy();
        header("Location: /");
    }
}
