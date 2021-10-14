<?php

namespace App\Controllers;

use App\Models\Task;
use App\Storages\CSVTasksStorage;
use App\View;

class TasksController
{
    public static function index(): View
    {
        if (empty($_SESSION["user"])) header("Location: /");
        $storage = new CSVTasksStorage("storages/tasks.csv");
        $tasks = $storage->getTasks();
        return new View("tasks.template.html", [
            "tasks" => $tasks,
            "user" => $_SESSION["user"],
            "errors" => $_SESSION["errors"]
        ]);
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

    public static function update(string $id): View
    {
        if (empty($_SESSION["user"])) header("Location: /");
        $storage = new CSVTasksStorage("storages/tasks.csv");
        $task = $storage->searchById($id);
        return new View("update.template.html", [
            "task" => $task,
            "taskId" => $id,
            "user" => $_SESSION["user"],
            "errors" => $_SESSION["errors"]
        ]);
    }

    public static function edit(string $id): void
    {
        try
        {
            $storage = new CSVTasksStorage("storages/tasks.csv");
            $storage->edit($id, $_POST["description"]);
            header("Location: /tasks");
        }
        catch (\LengthException $e)
        {
            $_SESSION["errors"][] = $e->getMessage();
            header("Location: /tasks/update/$id");
        }
    }
}
