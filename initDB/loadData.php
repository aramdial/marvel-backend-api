<?php 

/**
 * This is a script I created separately from the api project to help me load data dynamically from the marvel api 
 * found on developer.marvel.com. I created this script as a fast, light-weight feel of the data and workflow of the project.
 * You will see more organized and refactored code in my api app.
 */

class LoadData{
    private $host = '127.0.0.1';
    private $name = 'marvel';
    private $user = 'root';
    private $pw = 'secret';
    protected $link;

    public function __construct(){
        try{
            $this->link = new PDO("mysql:host=".$this->host.";dbname=".$this->name,$this->user, $this->pw);
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected to database.\n";
            return $this->link;
        } catch (PDOException $e) {
            echo 'Connection to database failed: ' . $e->getMessage();
        }
    }

    function insert(string $inserts, array $data){
        $stmt = $this->link->prepare($inserts);
        $execute_result = $stmt->execute($data);
        if($execute_result)
        {   return $this->link->lastInsertId();  }
        else {  return NULL;   }  
    }

    function buildInsert(array $data, string $table){
        $str = "INSERT INTO $table (" . implode(',', array_keys($data)) . ") VALUES (:" . implode(',:', array_keys($data)) . ")";
        return $str;
    }

    function __destruct(){
        echo "\nClosing connection to database.";
        $this->link = null;
    }

    public function loadData(){
        if(!empty($this->link)) { 
            $apiReq = new MarvelApi($config);
            $param = ['characters', 'series'];
            $limit = rand(1,5);
            foreach(range('a','z') as $letter){
                foreach ($param as $type){
                    $response = $apiReq->requestData($limit, $type, $letter); 
                    // convert json string to assoc array
                    $json = json_decode($response, true);
                    if ($json["code"] == 200){
                        if ($type == 'characters'){
                            marvelCharacterResponse($json);
                        }
                        else if ($type == 'series'){
                            marvelSeriesResponse($json);
                        }
                    }
                    else {  echo "\nUnable to parse object\n";  }
                }
            }
            echo 'Loading data into database complete.';
        }
    }


