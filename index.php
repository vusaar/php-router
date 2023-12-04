<?php

    require_once __DIR__.'\vendor\autoload.php';

    include_once "App/Router.php";
 
    $router = new App\Router();

    $router->addRoute('GET','/index.php', function (){

          echo "<p>inside index route</p>";
    });


    $router->addRoute('GET','/login', function (){

        echo "<p>login route</p>";
  });


  $router->addRoute('GET','/users', ['App\Users','index']);


    $router->matchRoute();

?>