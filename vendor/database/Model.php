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
    private   $db;
    public    $t_name      = null;
    protected $sql;
    protected $data;
    public    $BDClass;
    public    $row         = [];
    public    $limit       = false;
    public    $insert      = false;
    public    $insert_data = [];
    public    $update      = false;
    public    $update_data = [];
    public    $offset      = false;
    public    $order_by    = false;
    public    $group_by    = [];
    public    $sorting     = [];
    public    $where       = [];
    public    $or_where    = [];

    public function __construct()
    {
        $this->db = DBBase::init();
        $this->BDClass = new DB();

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

    public function find($id){
        return $this->BDClass->setSQL(SQLClass::find($id, $this->t_name))->get();
    }

    public function getAll(){
        return $this->BDClass->setSQL(SQLClass::selectAll($this->t_name))->get();
    }

    public function deleteId($id){
        return $this->BDClass->deleteID($id, $this->t_name);
    }

    public function deleteAll(){
        return $this->BDClass->cleanTable($this->t_name);
    }

    public function setRow(...$param){
        $this->row = $param;
        return $this;
    }

    public function all(){
        $sql = SQLClass::formSelectQuery($this);
        return $this->BDClass->setSQL($sql)->get();
    }

    public function first(){
        $this->limit(1);
        $sql = SQLClass::formSelectQuery($this);
        return $this->BDClass->setSQL($sql)->get();
    }

    public function limit(int $limit = 10, int $offset = 0){
        $this->limit  = $limit;
        $this->offset = is_null($offset)?false:$offset;
        return $this;
    }

    public function offset(int $offset = 10){
        $this->offset = $offset;
        return $this;
    }

    public function orderBy(string $field = 'id',  string $sorting = 'ASC'){
        $this->order_by = true;
        $this->sorting = [$field, $sorting];
        return $this;
    }

    public function groupBy(string $field){
        $this->group_by[] = $field;
        return $this;
    }

    public function where(string $condition){
        $this->where[] = $condition;
        return $this;
    }

    public function orWhere(string $condition){
        $this->or_where[] = $condition;
        return $this;
    }

    public function insert(array $data){
        $this->insert = true;
        $this->insert_data = $data;
    }

    public function update(array $data){
        $this->update = true;
        $this->update_data = $data;
    }

    public function run(){
        if ($this->insert){
            $sql = SQLClass::formInsertQuery($this);
            return $this->BDClass->setSQL($sql)->get();
        } elseif ($this->update){
            $sql = SQLClass::formUpdateQuery($this);
            return $this->BDClass->setSQL($sql)->get();
        }
    }
}