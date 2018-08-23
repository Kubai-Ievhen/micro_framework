<?php
/**
 * Created by PhpStorm.
 * User: smartit-9
 * Date: 31.01.18
 * Time: 15:15
 */

namespace vendor\database;


class SQLClass
{
    private static $sql = '';

    private static $model;

    public static function find($id, $t_name){
        return "SELECT * FROM `$t_name` where `id` = $id LIMIT 1";
    }

    public static function selectAll($t_name){
        return "SELECT * FROM $t_name";
    }

    public static function deleteID($t_name, $id){
        return "DELETE FROM `$t_name` WHERE id = $id";
    }

    public static function delete($t_name){
        return "DELETE FROM `$t_name`";
    }

    public static function formSelectQuery(Model $model){
        self::$model = $model;
        self::$sql = 'SELECT';

        self::getRow();

        self::$sql .= ' FROM '.$model->t_name;

        self::where();
        self::orWhere();
        self::orderBy();
        self::groupBy();
        self::limit();
        self::offset();

        return self::$sql;
    }

    public static function formUpdateQuery(Model $model){
        self::$model = $model;
        self::$sql = 'UPDATE';

        self::getRow();

        self::$sql .= ' FROM '.$model->t_name;

        self::where();
        self::orWhere();

        return self::$sql;
    }

    public static function formInsertQuery(Model $model){
        self::$model = $model;
        self::$sql = 'INSERT';

        self::getRow();

        self::$sql .= ' FROM '.$model->t_name;

        return self::$sql;
    }

    private static function getRow(){
        $row = self::$model->row;

        if (is_array($row) && count($row)>0){
            self::$sql .= ' '.implode(",", $row);
        } elseif (is_string($row) && strlen($row)>0){
            self::$sql .= ' '.$row;
        }
    }

    private static function where(){
        $where = self::$model->where;
        $count = count($where);

        if ($count>0){
            if ($count == 1){
                self::$sql .= ' WHERE '.$where[0];
            } else {
                self::$sql .= ' WHERE ('.implode(" AND ", $where).')';
            }

        }
    }

    private static function orWhere(){
        $count_where = count(self::$model->where);
        $count_or_where = count(self::$model->or_where);

        if ($count_or_where > 0){
            if ($count_where == 0){
                self::$sql .= ' WHERE ';
            } else {
                self::$sql .= ' OR ';
            }

            if ($count_or_where == 1){
                self::$sql .= self::$model->or_where[0];
            } else {
                self::$sql .= '('.implode(" OR ", self::$model->or_where).')';
            }
        }

    }

    private static function orderBy(){
        if (self::$model->orde_by){
            self::$sql .= ' ORDER BY ';

            foreach (self::$model->sorting as $value) {
                self::$sql .= $value[0] . ' ' . $value[1];
            }
        }
    }

    private static function groupBy(){
        if (count(self::$model->group_by)> 0){
            self::$sql .= ' GROUP BY '.implode(",", self::$model->group_by);
        }
    }

    private static function limit(){
        if (self::$model->limit && is_numeric(self::$model->limit) && self::$model->limit > 0){
            self::$sql .= ' LIMIT '.self::$model->limit;
        }
    }

    private static function offset(){
        if (self::$model->offset && is_numeric(self::$model->offset) && self::$model->offset > 0){
            self::$sql .= ' LIMIT '.self::$model->offset;
        }
    }
}