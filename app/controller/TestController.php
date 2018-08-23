<?php
/**
 * Created by PhpStorm.
 * User: smartit-9
 * Date: 30.01.18
 * Time: 15:35
 */

namespace app\controller;


use vendor\controller\Controller;

class TestController extends Controller
{

    public function getTest(){
        return 'Test';
    }
}