<?php
// required package namespaces
use Slim\Factory\AppFactory;
// create slim instance
$app = AppFactory::create();
// import middleware and classes
require __DIR__ . '/src/middleware/errorMiddleware.php';
require __DIR__ .'/src/routes/apiRoutes.php';
