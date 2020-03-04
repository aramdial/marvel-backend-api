<?php
declare(strict_types=1);    // ensure type-safety
// required package namespaces
use Slim\App;
use Marvel\Controllers\CharactersController;
use Marvel\Controllers\SeriesController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

// root route
$app->get('/', function(Request $req, Response $res){
    // alternative is to use views for rendering data to client
    $res->getBody()->write("'Just because something works, doesn't mean it can't be improved.' – Shuri (Black Panther, 2018)");
    return $res;
});
// group routes based on common paths
$app->group('/v1/public', function(RouteCollectorProxy $group){
    //series
    $group->get('/series', SeriesController::class . ':listAll');
    $group->get('/characters', CharactersController::class . ':listAll');
});


