<?php

 namespace vendor;

use vendor\config\ConfigController;
use vendor\Request\RequestController;
use vendor\Request\RoutController;

class StarterClass
{
    static $request;
    static $route;
    static $config;

    public static function init(){
        self::config();

        self::route();
        self::request();

        self::run();
    }

    private static function request(){
        self::$request = RequestController::init();
    }

    private static function route(){
        self::$route = RoutController::init();
    }

    private static function config(){
        self::$config = ConfigController::init();
    }

    private static function run(){
        self::$route->runClass();
    }


}