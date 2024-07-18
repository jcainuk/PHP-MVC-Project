<?php

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

require "src/router.php";

$router = new Router;

$router->add("/home/index", ["controller" => "home", "action" => "index"]);
$router->add("/products", ["controller" => "products", "action" => "index"]);
$router->add("/", ["controller" => "home", "action" => "index"]);

$segments = explode("/", $path);

/**
 * NOTE: if we print_r($segments) here we get the following. 0 is the slash so empty, then 1,2,3 etc.
 * Array
 * [0] => 
 * [1] => mvc
 * [2] => home
 * [3] => index
 */

$action = $segments[3];
$controller = $segments[2];

require "src/controllers/$controller.php";

$controller_object = new $controller();

$controller_object->$action();