    function marvelSeriesResponse(array $json){
        if (isset($this->link)){
            $results = $json['data']['results'];
            // echo var_dump($results);
            foreach ($results as $series) {
                # --------------- SERIES ----------------
                $seriesId = $series['id'];
                $data_series = array(
                'id' => $seriesId,
                'title' => $series['title'],
                'description' => $series['description'],
                'resourceURI'=> $series['resourceURI'],
                'startYear'=> $series['startYear'],
                'endYear'=> $series['endYear'],
                'rating'=> $series['rating'],
                'modified'=> $series['modified'],
                ); 
                $insert = $this->link->buildInsert($data_series, 'series');
                $this->link->insert($insert, $data_series);
                # -------------------- URLS ------------------
                foreach ($series['urls'] as $url){
                    $data_url = array (
                        'type' => $url['type'],
                        'url' => $url['url'],
                        'seriesId' => $seriesId
                    );
                    $insert = $this->link->buildInsert($data_url, 'urls');
                    $this->link->insert($insert, $data_url);
                }
                # ---------------- THUMBNAIL ----------------
                $data_thumbnail = array (
                    'path' => $series['thumbnail']['path'],
                    'extension' => $series['thumbnail']['extension'],
                    'seriesId' => $seriesId
                    );
                    $insert = $this->link->buildInsert($data_thumbnail, 'thumbnails');
                    $this->link->insert($insert, $data_thumbnail);
                # ------------------ CREATOR ------------------
                $data_creator = array (
                    'available'=> $series['creators']['available'],
                    'returned'=> $series['creators']['returned'],
                    'collectionURI'=> $series['creators']['collectionURI'],
                    'seriesId'=> $seriesId
                );
                $insert = $this->link->buildInsert($data_creator, 'creator_list');
                $creatorlistId = $this->link->insert($insert, $data_creator);
                # ------------- CREATOR SUMMARY ----------------
                foreach ($series['creators']['items'] as $item){
                    $data_creator_summary = array(
                        'resourceURI'=> $item['resourceURI'],
                        'name'=> $item['name'],
                        'role' => $item['role'],
                        'listId'=> $creatorlistId
                    );
                    $insert = $this->link->buildInsert($data_creator_summary, 'creator_summary');
                    $this->link->insert($insert, $data_creator_summary);
                }
                # ------------------ CHARACTER ------------------
                $data_character = array (
                    'available'=> $series['characters']['available'],
                    'returned'=> $series['characters']['returned'],
                    'collectionURI'=> $series['characters']['collectionURI'],
                    'seriesId'=> $seriesId
                );
                $insert = $this->link->buildInsert($data_character, 'character_list');
                $characterlistId = $this->link->insert($insert, $data_character);
                # ------------- CHARACTER SUMMARY ----------------
                foreach ($series['characters']['items'] as $item){
                    $data_character_summary = array(
                        'resourceURI'=> $item['resourceURI'],
                        'name'=> $item['name'],
                        'listId'=> $characterlistId
                    );
                    $insert = $this->link->buildInsert($data_character_summary, 'character_summary');
                    $this->link->insert($insert, $data_character_summary);
                }
                # ------------------ STORY ------------------
                $data_story = array (
                    'available'=> $series['stories']['available'],
                    'returned'=> $series['stories']['returned'],
                    'collectionURI'=> $series['stories']['collectionURI'],
                    'seriesId'=> $seriesId
                );
                $insert = $this->link->buildInsert($data_story, 'story_list');
                $storylistId = $this->link->insert($insert, $data_story);
                # ------------- STORY SUMMARY ----------------
                foreach ($series['stories']['items'] as $item){
                    $data_story_summary = array(
                        'resourceURI'=> $item['resourceURI'],
                        'name'=> $item['name'],
                        'listId'=> $storylistId
                    );
                    $insert = $this->link->buildInsert($data_story_summary, 'story_summary');
                    $this->link->insert($insert, $data_story_summary);
                }
                # ------------------ COMIC ------------------
                $data_comic = array (
                    'available'=> $series['comics']['available'],
                    'returned'=> $series['comics']['returned'],
                    'collectionURI'=> $series['comics']['collectionURI'],
                    'seriesId'=> $seriesId
                );
                $insert = $this->link->buildInsert($data_comic, 'comic_list');
                $comiclistId = $this->link->insert($insert, $data_comic);
                # ------------- COMIC SUMMARY ----------------
                foreach ($series['comics']['items'] as $item){
                    $data_story_summary = array(
                        'resourceURI'=> $item['resourceURI'],
                        'name'=> $item['name'],
                        'listId'=> $storylistId
                    );
                    $insert = $this->link->buildInsert($data_story_summary, 'story_summary');
                    $this->link->insert($insert, $data_story_summary);
                }
                # ------------------ EVENT ------------------
                $data_event = array (
                    'available'=> $series['events']['available'],
                    'returned'=> $series['events']['returned'],
                    'collectionURI'=> $series['events']['collectionURI'],
                    'seriesId'=> $seriesId
                );
                $insert = $this->link->buildInsert($data_event, 'event_list');
                $eventlistId = $this->link->insert($insert, $data_event);
                # ------------- EVENT SUMMARY ----------------
                foreach ($series['events']['items'] as $item){
                    $data_event_summary = array(
                        'resourceURI'=> $item['resourceURI'],
                        'name'=> $item['name'],
                        'listId'=> $eventlistId
                    );
                    $insert = $this->link->buildInsert($data_event_summary, 'event_summary');
                    $this->link->insert($insert, $data_event_summary);
                }
                echo "\nInserted series [$seriesId]\n";
            }
        }
    }

