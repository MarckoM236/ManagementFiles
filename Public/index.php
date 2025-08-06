<?php
//allow display errors
error_reporting(E_ALL);
ini_set('display_errors', '1');

//load composer autoload
require __DIR__ . '/../vendor/autoload.php';

//load dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); 
$dotenv->load();

use App\Config\Router;

session_start();

$urlFull = $_SERVER['REQUEST_URI'];
$urlComponents = explode('/', trim($urlFull, '/'));

$url = '/' . (isset($urlComponents[0]) ? $urlComponents[0] : '');
$params = count(array_slice($urlComponents, 1)) > 0 ? array_slice($urlComponents, 1) : [] ;
$method = $_SERVER['REQUEST_METHOD'];
$data = null;
$files = null;
if($method === 'POST'){
    $data = $_POST;
    $files = $_FILES;
}

$router = new Router();
$router->router($url, $params, $method, $data, $files);
