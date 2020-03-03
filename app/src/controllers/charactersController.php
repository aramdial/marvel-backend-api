<?php 
namespace Marvel\Controllers;
use PDO;
use Marvel\Models\Connect as Connect;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \stdClass;

class CharactersController {
    protected $link;
    protected $characterId;

    public function __construct(){
        $this->link = Connect::getInstance();
    }

    // return list of characters
    public function listAll(Request $req, Response $res){
        if(!empty($this->link)) { 
            $sql_characters = $this->link->prepare("SELECT * FROM characters Order by id ASC LIMIT 20");
            $sql_characters->execute();
            $sql_url = $this->link->prepare("SELECT type, url from urls WHERE characterId = :characterId");
            $characters = array();
            // retrieve characters
            while($row=$sql_characters->fetch(PDO::FETCH_ASSOC)){
                //store character id
                $this->characterId = $row['id'];
                // grab urls matching characterId
                $sql_url->execute(array('characterId' => $this->characterId));
                $urls =  array();
                // retrieve urls
                while($url_row=$sql_url->fetch(PDO::FETCH_ASSOC)){
                    // assign and populate url obj
                    $urls['urls'][] = $url_row;
                }
                $container = $row + $urls;
                  // assign character obj
                $characters['results'][] = $container;
            }
            echo json_encode($characters);
        }
        return $res->withHeader('Content-type', 'application/json')->withStatus(200);
    }

    public function listByParam(Request $req, Response $res){


    }
}