<?php

namespace App\Controllers;

use App\Models\User;
use App\Storages\CSVUsersStorage;

class UsersController
{
    public static function index(): void
    {
        if (empty($_SESSION["loggedIn"]))
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
        $storage = new CSVUsersStorage("storages/users.csv");
        if ($storage->validate($_POST["username"], $_POST["password"]))
        {
            $_SESSION["loggedIn"] = 1;
            header("Location: /tasks");
        }
        else
        {
            header("Location: /");
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
        if ($_POST["password"] === $_POST["repeatPassword"])
        {
            $storage = new CSVUsersStorage("storages/users.csv");
            $storage->add(new User($_POST["username"], $_POST["password"]));
            header("Location: /");
        }
        else
        {
            header("Location: /register");
        }
    }

    public static function logOut(): void
    {
        session_destroy();
        header("Location: /");
    }
}
