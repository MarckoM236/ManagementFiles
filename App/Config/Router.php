<?php
namespace App\Config;
include('app.php');


class Router{
    public $route;

     public function __construct(){
        include(BASE_PATH.'Routes'.DIRECTORY_SEPARATOR.'web.php');
        $this->route = $routes;

    }

    function router($url,$params,$method,$data=null,$files=null){
        if (array_key_exists($url, $this->route)){
            if($this->route[$url][0]==$method){
                $parts = explode('@', $this->route[$url][1]);
                $className = 'App\\Controllers\\'.$parts[0];
                $method = $parts[1];
                $fileName = $className.'.php';
                

                // --- middlewares ---
                if (isset($this->route[$url][2])) {
                    $middlewares = $this->route[$url][2];
                    if (!is_array($middlewares)) {
                        $middlewares = [$middlewares]; 
                    }

                    foreach($middlewares as $middle){
                        //first letter lower
                        $middlewareClass = 'App\\Middlewares\\'.ucfirst(strtolower($middle));

                        if (class_exists($middlewareClass)) {
                            $mid = new $middlewareClass();
                            $mid->validate();
                        }
                        else{
                            die('Class '.$middlewareClass.' not found');
                        }
                        
                    }
                }               
                
                try {
                    $controller = new $className();
                    $controller->{$method}($params, $data, $files); 
                    
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
