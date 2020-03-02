<?php
 // required package namespaces
use Slim\Factory\AppFactory;
use DI\Container;

// pull in dependencies so they are available within the project
require '../vendor/autoload.php';

// dependency container - help instantiate a singleton which is only created once throughout app 
$container = new Container();
AppFactory::setContainer($container);

// create slim instance
$app = AppFactory::create();
// import middleware
$middleware = require __DIR__ . '/../middleware/errorMiddleware.php';
// add global app middleware
$middleware($app);
// import routes
$routes = require __DIR__ . '/../routes/routes.php';
// add global routes
$routes($app);
// run app
$app->run();