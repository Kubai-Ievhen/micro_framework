<?php

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
        $prepare_request->execute($parameters);
        return $prepare_request->fetchAll();
    }

    public function queryPrepare(string $sql, array $parameters){
        $prepare_request = $this->db->prepare($sql);

        foreach ($parameters as $key=>$value){
            $prepare_request->bindParam(":$key", $value);
        }

        $prepare_request->execute($parameters);
        return $prepare_request->execute();
    }

    public function cleanTable(string $t_name){
        return $this->exec(SQLClass::delete($t_name));
    }

    public function deleteID(int $id, string $t_name){
        return $this->exec(SQLClass::deleteID($t_name,$id));
    }
}