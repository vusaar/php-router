<?php

    require_once __DIR__.'\vendor\autoload.php';

    include_once "App/Router.php";
 
    $router = new App\Router();

    $router->addRoute('GET','/', function (){

          echo "inside index route";
    });


    $router->matchRoute();

?>