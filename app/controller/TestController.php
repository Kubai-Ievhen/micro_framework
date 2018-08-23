<?php
/**
 * Created by PhpStorm.
 * User: smartit-9
 * Date: 30.01.18
 * Time: 15:35
 */

namespace app\controller;


use vendor\controller\Controller;
use vendor\Request\RequestController;

class TestController extends Controller
{

    public function getTest(){
        $req = RequestController::init();
        var_dump($req);
        return 'Test';
    }
}