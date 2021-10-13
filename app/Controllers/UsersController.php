<?php

namespace App\Controllers;

use App\Models\User;
use App\Storages\CSVUsersStorage;
use App\View;
use App\RegisterValidator;

class UsersController
{
    public static function index(): View
    {
        if (empty($_SESSION["user"]))
        {
            return new View("index.template.html", [
                "errors" => $_SESSION["errors"]
            ]);
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
        }
        catch (\App\Exceptions\LogInException $e)
        {
            $_SESSION["errors"][] = $e->getMessage();
            header("Location:/ ");
        }
    }

    public static function register(): View
    {
        if (empty($_SESSION["user"]))
        {
            return new View("register.template.html", [
                "errors" => $_SESSION["errors"]
            ]);
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
            $validator = new RegisterValidator();
            if ($validator->validate($_POST))
            {
                $storage = new CSVUsersStorage("storages/users.csv");
                $storage->add(new User($_POST["username"], $_POST["password"]));
                header("Location: /");
            }
        }
        catch (\App\Exceptions\RegisterValidationException $e)
        {
            $_SESSION["errors"] = $validator->getErrors();
            header("Location: /register");
        }
    }

    public static function logOut(): void
    {
        session_destroy();
        header("Location: /");
    }
}
