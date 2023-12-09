<?php

  namespace App;

  use DI\Container;

  class Router{

    
  /*
       store routes here
  */
      protected $routes = [];

      protected $di_container;


      function __construct()
      {
         $this->di_container = new Container();
      }


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


                if(is_array($target)){

                  
                   [$myclass,$method] = $target;

                     if(class_exists($myclass,true)){

                       // $class = new $myclass();

                       $class  = $this->di_container->get($myclass);

                       //var_dump($class); return;

                        if(method_exists($class,$method)){
                            
                              
                             return call_user_func_array([$class,$method],[]);

                        }

                     }

                }

                if(is_callable($target)){

                  //var_dump($target); return;
                 
                  return call_user_func($target);
                 
               }

             }

          }

     }

     throw new \Exception('Route not found');


      }
  }


?>