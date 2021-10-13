<?php

namespace App\Controllers;

use App\Models\Task;
use App\Storages\CSVTasksStorage;

class TasksController
{
    public static function index(): void
    {
        if (empty($_SESSION["user"])) header("Location: /");
        $storage = new CSVTasksStorage("storages/tasks.csv");
        $tasks = $storage->getTasks();
        $loader = new \Twig\Loader\FilesystemLoader("app/Views");
        $twig = new \Twig\Environment($loader);
        echo $twig->render("tasks.template.html", [
            "tasks" => $tasks,
            "user" => $_SESSION["user"],
            "errors" => $_SESSION["errors"]
        ]);
        unset($_SESSION["errors"]);
    }

    public static function create(): void
    {
        try
        {
            $storage = new CSVTasksStorage("storages/tasks.csv");
            $storage->add(new Task($_POST["description"]));
        }
        catch (\LengthException $e)
        {
            $_SESSION["errors"][] = $e->getMessage();
        }
        finally
        {
            header("Location: /tasks");
        }
    }

    public static function delete(string $id): void
    {
        $storage = new CSVTasksStorage("storages/tasks.csv");
        $storage->delete($storage->searchById($id));
        header("Location: /tasks");
    }
}
