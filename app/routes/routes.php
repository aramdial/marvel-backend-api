<?php
declare(strict_types=1);    // ensure type-safety
// required package namespaces
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app){
    // root
    $app->get('/', function(Request $req, Response $res){
        // alternative is to use views for rendering data to client
        $res->getBody()->write("'Just because something works, doesn't mean it can't be improved.' – Shuri (Black Panther, 2018)");
        return $res;
    });
    //series
    $app->get('/v1/public/series', function(Request $req, Response $res){
        // alternative is to use views for rendering data to client
        $res->getBody()->write("Series!");
        return $res;
    });
    //characters
    $app->get('/v1/public/characters', function(Request $req, Response $res){
        // alternative is to use views for rendering data to client
        $res->getBody()->write("Characters!");
        return $res;
    });
};
