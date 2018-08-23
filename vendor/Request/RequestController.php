<?php
/**
 * Created by PhpStorm.
 * User: smartit-9
 * Date: 30.01.18
 * Time: 12:15
 */

namespace vendor\Request;


class RequestController
{
    private $data = array();
    private $method = 'GET';
    private $session_id;
    private static $instance;

    private function __construct()
    {
    }

    public static function init(){
        if (empty(self::$instance)){
            self::$instance = new RequestController();
            self::$instance->initData();
        }
        return self::$instance;
    }

    private function parseData($arr){
        $this->data = array();

        foreach ($arr as $key => $value){
            $this->data[$key] = $value;
        }
    }

    private function initData(){
        $this->session_id = $_COOKIE['PHPSESSID'];

        if (count($_GET)){
            $this->method = 'GET';
            $this->parseData($_GET);
        } elseif (count($_POST)){
            $this->method = 'POST';
            $this->parseData($_POST);
        } else {
            $this->parseData($_REQUEST);
        }
    }

    public function get($key){
        return $this->data[$key]??null;
    }

    public function method(){
        return $this->method;
    }

    public function session_id(){
        return $this->session_id;
    }

    public function is_POST(){
        return $this->method == 'POST';
    }

    public function is_GET(){
        return $this->method == 'GET';
    }

}