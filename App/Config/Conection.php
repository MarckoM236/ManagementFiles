<?php
namespace App\Config;

class Conection{
    private $host;
    private $database;
    private $user;
    private $password;

    public function __construct(){
        $this->host = $_ENV['DB_HOST'];
        $this->database = $_ENV['DB_NAME'];
        $this->user = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];
    }

    public function getConection(){
        $conn = new \mysqli($this->host, $this->user, $this->password, $this->database);

        // Verificar la conexión
        if ($conn->connect_error) {
            return ["state"=>false,"message"=>$conn->connect_error];
        }
        
        return ["state"=>true,"conection"=>$conn];
    }
}