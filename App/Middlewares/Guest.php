<?php

class Guest {
    public function validate(){
        if ((isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true)) {
            header('Location: /');
            exit();
        }
        
    }
}