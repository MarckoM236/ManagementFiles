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
                $className = $parts[0];
                $method = $parts[1];
                $fileName = $className.'.php';
                include_once(CONTROLLER_PATH.$fileName);

                try {
                    $controller = new $className;
                    $controller->{$method}($params, $data); 
                    
                } catch (Throwable $e) {
                    die("Error al ejecutar el método: " . $e->getMessage());
                }
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