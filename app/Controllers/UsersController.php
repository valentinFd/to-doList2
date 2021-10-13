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
            $loader = new \Twig\Loader\FilesystemLoader("app/Views");
            $twig = new \Twig\Environment($loader);
            echo $twig->render("index.template.html", [
                "errors" => $_SESSION["errors"]
            ]);
            unset($_SESSION["errors"]);
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
        catch (\App\Exceptions\InputException $e)
        {
            $_SESSION["errors"][] = $e->getMessage();
            header("Location:/ ");
        }
    }

    public static function register(): void
    {
        if (empty($_SESSION["user"]))
        {
            $loader = new \Twig\Loader\FilesystemLoader("app/Views");
            $twig = new \Twig\Environment($loader);
            echo $twig->render("register.template.html", [
                "errors" => $_SESSION["errors"]
            ]);
            unset($_SESSION["errors"]);
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
            $storage = new CSVUsersStorage("storages/users.csv");
            $storage->add(new User($_POST["username"], $_POST["password"]));
            header("Location: /");
        }
        catch (\App\Exceptions\UsernameWhitespaceException | \App\Exceptions\EmptyPasswordException |
        \App\Exceptions\UnmatchingPasswordsException | \LengthException $e)
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
