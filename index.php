<?php

session_start();

require_once("vendor/autoload.php");

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r)
{
    $r->addRoute("GET", "/", "App\Controllers\UsersController@index");
    $r->addRoute("POST", "/", "App\Controllers\UsersController@signIn");
    $r->addRoute("GET", "/register", "App\Controllers\UsersController@register");
    $r->addRoute("POST", "/register", "App\Controllers\UsersController@create");
    $r->addRoute("POST", "/logOut", "App\Controllers\UsersController@logOut");
    $r->addRoute("GET", "/tasks", "App\Controllers\TasksController@index");
    $r->addRoute("POST", "/tasks", "App\Controllers\TasksController@create");
    $r->addRoute("POST", "/tasks/delete/{id}", "App\Controllers\TasksController@delete");
});

$httpMethod = $_SERVER["REQUEST_METHOD"];
$uri = $_SERVER["REQUEST_URI"];

if (false !== $pos = strpos($uri, "?"))
{
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0])
{
    case FastRoute\Dispatcher::NOT_FOUND:
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        [$handler, $method] = explode("@", $routeInfo[1]);
        $vars = $routeInfo[2];
        $handler::$method(...array_values($vars));
        break;
}
