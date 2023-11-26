<?php

  namespace App;

  

  class Router{

    

  /*
       store routes here
  */
      protected $routes =[];

      public function addRoute(string $method, string $url, $target){


           $this->routes[$method][$url] = $target;

      }


      public function matchRoute(){

        $configs = include_once("./config.php");

        if(!isset($configs['base_url'])){

            throw new \Exception('base_url not found in config file');
        }

        print_r($configs);
        print_r($_SERVER);

        $method = $_SERVER['REQUEST_METHOD'];

          $url = $_SERVER['REQUEST_URI'];


          echo __DIR__.'<p>';
          echo $url;

          if(isset($this->routes[$method])){

               foreach($this->routes[$method] as $routeUrl=> $target){

                  if($routeUrl === $url){

                      call_user_func($target);

                  }

               }

          }

          throw new \Exception('Route not found');

      }
  }


?>