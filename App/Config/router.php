<?php
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
                $className = $parts[0];
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
                        $middlewareClass = ucfirst(strtolower($middle));
                        $middlewareFile = MIDDLEWARE_PATH.$middlewareClass.'.php';
                        if (file_exists($middlewareFile)){
                            include_once($middlewareFile);

                            if (class_exists($middlewareClass)) {
                                $mid = new $middlewareClass();
                                $mid->validate();
                            }
                            else{
                                die('Class '.$middlewareClass.' not found');
                            }
                        }
                        else{
                            die('File '.$middlewareFile.' not found');
                        }
                    }
                }               
                
                if (file_exists(CONTROLLER_PATH.$fileName)){
                    include_once(CONTROLLER_PATH.$fileName);
                }
                else{
                    die('File '.$fileName.' not found');
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
