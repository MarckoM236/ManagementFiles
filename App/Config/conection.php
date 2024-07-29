<?php

class Conection{
    private $host;
    private $database;
    private $user;
    private $password;

    public function __construc(){
        $this->host = 'localhost';
        $this->database = 'management';
        $this->user = 'root';
        $this->password = '';
    }

    public function getConection(){
        $conn = new mysqli('localhost', 'root', '', 'management');

        // Verificar la conexión
        if ($conn->connect_error) {
            return ["state"=>false,"message"=>$conn->connect_error];
        }
        
        return ["state"=>true,"conection"=>$conn];
    }
}