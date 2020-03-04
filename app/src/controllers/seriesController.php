<?php 
namespace Marvel\Controllers;
use PDO;
use Marvel\Models\Connect as Connect;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SeriesController {
    protected $link;
    protected $seriesId;

    public function __construct(){
        $this->link = Connect::getInstance();
    }

    //fetch list of series
    public function fetchSeriesList($param){
        if(!empty($this->link)) {
            return Connect::fetchSeriesList($param);
        }
        return NULL;
    }

    public function fetchThumbnail($args){
        if(!empty($this->link)) { 
            $sql = "SELECT path, extension from thumbnails WHERE seriesId = :seriesId";
            return Connect::fetchThumbnail($sql, $args);
         }
         return NULL;
    }

    public function fetchUrls($args){
        if(!empty($this->link)) { 
            $sql = "SELECT type, url from urls WHERE seriesId = :seriesId";
            return Connect::fetchUrls($sql, $args);
        }
        return NULL;
    }

    public function fetchComics($args){
        if(!empty($this->link)) { 
            $sql_list = "SELECT * from comic_list WHERE seriesId = :seriesId LIMIT 20";
            $sql_summary = "SELECT resourceURI, name from comic_summary where listId = :listId LIMIT 20";
            return Connect::fetchComics($sql_list, $sql_summary, $args);           
        }
        return NULL;
    }

    public function fetchSeries($args){
        if(!empty($this->link)) { 
            $sql_list = "SELECT * from series_list WHERE seriesId = :seriesId LIMIT 20";
            $sql_summary = "SELECT resourceURI, name from series_summary where listId = :listId LIMIT 20";
            return Connect::fetchSeries($sql_list, $sql_summary, $args);       
        }
        return NULL;
    }

    public function fetchStories($args){
        if(!empty($this->link)) { 
            $sql_list = "SELECT * from story_list WHERE seriesId = :seriesId LIMIT 20";
            $sql_summary = "SELECT resourceURI, name, type from story_summary where listId = :listId LIMIT 20";
            return Connect::fetchStories($sql_list, $sql_summary, $args);   
        }
        return NULL;
    }

    public function fetchCreators($args){
        if(!empty($this->link)) { 
            $sql_list = "SELECT * from creator_list WHERE seriesId = :seriesId LIMIT 20";
            $sql_summary = "SELECT resourceURI, name from creator_list where listId = :listId LIMIT 20";
            return Connect::fetchCreators($sql_list, $sql_summary, $args); 
        }
        return NULL;
    }

    public function fetchCharacters($args){
        if(!empty($this->link)) { 
            $sql_list = "SELECT * from character_list WHERE seriesId = :seriesId LIMIT 20";
            $sql_summary = "SELECT resourceURI, name, role from character_summary where listId = :listId LIMIT 20";
            return Connect::fetchCharacters($sql_list, $sql_summary, $args); 
        }
        return NULL;
    }

    public function fetchEvents($args){
        if(!empty($this->link)) { 
            $sql_list = "SELECT * from event_list WHERE seriesId = :seriesId LIMIT 20";
            $sql_summary = "SELECT resourceURI, name from event_summary where listId = :listId LIMIT 20";
            return Connect::fetchEvents($sql_list, $sql_summary, $args); 
        }
        return NULL;
    }

    public function responseWithParam($param){
        $response = array();
        $container = array();
        $m_series = $this->fetchSeriesList($param);
        foreach($m_series as $results){
            $seriesId = Array('seriesId' => $results['id']);
            $thumbnails = $this->fetchThumbnail($seriesId);
            $events = $this->fetchEvents($seriesId);
            $urls = $this->fetchUrls($seriesId);
            $comics = $this->fetchComics($seriesId);
            $series = $this->fetchSeries($seriesId);
            $stories = $this->fetchStories($seriesId);
            $characters = $this->fetchCharacters($seriesId);
            $creators = $this->fetchCreators($seriesId);
            // combine all data here
            $container[] = $results + $urls + $thumbnails + $creators + $characters + $stories + $comics + $events + $series;
            // assign series obj
        }
        $response["data"] = array(
            'offset' => 0,
            'limit' => 20,
            'total' => count($m_series),
            'count' => count($m_series),
            'results' => $container
        );
        return $response;
    }


    // return list of series
    public function listAll(Request $req, Response $res){
        if(!empty($this->link)) { 
            // // fetch all series
            $params = $req->getQueryParams();
            if (isset($params['titleStartsWith'])){
                $param = $params['titleStartsWith'];
                if ((preg_match('/[a-zA-Z]/', $param) && strlen($param) == 1)){
                    $result = $this->responseWithParam($param);
                    $res->withHeader('Content-Type', 'application/json');
                    $res->getBody()->write(json_encode($result));
                }else{
                    $res->getBody()->write(json_encode(array('Error' => "Invalid entry for 'titleStartsWith' parameter.")));
                }
            }else {
                $res->getBody()->write(json_encode(array('Error' => "Missing parameter 'titleStartsWith'.")));
            }          
        }
        $res->withHeader('Content-Type', 'application/json');
        return $res;
    }
}