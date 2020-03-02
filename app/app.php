<?php
// required package namespaces
use Slim\Factory\AppFactory;
// create slim instance
$app = AppFactory::create();
// import middleware and classes
require '../src/containers/container.php';
require '../src/middleware/errorMiddleware.php';
require '../src/routes/apiRoutes.php';
?>