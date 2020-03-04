<?php

/**
 * I created this script to create a hash with my requests and get a feel of the data and 
 * how the api operates before working on the assigned backend project.
 */

class MarvelApi {     
    private $apiKey;
    private $privateKey;
    private $baseURL;

    function __constructor($parameters = array()){
        foreach($parameters as $key => $value) {
            $this->$key = $value;
        }
    }

    // create request to marvel api and retrieve json response
    function requestData($type, $limit, $letter) {
        // get timestamp
        $ts = time();
        // build hash
        $hash = getHash();
        // build query params
        $query = array(
        'apikey' => $this->apiKey,
        'ts' => $ts,
        'hash' => $hash,
        'limit' => $limit
        );
        $url = $this->baseURL . buildUrl($type) . $letter . '&' . http_build_query($query);
        // // echo $url;
        //   // use key 'http' even if you send the request to https://...
        // $arrContextOptions=array(
        //     "ssl"=>array(
        //             "verify_peer"=>false,
        //             "verify_peer_name"=>false,
        //     ),
        // );
        // send request
        $response = file_get_contents($url);
        // retrieve json
        return $response;
    }

    // create hash (timestamp + privateKey + publicKey)
    function getHash($ts, $privateKey, $apiKey){
            return md5($ts . $privateKey . $apiKey);
    }

    function buildUrl(string $type){
        // filter by type
        if ($type == 'characters'){
            // build request 
            return "/v1/public/" . $type . '?' . 'nameStartsWith=';
        }
        else if ($type == 'series') {
        // build request 
        return "/v1/public/" . $type . '?' . 'titleStartsWith=';
        }   
    }
}
