<?php
 // required package namespaces
 use Slim\App;
// pull in dependencies so they are available within the project
require '../vendor/autoload.php';
require __DIR__ . '/../src/app.php';
// run app
$app->run();