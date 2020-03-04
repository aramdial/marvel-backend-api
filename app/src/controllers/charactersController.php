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

    public function fetchCharacterList(){
        if(!empty($this->link)) {
            return Connect::fetchCharacterList();
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

    public function buildResponse(){
        $response = array();
        $characters = $this->fetchCharacterList();
        foreach($characters as $results){
            $characterId = Array('characterId' => $results['id']);
            $thumbnails = $this->fetchThumbnail($characterId);
            // $comics = $this->fetchComics($characterId);
            $events = $this->fetchEvents($characterId);
            $urls = $this->fetchUrls($characterId);
            $comics = $this->fetchComics($characterId);
            $series = $this->fetchSeries($characterId);
            $stories = $this->fetchStories($characterId);
            // combine all data here
            $container = $results + $thumbnails + $comics + $series + $stories + $events + $urls;
            // assign character obj
            $response['results'][] = $container;
        }
        return $response;
    }


    // return list of characters
    public function listAll(Request $req, Response $res){
        if(!empty($this->link)) { 
            // // fetch all characters
            // $result = $this->buildResponse();
            // $res->getBody()->write(json_encode($result));
            // return $res->withHeader('Content-Type', 'application/json');
            $res->getBody()->write("Return query");
        }
        return $res;
    }

    // return list of characters
    public function listByParam(Request $req, Response $res){
        if(!empty($this->link)) { 
            echo "test";
            print_r($req->get('nameStartsWith'));
            // $res->withHeader('Content-Type', 'application/json');
            $res->getBody()->write("Give query");
        }
        return $res;
    }
}