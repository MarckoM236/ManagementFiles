<?php
require '../App/Config/router.php';

$urlFull = $_SERVER['REQUEST_URI'];
$urlComponents = explode('/', trim($urlFull, '/'));

$url = '/' . (isset($urlComponents[0]) ? $urlComponents[0] : '');
$params = array_slice($urlComponents, 1);
$method = $_SERVER['REQUEST_METHOD'];
$data=null;
if($method === 'POST'){
    $data = $_POST;
}

$router = new Router();
$router->router($url, $params, $method, $data);
