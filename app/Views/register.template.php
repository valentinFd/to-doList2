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
            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control w-50" id="username" name="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" class="form-control w-50" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="repeatPassword" class="form-label">Repeat Password</label>
                    <input type="text" class="form-control w-50" id="repeatPassword" name="repeatPassword">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
            <div class="mb-3">
                <a href="/" class="btn btn-primary" role="button">Sign in</a>
            </div>
        </div>
        <?php
        foreach ($_SESSION["errors"] as $error): ?>
            <div class="mb-3">
                <?= $error ?>
            </div>
            <?php
            unset($_SESSION["errors"]);
        endforeach ?>
    </div>
</div>
</body>
</html>
