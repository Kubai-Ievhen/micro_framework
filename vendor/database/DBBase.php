<?php
/**
 * Created by PhpStorm.
 * User: smartit-9
 * Date: 30.01.18
 * Time: 15:32
 */

namespace vendor\database;


use vendor\config\ConfigController;

class DBBase
{
    private $db;
    private static $instance;


    private function __construct()
    {
    }

    public static function init(){
        if (empty(self::$instance)){
            self::$instance = new DBBase();
            self::$instance->initDB();
        }
        return self::$instance;
    }

    private function initDB(){
        $config = ConfigController::init();

        $dsn = 'mysql:dbname='.($config->get('DB_DATABASE')).';host='.($config->get('DB_HOST'));

        $this->db = new \PDO($dsn,$config->get('DB_USERNAME'), $config->get('DB_PASSWORD'));
    }

    public function exec($sql){
        $this->db->beginTransaction();
        $result = $this->db->exec($sql);
        $this->db->commit();

        return $result;
    }

    public function query($sql){
        return $this->db->query($sql);
    }

    public function queryParam(string $sql, array $parameters){
        $prepare_request = $this->db->prepare($sql);
        return $prepare_request->execute($parameters);
    }
}