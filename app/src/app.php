<?php
use Slim\Factory\AppFactory;
require 'container.php';
// create slim instance
$app = AppFactory::create();
// import middleware and routes
require 'errorMiddleware.php';
require '../routes/apiRoutes.php';