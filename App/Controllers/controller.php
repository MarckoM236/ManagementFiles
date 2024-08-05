<?php
session_start();

class Controller{

    //Return view whit data if exits
    protected function render($view, $data = []) {
        extract($data);
        include(VIEW_PATH . $view . '.php');
    }

    //redirect to url whit success message or error message
    function redirectTo($url,$message,$type) {
        if (!headers_sent()) {
            header("Location: $url");
            $_SESSION[$type] = $message;
            exit(); 
        } else {
            echo "<script type='text/javascript'>window.location.href='$url';</script>";
            exit();
        }
    }

    //redirect to url with validations fiels errors
    function fielValidate($url,$errors,$olds) {
        if (!headers_sent()) {
            header("Location: $url");
            foreach($errors as $key => $value){
                $_SESSION[$key] = $value;
            }
                $_SESSION['olds'] = $olds;
            exit(); 
        } else {
            echo "<script type='text/javascript'>window.location.href='$url';</script>";
            exit();
        }
    }

}