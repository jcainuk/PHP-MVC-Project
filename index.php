<?php

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

spl_autoload_register(function (string $class_name) {
  require "src/" . str_replace("\\", "/", $class_name) . ".php";
});

$router = new Framework\Router;

/** Note to self: remove /mvc from the file path in production environment */
$router->add("/mvc/home", ["controller" => "home", "action" => "index"]);
$router->add("/mvc/home/index", ["controller" => "home", "action" => "index"]);

$router->add("/mvc/products", ["controller" => "products", "action" => "index"]);
$router->add("/mvc/products/index", ["controller" => "products", "action" => "index"]);

$router->add("/mvc/products/show", ["controller" => "products", "action" => "show"]);
$router->add("/mvc/", ["controller" => "home", "action" => "index"]);

$params = $router->match($path);

if ($params === false) {
  exit("No route matched");
}

$action = $params["action"];
$controller = "App\Controllers\\" . ucwords($params["controller"]);

$controller_object = new $controller();

$controller_object->$action();
