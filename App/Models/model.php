<?php
include_once(BASE_PATH.'App\Config'.DIRECTORY_SEPARATOR.'conection.php');

class Model {
    private $con;
    protected $table;

    public function __construct(){
        $conection= new Conection();
        $this->con = $conection->getConection();
    }

    //Get data of especific table
    public function getQuery($fileds=[],$where=[]){
        if($this->con['state'] == true){
            $stringFields = implode(",",$fileds);
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

    //insert a new record
    public function insert($fields=[],$data=[]){
        
        if($this->con['state'] == true){
            $stringFields = implode(",",$fields);
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
    public function update(){}
}