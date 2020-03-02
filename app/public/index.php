<?php
 // required package namespaces
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// pull in depedencies so they are available within the project
require '../vendor/autoload.php';
// create slim instance
$app = AppFactory::create();
// import middleware
$middleware = require __DIR__ . '/../middleware/errorMiddleware.php';
// add global app middleware
$middleware($app);
// root route
$app->get('/', function(Request $req, Response $res){
    // request - incoming data; response - outgoing data
    // alternative is to use views for rendering data to client
    $res->getBody()->write("'Just because something works, doesn't mean it can't be improved.' – Shuri (Black Panther, 2018)");
    return $res;
});
// run app
$app->run();
