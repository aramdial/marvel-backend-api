<?php
 use Slim\Factory\AppFactory;
 use DI\Container;
// dependency container - help instantiate a singleton (single instance) created once throughout app 
$container = new Container();
AppFactory::setContainer($container);

