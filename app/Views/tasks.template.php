<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
          crossorigin="anonymous">
    <title>To-Do List</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            To-Do List
        </div>
        <div class="col">
            <form method="post" action="/logOut">
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Log out</button>
                </div>
            </form>
        </div>
    </div>
    <?php
    foreach ($tasks as $id => $task):?>
        <div class="row">
            <div class="col">
                <?= "$id. {$task->getDescription()}" ?>
            </div>
            <div class="col">
                <form method="post" action="/tasks/delete/<?= $id ?>">
                    <button type="submit" class="btn btn-primary">Delete</button>
                </form>
            </div>
        </div>
    <?php
    endforeach ?>
    <div class="row">
        <div class="col">
            <form method="post" action="/tasks">
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control w-50" id="description" name="description">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
