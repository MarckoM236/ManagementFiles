<?php
include('app.php');
class Router{
    public $route;

     public function __construct(){
        include(BASE_PATH.'Routes'.DIRECTORY_SEPARATOR.'web.php');
        $this->route = $routes;

    }

    function router($url,$params,$method,$data=null){
        if (array_key_exists($url, $this->route)){
            if($this->route[$url][0]==$method){
                $parts = explode('@', $this->route[$url][1]);
                include_once(CONTROLLER_PATH.$parts[0].'.php');
                $controller = new $parts[0];
                $controller->{$parts[1]}($params,$data);//get function
            }
            else{
                die("Metodo incorrecto, envie la solicitud por " . $this->route[$url][0]);
            }
        }
        else{
            die("404 Pagina no encontrada");
        }
        
        
     }
}