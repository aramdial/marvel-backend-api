<?php
declare(strict_types=1);    // ensure type-safety no type coercion allowed
// required package namespaces
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

$app->get('/', function(Request $req, Response $res){
    // alternative is to use views for rendering data to client
    $res->getBody()->write("'Just because something works, doesn't mean it can't be improved.' – Shuri (Black Panther, 2018)");
    return $res;
});
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
    $group->get('', function(Request $req, Response $res){
        // alternative is to use views for rendering data to client
        $data = [
            ['name' => 'Spiderman', 'email' => 'spidey@marvel.com' ],
            ['name' => 'Iron Man', 'email' => 'ironman@marvel.com' ]
        ];
        $res->getBody()->write(json_encode($data));
        return $res->withHeader('Content-Type', 'application/json');
    });
    // characters by param
    $group->options('/{nameStartsWith}', function(Request $req, Response $res){
        // alternative is to use views for rendering data to client
        $res->getBody()->write("Return query");
        return $res;
    });
});

