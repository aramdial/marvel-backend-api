<?php 
namespace Marvel\Controllers;
use PDO;
use Marvel\Models\Connect as Connect;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CharactersController {
    protected $link;

    public function __construct(){
        $this->link = Connect::getInstance();
    }

    // return list of characters
    public function listAll(Request $req, Response $res){
        if(!empty($this->link)) { 
            $query = $this->link->prepare("
            SELECT * FROM characters LIMIT 20");
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            // $characters = var_dump(json_encode($results));
            $characters = var_dump(json_encode($results));
        }
        return $res->withHeader('Content-type', 'application/json')->withStatus(200);
    }

    public function listByParam(Request $req, Response $res){


    }
}