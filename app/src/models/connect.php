<?php 
namespace Marvel\Models;
require __DIR__ . '/../../configs/config.php';
use PDO;
use \stdClass;

class Connect
{
    protected static $instance;

    protected function __construct() {
        $db_info = array(
            "db_host" => HOST,
            "db_user" => USER,
            "db_pass" => PASS,
            "db_name" => DB_NAME
        );

        if(empty(self::$instance)) {
            try {
                // instantiate PDO mysql instance
                self::$instance = new PDO('mysql:host='.$db_info['db_host'].';dbname='.$db_info['db_name'], $db_info['db_user'], $db_info['db_pass']);                
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            } catch(PDOException $error) {
                echo $error->getMessage();
            }
        }
    }

    /**
     * Instantiate PDO connection to mysql database
     */
    public static function getInstance() {
        if(empty(self::$instance)) {
            try {
                new Connect();
                //var_dump(self::$instance);
            } catch(PDOException $error) {
                echo $error->getMessage();
            }
        }
        //var_dump(self::$instance);
        return self::$instance;
    } 

    protected static function close(){
        echo "\nClosing connection to database.";
        self::$instance = null;
    }

    /**
     * Use to fetch characters or series
     */

    public static function fetchCharacterList(){
        if(!empty(self::$instance)) { 
            // prepare sql statements
            $sql = "SELECT * FROM characters Order by id ASC LIMIT 20";
            $characters = self::$instance->prepare($sql);
            $characters->execute();
            return $characters->fetchAll();
        }
        return NULL;
    }

    public static function fetchSeriesList(){
        if(!empty(self::$instance)) { 
            // prepare sql statements
            $sql = "SELECT * FROM series Order by id ASC LIMIT 20";
            $series = self::$instance->prepare($sql);
            $series->execute();
            return $series->fetchAll();
        }
        return NULL;
    }

    /**
     * Below methods retrieve Marvel response objects
     * [source] developer.marvel.com
     */
    public static function fetchThumbnail($sql, $args){
        if(!empty(self::$instance)) { 
           $thumbnail = Array();
            $sql_thumbnail = self::$instance->prepare($sql);
            $sql_thumbnail->execute($args);
            // retrieve thumbnails
            while($thumb_row=$sql_thumbnail->fetch()){
                $thumbnail['thumbnail'] = $thumb_row;
            }
            return $thumbnail;
        }
        return NULL;
    }

    public static function fetchUrls($sql, $args){
        if(!empty(self::$instance)) { 
            $urls = Array();
            $sql_url = self::$instance->prepare($sql);
            $sql_url->execute($args);
            // retrieve urls
            while($url_row=$sql_url->fetch()){
                // assign and populate url obj
                $urls['urls'][] = $url_row;
            }
            return $urls;
        }
        return NULL;
    }

    public static function fetchComics($sql_list, $sql_summary, $args){
        if(!empty(self::$instance)) { 
            $comics = array();
            $comic_summary = array();
            // perform db query
            $sql_comics = self::$instance->prepare($sql_list);
            $sql_comics->execute($args);
            $sql_comics_summ = self::$instance->prepare($sql_summary);
            // retrieve comics
            while($comic_row=$sql_comics->fetch()){
                // get foreign key value - items list 
                print_r($comic_row);
                $sql_comics_summ->execute(array('listId' => $comic_row["comicListId"]));
                $summ = new stdClass();
                $summ->available = $comic_row["available"];
                $summ->collectionURI = $comic_row["collectionURI"];
                while($comic_summ_row=$sql_comics_summ->fetch()){
                    $comic_summary[] = $comic_summ_row;
                }
                $summ->items = $comic_summary;
                $summ->returned = $comic_row["returned"];
                $comics['comics'] = $summ;
            }
            return $comics;
        }
        return NULL;
    }

