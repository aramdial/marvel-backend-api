<?php 
use DI\Container;
use Slim\Factory\AppFactory;
// dependency container - help instantiate a singleton which is only created once throughout app 
$container = new Container();
AppFactory::setContainer($container);