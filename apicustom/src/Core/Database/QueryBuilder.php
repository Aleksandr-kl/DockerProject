<?php

namespace App\Core\Database;
class QueryBuilder
{
    protected $params;
    protected $type;
    protected $fields;
    protected $table;
    protected $where;
    protected $join = [];
    protected $into;

    public function __construct()
    {
        $this->params = [];
    }

    public function select($fields = "*"): self
    {
        $this->type = "select";
        $field_string = $fields;
        if (is_array($fields)) {
            $field_string = implode(",", $fields);
        }
        $this->fields = $field_string;
        return $this;
    }


    public function update($values)
    {
        $this->type = "update";
        $update_parts = [];
        $update_parts[] = "date=:date";
        $this->params['date'] = date("Y-m-d H:i:s");
        foreach ($values as $key => $value) {
            $update_parts[] = "{$key}=:{$key}";
            $this->params[$key] = $value;
        }
        $this->fields = implode(",", $update_parts);
        return $this;
    }

    public function delete()
    {
        $this->type = "delete";
        return $this;

    }

    public function from($table)
    {
        $this->table = $table;
        return $this;

    }

    public function into($table)
    {
        $this->table = $table;
        return $this;
    }
    public function insert($table)
    {

    }
    public
    function getSql()
    {
        switch ($this->type) {
            case 'select':
                $sql = "SELECT {$this->fields} FROM {$this->table}";
                if (!empty($this->where)) {
                    $sql .= " WHERE {$this->where}";
                }
                if (!empty($this->join)) {
                    $sql .= ' ' . implode(' ', $this->join);
                }
                return $sql;
                break;
            case 'update':
                $sql = "UPDATE {$this->table} SET {$this->fields}"
                    . (!empty($this->where) ? " WHERE {$this->where}" : "");
                return $sql;
                break;

            case 'delete':
                $sql = "DELETE FROM {$this->table}";
                if (!empty($this->where)) {
                    $sql .= " WHERE {$this->where}";
                }
                return $sql;
                break;

            case 'insert':
                $fields_list=array_keys($this->params);
                $fields_string=implode(', ',$fields_list);
                $values_list=array_values($this->params);
                $values_string=implode('\', \'',$values_list);
                $sql="INSERT INTO  {$this->table} ({$fields_string}) VALUES ('{$values_string}')";
                $this->params=[];
                return $sql;

                break;

        }
    }


    public
    function where($where)
    {
        /*if(is_a($where)){

        }*/
        $where_string = "";
        $where_parts = [];
        foreach ($where as $key => $value) {

            $where_parts[] = "{$key}=:{$key}";
            $this->params[$key] = $value;

        }
        $this->where = implode(' AND ', $where_parts);
        return $this;
    }

    public
    function inner_join($table, $on)
    {
        $this->join[] = "INNER JOIN {$table} ON {$on}";
        return $this;
    }

    public
    function left_join($table, $on)
    {
        $this->join[] = "LEFT JOIN {$table} ON {$on}";
        return $this;
    }

    public
    function right_join($table, $on)
    {
        $this->join[] = "RIGHT JOIN {$table} ON {$on}";
        return $this;
    }

    public
    function getParams()
    {
        return $this->params;
    }




}