<?php

$routes = ['/' => ['GET','HomeController@index']];
$routes['/documents'] = ['GET','DocumentController@index','Auth'];
$routes['/create'] = ['GET', 'DocumentController@create','Auth'];
$routes['/store'] = ['POST', 'DocumentController@store','Auth'];
$routes['/edit'] = ['GET', 'DocumentController@edit','Auth'];
$routes['/update'] = ['POST', 'DocumentController@update','Auth'];
$routes['/delete'] = ['GET', 'DocumentController@delete','Auth'];

$routes['/allCategories'] = ['GET', 'CategoryController@index','Auth'];
$routes['/categoryCreate'] = ['GET', 'CategoryController@create','Auth'];
$routes['/categoryStore'] = ['POST', 'CategoryController@store','Auth'];
$routes['/categoryEdit'] = ['GET', 'CategoryController@edit','Auth'];
$routes['/categoryUpdate'] = ['POST', 'CategoryController@update','Auth'];
$routes['/categoryDelete'] = ['GET', 'CategoryController@delete','Auth'];

$routes['/register'] = ['GET', 'AuthController@register','Guest'];
$routes['/registerStore'] = ['POST', 'AuthController@registerStore','Guest'];
$routes['/login'] = ['GET', 'AuthController@login','Guest'];
$routes['/postLogin'] = ['POST', 'AuthController@postLogin','Guest'];
$routes['/logout'] = ['GET', 'AuthController@logout','Auth'];
