<?php

namespace vendor\Request;

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

        if (class_exists($this->class) && method_exists($this->class, $metod)) {
            $result = call_user_func([$this->class, $metod]);
            echo json_encode($result);

            return;
        }

        header("HTTP/1.0 404 Not Found");
        return;
    }
}