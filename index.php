<?php

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

require "src/router.php";

$router = new Router;

/** Note to self: remove /mvc from the file path in production environment */
$router->add("/mvc/home/index", ["controller" => "home", "action" => "index"]);
$router->add("/mvc/products", ["controller" => "products", "action" => "index"]);
$router->add("/mvc/", ["controller" => "home", "action" => "index"]);

$params = $router->match($path);

if ($params === false) {
  exit("No route matched");
}

$action = $params["action"];
$controller = $params["controller"];

require "src/controllers/$controller.php";

$controller_object = new $controller();

$controller_object->$action();
