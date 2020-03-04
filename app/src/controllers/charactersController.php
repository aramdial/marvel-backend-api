<?php 
namespace Marvel\Controllers;
use PDO;
use Marvel\Models\Connect as Connect;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CharactersController {
    protected $link;
    protected $characterId;

    public function __construct(){
        $this->link = Connect::getInstance();
    }

    public function fetchCharacterList($param){
        if(!empty($this->link)) {
            return Connect::fetchCharacterList($param);
        }
        return NULL;
    }

    public function fetchThumbnail($args){
        if(!empty($this->link)) { 
            $sql = "SELECT path, extension from thumbnails WHERE characterId = :characterId";
            return Connect::fetchThumbnail($sql, $args);
         }
         return NULL;
    }

    public function fetchUrls($args){
        if(!empty($this->link)) { 
            $sql = "SELECT type, url from urls WHERE characterId = :characterId";
            return Connect::fetchUrls($sql, $args);
        }
        return NULL;
    }

    public function fetchComics($args){
        if(!empty($this->link)) { 
            $sql_list = "SELECT * from comic_list WHERE characterId = :characterId LIMIT 20";
            $sql_summary = "SELECT resourceURI, name from comic_summary where listId = :listId LIMIT 20";
            return Connect::fetchComics($sql_list, $sql_summary, $args);           
        }
        return NULL;
    }

    public function fetchSeries($args){
        if(!empty($this->link)) { 
            $sql_list = "SELECT * from series_list WHERE characterId = :characterId LIMIT 20";
            $sql_summary = "SELECT resourceURI, name from series_summary where listId = :listId LIMIT 20";
            return Connect::fetchSeries($sql_list, $sql_summary, $args);       
        }
        return NULL;
    }

    public function fetchStories($args){
        if(!empty($this->link)) { 
            $sql_list = "SELECT * from story_list WHERE characterId = :characterId LIMIT 20";
            $sql_summary = "SELECT resourceURI, name, type from story_summary where listId = :listId LIMIT 20";
            return Connect::fetchStories($sql_list, $sql_summary, $args);   
        }
        return NULL;
    }

    public function fetchEvents($args){
        if(!empty($this->link)) { 
            $sql_list = "SELECT * from event_list WHERE characterId = :characterId LIMIT 20";
            $sql_summary = "SELECT resourceURI, name from event_summary where listId = :listId LIMIT 20";
            return Connect::fetchEvents($sql_list, $sql_summary, $args); 
        }
        return NULL;
    }

    public function responseWithParam($param){
        $response = array();
        $container = array();
        $m_characters = $this->fetchCharacterList($param);
        foreach($m_characters as $results){
            $characterId = Array('characterId' => $results['id']);
            $thumbnails = $this->fetchThumbnail($characterId);
            $events = $this->fetchEvents($characterId);
            $urls = $this->fetchUrls($characterId);
            $comics = $this->fetchComics($characterId);
            $series = $this->fetchSeries($characterId);
            $stories = $this->fetchStories($characterId);
            // combine all data here
            $container[] = $results + $thumbnails + $comics + $series + $stories + $events + $urls;
            // assign character obj
        }
        $response["data"] = array(
            'offset' => 0,
            'limit' => 20,
            'total' => count($m_characters),
            'count' => count($m_characters),
            'results' => $container
        );
        return $response;
    }

    // return list of characters
    public function listAll(Request $req, Response $res){
        if(!empty($this->link)) { 
            $params = $req->getQueryParams();
            if (isset($params['nameStartsWith'])){
                $param = $params['nameStartsWith'];
                if ((preg_match('/[a-zA-Z]/', $param) && strlen($param) == 1)){
                    $result = $this->responseWithParam($param);
                    $res->getBody()->write(json_encode($result));
                }else{
                    $res->getBody()->write(json_encode(array('Error' => "Invalid entry for 'nameStartsWith' parameter.")));
                }
            }else {
                $res->getBody()->write(json_encode(array('Error' => "Missing parameter 'nameStartsWith'.")));
            }          
        }
        $res->withHeader('Content-Type', 'application/json');
        return $res;
    }
}