    public static function fetchSeries($sql_list, $sql_summary, $args){
        if(!empty(self::$instance)) { 
            $series = array();
            $series_summary = array();
            $sql_series = self::$instance->prepare($sql_list);
            $sql_series->execute($args);
            $sql_series_summ = self::$instance->prepare($sql_summary);
            // retrieve series + sub lists
            while($series_row=$sql_series->fetch()){
                // get foreign key value - items list 
                $sql_series_summ->execute(array('listId' => $series_row["seriesListId"]));
                $summ = new stdClass();
                $summ->available = $series_row["available"];
                $summ->collectionURI = $series_row["collectionURI"];
                while($series_summ_row=$sql_series_summ->fetch()){
                    $series_summary[] = $series_summ_row;
                }
                $summ->items = $series_summary;
                $summ->returned = $series_row["returned"];
                $series['series'] = $summ;
            }
            return $series;    
        }
        return NULL;
    }

    public static function fetchStories($sql_list, $sql_summary, $args){
        if(!empty(self::$instance)) { 
            $stories = array();
            $story_summary = array();
            $sql_story = self::$instance->prepare($sql_list);
            $sql_story->execute($args);
            $sql_story_summ = self::$instance->prepare($sql_summary);
            // retrieve story + sub lists
            while($story_row=$sql_story->fetch()){
                // get foreign key value - items list 
                $sql_story_summ->execute(array('listId' => $story_row["storyListId"]));
                $summ = new stdClass();
                $summ->available = $story_row["available"];
                $summ->collectionURI = $story_row["collectionURI"];
                while($story_summ_row=$sql_story_summ->fetch()){
                    $story_summary[] = $story_summ_row;
                }
                $summ->items = $story_summary;
                $summ->returned = $story_row["returned"];
                $stories['stories'] = $summ;
            }
            return $stories;    
        }
        return NULL;
    }

    public static function fetchEvents($sql_list, $sql_summary, $args){
        if(!empty(self::$instance)) { 
            $events = array();
            $event_summary = array();
            $sql_events = self::$instance->prepare($sql_list);
            $sql_events->execute($args);
            $sql_event_summ = self::$instance->prepare($sql_summary);
            // retrieve events + sub lists
            while($event_row=$sql_events->fetch()){
                // get foreign key value - items list 
                $sql_event_summ->execute(array('listId' => $event_row["eventListId"]));
                $summ = new stdClass();
                $summ->available = $event_row["available"];
                $summ->collectionURI = $event_row["collectionURI"];
                while($event_summ_row=$sql_event_summ->fetch()){
                    $event_summary[] = $event_summ_row;
                }
                $summ->items = $event_summary;
                $summ->returned = $event_row["returned"];
                $events['events'] = $summ;
            }
            return $events;
        }
        return NULL;
    }

    public static function fetchCreators($sql_list, $sql_summary, $args){
        if(!empty(self::$instance)) { 
            $creators = array();
            $creator_summary = array();
            $sql_creator = self::$instance->prepare($sql_list);
            $sql_creator->execute($args);
            $sql_creator_summ = self::$instance->prepare($sql_summary);
            // retrieve creators + sub lists
            while($creator_row=$sql_creators->fetch()){
                // get foreign key value - items list 
                $sql_creator_summ->execute(array('listId' => $creator_row["creatorListId"]));
                $summ = new stdClass();
                $summ->available = $creator_row["available"];
                $summ->collectionURI = $creator_row["collectionURI"];
                while($creator_summ_row=$sql_creator_summ->fetch()){
                    $creator_summary[] = $creator_summ_row;
                }
                $summ->items = $creator_summary;
                $summ->returned = $creator_row["returned"];
                $creators['creators'] = $summ;
            }
            return $creators;
        }
        return NULL;
    }

    public static function fetchCharacters($sql_list, $sql_summary, $args){
        if(!empty(self::$instance)) { 
            $characters = array();
            $character_summary = array();
            $sql_character = self::$instance->prepare($sql_list);
            $sql_character->execute($args);
            $sql_event_summ = self::$instance->prepare($sql_summary);
            // retrieve characters + sub lists
            while($character_row=$sql_characters->fetch()){
                // get foreign key value - items list 
                $sql_character_summ->execute(array('listId' => $character_row["characterListId"]));
                $summ = new stdClass();
                $summ->available = $character_row["available"];
                $summ->collectionURI = $character_row["collectionURI"];
                while($character_summ_row=$sql_character_summ->fetch()){
                    $character_summary[] = $character_summ_row;
                }
                $summ->items = $character_summary;
                $summ->returned = $character_row["returned"];
                $characters['characters'] = $summ;
            }
            return $characters;
        }
        return NULL;
    }
}