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
        require_once("app/Views/tasks.template.php");
    }

    public static function create(): void
    {
        try
        {
            if (trim($_POST["description"]) === "")
            {
                throw new \Exception("Task description cannot be empty");
            }
            $storage = new CSVTasksStorage("storages/tasks.csv");
            $storage->add(new Task($_POST["description"]));
        }
        catch (\Exception $e)
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
