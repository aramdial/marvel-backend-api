<?php
declare(strict_types=1);    // ensure type-safety
 // required package namespaces
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
// Slim provides error middleware to render more meaningful (prettier!!) error stack trace and details
// this will show errors, will not log errors
$errorMiddleware = new ErrorMiddleware(
    $app->getCallableResolver(),
    $app->getResponseFactory(),
    true,
    false,
    false
);
// add global middleware to app
$app->add($errorMiddleware);

