<?php
include_once('Controller.php');

class HomeController extends Controller{

    public function __construct(){}

    public function index(){
        $this->render('Home'.DIRECTORY_SEPARATOR.'index');
    }
}