    function marvelCharacterResponse(array $json){
        if (isset($this->link)){
            $results = $json['data']['results'];
            // echo var_dump($results);
            foreach ($results as $character) {
                # --------------- CHARACTER ----------------
                $characterId = $character['id'];
                $data_character = array(
                'id' => $characterId,
                'name' => $character['name'],
                'description' => $character['description'],
                'modified' => $character['modified'],
                'resourceURI'=> $character['resourceURI']
                );
                $insert = $this->link->buildInsert($data_character, 'characters');
                $this->link->insert($insert, $data_character);
                // echo var_dump($data_character);
                # ---------------- THUMBNAIL ----------------
                $data_thumbnail = array (
                'path' => $character['thumbnail']['path'],
                'extension' => $character['thumbnail']['extension'],
                'characterId' => $characterId
                );
                $insert = $this->link->buildInsert($data_thumbnail, 'thumbnails');
                $this->link->insert($insert, $data_thumbnail);
                # ------------------ COMIC ------------------
                $data_comic = array (
                    'available'=> $character['comics']['available'],
                    'returned'=> $character['comics']['returned'],
                    'collectionURI'=> $character['comics']['collectionURI'],
                    'characterId'=> $characterId
                );
                $insert = $this->link->buildInsert($data_comic, 'comic_list');
                $comiclistId = $this->link->insert($insert, $data_comic);
                # ------------- COMIC SUMMARY ----------------
                foreach ($character['comics']['items'] as $item){
                    $data_comic_summary = array(
                        'resourceURI'=> $item['resourceURI'],
                        'name'=> $item['name'],
                        'listId'=> $comiclistId
                    );
                    $insert = $this->link->buildInsert($data_comic_summary, 'comic_summary');
                    $this->link->insert($insert, $data_comic_summary);
                }
                # ------------------ SERIES ------------------
                $data_series = array(
                    'available' => $character['series']['available'],
                    'returned' => $character['series']['returned'],
                    'collectionURI' => $character['series']['collectionURI'],
                    'characterId' => $characterId
                );
                $insert = $this->link->buildInsert($data_series, 'series_list');
                $seriesListId = $this->link->insert($insert, $data_series);
                # -------------- SERIES SUMMARY --------------
                foreach ($character['series']['items'] as $item){
                    $data_series_summary = array(
                        'resourceURI' => $item['resourceURI'],
                        'name' => $item['name'],
                        'listId' => $seriesListId
                    );
                    $insert = $this->link->buildInsert($data_series_summary, 'series_summary');
                    $this->link->insert($insert, $data_series_summary);
                }
                # ------------------ STORY--------------------
                $data_story = array(
                    'available' => $character['stories']['available'],
                    'returned' => $character['stories']['returned'],
                    'collectionURI' => $character['stories']['collectionURI'],
                    'characterId' => $characterId
                );
                $insert = $this->link->buildInsert($data_story, 'story_list');
                $storyListId = $this->link->insert($insert, $data_story);
                # --------------- STORY SUMMARY --------------
                foreach ($character['stories']['items'] as $item){
                    $data_story_summary = array (
                        'resourceURI' => $item['resourceURI'],
                        'name' => $item['name'],
                        'type' => $item['type'],
                        'listId' => $storyListId
                    );
                    $insert = $this->link->buildInsert($data_story_summary, 'story_summary');
                    $this->link->insert($insert, $data_story_summary);
                }
                # ------------------- EVENT ------------------
                $data_event = array (
                    'available' => $character['events']['available'],
                    'returned' => $character['events']['returned'],
                    'collectionURI' => $character['events']['collectionURI'],
                    'characterId' => $characterId
                );
                $insert = $this->link->buildInsert($data_event, 'event_list');
                $eventListId = $this->link->insert($insert, $data_event);
                # ---------------- EVENT SUMMARY -------------
                foreach ($character['events']['items'] as $item){
                    $data_event_summary = array(
                        'resourceURI' => $item['resourceURI'],
                        'name' => $item['name'],
                        'listId' => $eventListId
                    );
                    $insert = $this->link->buildInsert($data_event_summary, 'event_summary');
                    $this->link->insert($insert, $data_event_summary);
                }
                # -------------------- URLS ------------------
                foreach ($character['urls'] as $url){
                    $data_url = array (
                        'type' => $url['type'],
                        'url' => $url['url'],
                        'characterId' => $characterId
                    );
                    $m_url = new urls($data_url);
                    $insert = $this->link->buildInsert($data_url, 'urls');
                    $this->link->insert($insert, $data_url);
                }
                echo "\nInserted Character [$characterId]\n";
            }
        }
    }
}

$load = new LoadData();
$load->loadData();