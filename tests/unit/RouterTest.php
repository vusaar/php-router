<?php
  
  //require 'vendor/autoload.php';

    namespace App\test\unit;

    //require 'vendor/autoload.php';

    use App\Router;
    use PHPUnit\Framework\TestCase;

     class RouterTest extends TestCase{


         /** @test */
          public function it_registered_a_route():void{

              /*
                 register a route to a router class
                 assert if the route is registered to
              */

              $router = new Router();

              $router->addRoute('GET','/test',['TestController','index']);

              $expected = [
                 'GET' => [
                            '/test' =>['TestController','index']
                             ]
                 ];

                 $this->assertEquals($expected,$router->getRoutes());

          }


           /** @test */

          function no_routes_when_router_is_created():void{

                $router = new Router();

                $this->assertEmpty($router->getRoutes());

          }



        

          /** @test
           * @dataProvider RouteNotFoundCases
           */

          function throws_exception_when_no_route($request_url,$request_method):void{

            $router = new Router();

            

            $router->addRoute('GET','/users',['App\Users','index']); 
           // $router->addRoute('GET','/there',['ThereController','index']);   

            $this->expectExceptionMessage('Route not found');
            
            $router->resolve($request_url,$request_method);
               
          }



          public function RouteNotFoundCases():array{

               return [
                  ['/users','GET']
               ];
          }


          

     }
?>