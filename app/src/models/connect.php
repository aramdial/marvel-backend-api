<?php 
namespace Marvel\Models;
require_once __DIR__ . '/../../configs/config.php';
use PDO;

class Connect
{
    protected static $instance;

    protected function __construct() {
        $db_info = array(
            "db_host" => HOST,
            "db_user" => USER,
            "db_pass" => PASS,
            "db_name" => DB_NAME,
            "db_charset" => "UTF-8"
        );

        if(empty(self::$instance)) {
            try {
                self::$instance = new PDO('mysql:host='.$db_info['db_host'].';dbname='.$db_info['db_name'], $db_info['db_user'], $db_info['db_pass']);                
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            } catch(PDOException $error) {
                echo $error->getMessage();
            }
        }
    }

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

    public function insert(string $inserts, array $data){
        $stmt = self::$instance->prepare($inserts);
        $execute_result = $stmt->execute($data);
        if($execute_result)
        {   return self::$instance->lastInsertId();  }
        else {  return NULL;   }  
    }

    public function buildInsert(array $data, string $table){
        $str = "INSERT INTO $table (" . implode(',', array_keys($data)) . ") VALUES (:" . implode(',:', array_keys($data)) . ")";
        return $str;
    }

    public function listAll($args){
        if(!empty(self::$instance)) { 
            $list = self::$instance->prepare("
            SELECT * FROM :table LIMIT 20");
            $list->execute(array(
                'table' => args['table']
            ));
            $results = $list->fetchAll(PDO::FETCH_ASSOC);
            return $res->getBody()->write(json_encode($results));
        }
        else{
            return $res->getBody()->write("Cannot retrieve data");
        }
    }

    protected function close(){
        echo "\nClosing connection to database.";
        self::$instance = null;
    }
}