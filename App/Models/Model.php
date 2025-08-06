<?php
namespace App\Models;

use App\Config\Conection;

class Model {
    private $con;
    protected $table;

    public function __construct(){
        $conection= new Conection();
        $this->con = $conection->getConection();
    }

    //Get data of especific table
    public function getQuery($fields=[],$where=[]){
        //validate allowed fields
        $validFields = array_intersect($fields, $this->allowedColumns);
        if (empty($validFields)) {
            return ['state' => 'false', "message" => "No valid fields requested."];
        }
        
        if($this->con['state'] == true){
            $stringFields = implode(",",$fields);
            $stringWhere = "";

            $sql = "SELECT $stringFields FROM $this->table";
            if(count($where) > 0){
                $conditions = [];
                foreach($where as $key => $value){
                    $escapedValue = $this->con['conection']->real_escape_string($value);
                    $conditions[] = "$key='$escapedValue'";
                }
                $stringWhere = " WHERE " . implode(" AND ", $conditions);
                $sql .= $stringWhere;
            }
            $result = $this->con['conection']->query($sql);

            if($this->con['conection']->error == ""){
                if ($result && $result->num_rows > 0) {
                    // Obtener todas las filas como un array asociativo
                    $rows = $result->fetch_all(MYSQLI_ASSOC);
                    
                    return ['state'=>'true',"data"=>$rows];
                } else {
                    return ['state'=>'false',"message"=>"No results found"];
                }
            }
            else{
                return ['state'=>'false',"message"=>$this->con['conection']->error];
            }
        }
        else{
            return ['state'=>'false',"message"=>$this->con['message']];
        }
    }

    //Get data of custom query
    public function customQuery($sql,$where=[]){
        if($this->con['state'] == true){
            $stringWhere = "";

            if(count($where) > 0){
                $conditions = [];
                foreach($where as $key => $value){
                    $escapedValue = $this->con['conection']->real_escape_string($value);
                    $conditions[] = "$key='$escapedValue'";
                }
                $stringWhere = " WHERE " . implode(" AND ", $conditions);
                $sql .= $stringWhere;
            }
            $result = $this->con['conection']->query($sql);

            if($this->con['conection']->error == ""){
                if ($result && $result->num_rows > 0) {
                    // Obtener todas las filas como un array asociativo
                    $rows = $result->fetch_all(MYSQLI_ASSOC);
                    
                    return ['state'=>'true',"data"=>$rows];
                } else {
                    return ['state'=>'false',"message"=>"No results found"];
                }
            }
            else{
                return ['state'=>'false',"message"=>$this->con['conection']->error];
            }
        }
        else{
            return ['state'=>'false',"message"=>$this->con['message']];
        }
    }

    //consult if exist record by condition
    public function getByParams($where=[]){
        $sql = "SELECT COUNT(*) as count FROM $this->table";
        $conditions = [];
        foreach($where as $key => $value){
            $escapedValue = $this->con['conection']->real_escape_string($value);
            $conditions[] = "$key='$escapedValue'";
        }
        $stringWhere = " WHERE " . implode(" AND ", $conditions);
        $sql .= $stringWhere;

        $result = $this->con['conection']->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'] > 0; 
        } else {
            return false;
        }
    }

    //query statement (for login)
    public function getQueryStatement($fields,$where = []) {
        if ($this->con['state'] !== true) {
            return ['state' => 'false', "message" => $this->con['message']];
        }

        //validate allowed fields
        $validFields = array_intersect($fields, $this->allowedColumns);
        if (empty($validFields)) {
            return ['state' => 'false', "message" => "No valid fields requested."];
        }

        $stringFields = implode(",",$validFields);
        $stringWhere = "";
        $types = "";
        $whereFields = [];

        $sql = "SELECT $stringFields FROM $this->table";

        if(count($where) > 0){
            $conditions = [];
            foreach($where as $key => $value){
                //if not secure ignore column
                if (in_array($key, $this->allowedColumns)) {
                    $conditions[] = "$key= ?";
                    $types .= $value[1][0];
                    $whereFields[] = $value[0];
                }
                else{
                    continue;
                }
            }
            $stringWhere = " WHERE " . implode(" AND ", $conditions);
            $sql .= $stringWhere;
        }

        //prepare query
        $stmt = $this->con['conection']->prepare($sql);

        if ($stmt === false) {
            //if exist sintax error
            return ['state' => 'false', "message" => "Error al preparar la consulta."];
        }

        if (!empty($whereFields)) {
            $stmt->bind_param($types, ...$whereFields);
        }

        //execute query
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $userData = $result->fetch_assoc();
            return ['state' => 'true', "data" => $userData];
        } else {
            return ['state' => 'false', "message" => "No results found"];
        }

        $stmt->close();
    }

    //insert a new record
    public function insert($fields=[],$data=[]){

        //validate allowed fields
        $validFields = array_intersect($fields, $this->allowedColumns);
        if (empty($validFields)) {
            return ['state' => 'false', "message" => "No valid fields requested."];
        }
        
        if($this->con['state'] == true){
            $stringFields = implode(",",$validFields);
            $sql = "INSERT INTO $this->table ($stringFields) VALUES(";
            foreach($data as $value){
                $escapedValue = $this->con['conection']->real_escape_string($value);
                $conditions[] = "'$escapedValue'";
            }
            $stringData = implode(",", $conditions);
            $sql .= $stringData.")";
            
            $result = $this->con['conection']->query($sql);

            if($this->con['conection']->error == ""){
                if ($result) {
                    
                    return ['state'=>true,"message"=>"The record was inserted successfully"];
                } else {
                    return ['state'=>false,"message"=>"Error inserting record"];
                }
            }
            else{
                return ['state'=>false,"message"=>$this->con['conection']->error];
            }
        }
        else{
            return ['state'=>false,"message"=>$this->con['message']];
        }

    }

    //delete record by id
    public function delete($where=[]){
        if(count($where) > 0){
            if($this->con['state'] == true){
                $sql = "DELETE FROM $this->table";
                $conditions = [];
                foreach($where as $key => $value){
                    $escapedValue = $this->con['conection']->real_escape_string($value);
                    $conditions[] = "$key='$escapedValue'";
                }
                $stringWhere = " WHERE " . implode(" AND ", $conditions);
                $sql .= $stringWhere;
                
                $result = $this->con['conection']->query($sql);
    
                if($this->con['conection']->error == ""){
                    if ($result) {
                        
                        return ['state'=>true,"message"=>"The record was deleted successfully"];
                    } else {
                        return ['state'=>false,"message"=>"Error when trying to delete the registry"];
                    }
                }
                else{
                    return ['state'=>false,"message"=>$this->con['conection']->error];
                }
            }
            else{
                return ['state'=>false,"message"=>$this->con['message']];
            }
            
        }
        else{
            return ['state'=>false,"message"=>"You must specify a condition parameter"];
        }
    }

    //update record by id
    public function update(){
        //validate allowed fields
        $validFields = array_intersect($fields, $this->allowedColumns);
        if (empty($validFields)) {
            return ['state' => 'false', "message" => "No valid fields requested."];
        }
    }
}