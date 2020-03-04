<?php
declare(strict_types=1);    // ensure type-safety
// required package namespaces
use Slim\App;
use Marvel\Controllers\CharactersController;
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
$app->group('/v1/public/series', function(RouteCollectorProxy $group){
    //series
    $group->get('', function(Request $req, Response $res){
        // alternative is to use views for rendering data to client
        $res->getBody()->write("Series!");
        return $res;
    });
    // series by param
    $group->options('/{titleStartsWith}', function(Request $req, Response $res){
        // alternative is to use views for rendering data to client
        $res->getBody()->write("Return query");
        return $res;
    });
});

$app->group('/v1/public/characters', function(RouteCollectorProxy $group){
    //characters
    $group->get('', CharactersController::class . ':listAll');
    // characters by param
    $group->get('/{nameStartsWith}', CharactersController::class . ':listByParam');
});


