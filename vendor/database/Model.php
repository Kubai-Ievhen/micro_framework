<?php
/**
 * Created by PhpStorm.
 * User: smartit-9
 * Date: 30.01.18
 * Time: 15:29
 */

namespace vendor\database;


class Model
{
    private $db;
    protected $t_name = null;
    protected $sql;
    protected $data;

    public function __construct()
    {
        $this->db = DBBase::init();

        if (is_null($this->t_name)){
            $this->t_name = $this->getTableName();
        }
    }

    private function getTableName(){
        $name = get_class($this);
        $data = explode("\\", $name);
        $name = $data[(count($data)-1)];

        $func = function ($c){
            return "_" . strtolower($c[0]);
        };

        $name =  preg_replace_callback('/([A-Z])/', $func, $name);
        $name =  substr($name,1);
        return $name;
    }


}