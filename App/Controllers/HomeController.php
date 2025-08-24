<?php
namespace App\Controllers;

use App\Controllers\Controller;

class HomeController extends Controller{

    public function __construct(){}

    // load  'start page'
    public function index(){
        $this->render('Home'.DIRECTORY_SEPARATOR.'index');
    }
}