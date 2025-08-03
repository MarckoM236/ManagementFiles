<?php

$routes = ['/' => ['GET','DocumentController@index']];
$routes['/create'] = ['GET', 'DocumentController@create'];
$routes['/store'] = ['POST', 'DocumentController@store'];
$routes['/edit'] = ['GET', 'DocumentController@edit'];
$routes['/update'] = ['POST', 'DocumentController@update'];
$routes['/delete'] = ['GET', 'DocumentController@delete'];
