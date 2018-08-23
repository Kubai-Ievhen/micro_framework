<?php
/**
 * Created by PhpStorm.
 * User: smartit-9
 * Date: 30.01.18
 * Time: 15:32
 */

namespace vendor\database;


class DB
{
    private $db;
    private $sql;
    private $p_sql;
    private $p_data;
    private $data;


    public function __construct()
    {
        $this->db = DBBase::init();
    }

    public function setSQL(string $sql){
        $this->sql = $sql;
        $this->data = $this->db->query($this->sql);

        return $this;
    }

    public function setPropertySQL(string $p_sql, array $p_data){
        $this->p_data = $p_data;
        $this->p_sql = $p_sql;
        $this->data = $this->db->queryParam($this->p_sql, $this->p_data);

        return $this;
    }

    public function get(){
        return $this->data;
    }

    public function cleanTable(string $t_name){
        return $this->db->cleanTable($t_name);
    }

    public function deleteID(int $id, string $t_name){
        return $this->db->deleteID($id, $t_name);
    }


}