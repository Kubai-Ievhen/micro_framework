<?php
/**
 * Created by PhpStorm.
 * User: smartit-9
 * Date: 30.01.18
 * Time: 15:09
 */

namespace vendor\config;


class ConfigController
{
    private $data;
    private static $instance;


    private function __construct()
    {
    }

    public static function init(){
        if (empty(self::$instance)){
            self::$instance = new ConfigController();
            self::$instance->initData();
        }

        return self::$instance;
    }

    public function initData(){
        $this->data = parse_ini_file('../config.ini');
    }

    public function getData(){
        return $this->data;
    }

    public function get($key){
        return $this->data[$key];
    }

}