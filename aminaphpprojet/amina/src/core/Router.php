<?php 
namespace App\Core;

class Router{
    //Enregister les routes de l'application
    private static array $routes=[];
    private static Controller $ctr;

    public static  function route(string $uri,array $route){
        self::$routes[$uri]=$route;
    }

    public static  function resolve(){
        $ctr=new Controller;
        $uri=explode("?",$_SERVER['REQUEST_URI'])[0];
        if(isset(self::$routes[$uri])){
            [$ctrlClasseName,$action]=self::$routes[$uri];
            if(class_exists($ctrlClasseName) && method_exists($ctrlClasseName,$action)){
                  $ctrl=new $ctrlClasseName();
                  call_user_func([$ctrl,$action]);
            }else{
                die("here");
                $ctr->redirect("/");
            }
        }else{
            $ctr->redirect("/");
        }
       
    }
}