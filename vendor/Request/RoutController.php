<?php
/**
 * Created by PhpStorm.
 * User: smartit-9
 * Date: 30.01.18
 * Time: 13:42
 */

namespace vendor\Request;


use app\controller\TestController;

class RoutController
{
    private $class;
    private $metod;
    private static $instance;


    private function __construct()
    {
    }

    public static function init(){
        if (empty(self::$instance)){
            self::$instance = new RoutController();
            self::$instance->parseURL();
        }
        return self::$instance;
    }

    private function parseURL(){
        $data = explode("/", $_SERVER['REDIRECT_URL']);

        $this->class = 'app\controller\\'.ucfirst(strtolower($data[1])).'Controller';
        $this->metod = 'get'.ucfirst(strtolower($data[2]));
    }

    public function runClass(){
        $metod = $this->metod;

        $class = new $this->class();
        $result = $class->$metod();

        echo json_encode($result);
    }
}