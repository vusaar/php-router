<?php

  namespace App;

  

  class Router{

    

  /*
       store routes here
  */
      protected $routes = [];

      public function addRoute(string $method, string $url, $target){

           $this->routes[$method][$url] = $target;

      }


      public function getRoutes():array{

          return $this->routes;
      }


      public function matchRoute(){

        $configs = include_once("./config.php");

        if(!isset($configs['base_url'])){

            throw new \Exception('base_url not found in config file');
        }

        // print_r($configs);
        // print_r($_SERVER);


        $server_name = $_SERVER['SERVER_NAME'];

        //echo '<p>'.$configs['base_url'];

        
      
       $subdomain = str_replace($_SERVER['SERVER_NAME'],'',substr($configs['base_url'],strpos($configs['base_url'],$server_name)));

         
        $method = $_SERVER['REQUEST_METHOD'];

          $url = $_SERVER['REQUEST_URI'];


          // echo __DIR__.'<p>';
           

           $url = str_replace($subdomain,'',$url);

           

          $this->resolve($url,$method);

      }


      public function resolve($url,$method){


        if(isset($this->routes[$method])){

          foreach($this->routes[$method] as $routeUrl=> $target){

              

             if($routeUrl === $url){

                if(is_callable($target)){
                  
                   return call_user_func($target);
                  
                }


                if(is_array($target)){

                  
                   [$myclass,$method] = $target;

                     if(class_exists($myclass,true)){

                        $class = new $myclass();

                        if(method_exists($class,$method)){
                            
                             return call_user_func_array([$class,$method],[]);

                        }

                     }

                }
                 

             }

          }

     }

     throw new \Exception('Route not found');


      }
  }


?>