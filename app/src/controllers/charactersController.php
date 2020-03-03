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
            $sql_characters = $this->link->prepare("SELECT * FROM characters LIMIT 20");
            $sql_characters->execute();
            $sql_url = $this->link->prepare("SELECT type, url from urls WHERE characterId = :characterId");
            $characters = array();
            // retrieve characters
            while($row=$sql_characters->fetch(PDO::FETCH_ASSOC)){
                //store character id
                $this->characterId = $row['id'];
                // assign character obj
                $characters['results'][] = $row;
                // grab urls matching characterId
                $sql_url->execute(array('characterId' => $this->characterId));
                $urls =  array();
                // retrieve urls
                while($row=$sql_url->fetch(PDO::FETCH_ASSOC)){
                    // assign url obj
                    $url = new stdClass();
                    $url->type = $row['type'];
                    $url->url = $row['url'];
                    // combine url array
                    array_push($urls, $url);
                }
                $characters['urls'][] = $urls;
                // array_push($characters, $urls);
            }
            echo json_encode($characters);
            // echo json_encode(array('urls' => $urls)); //---> working urls json

            // echo json_encode($urls);  --> This formats correctly to json
  
        }
        return $res->withHeader('Content-type', 'application/json')->withStatus(200);
    }

    public function listByParam(Request $req, Response $res){


    }
}