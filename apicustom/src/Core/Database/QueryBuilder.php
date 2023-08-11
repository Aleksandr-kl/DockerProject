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

    public function __construct()
    {
        $this->params = [];
    }

    public function select($fields = "*")
    {
        $this->type = "select";
        $field_string = $fields;
        if (is_array($fields)) {
            $field_string = implode(",", $fields);
        }
        $this->fields = $field_string;
        return $this;
    }

    public function insert($values)
    {
        $this->type = "insert";
        $field_names = implode(",", array_keys($values));
        $field_names .= ", date";
        $param_names = ":" . implode(", :", array_keys($values));
        $param_names .= ", :date";
        $this->fields = "({$field_names}) VALUES ({$param_names})";
        $values['date'] = date("Y-m-d H:i:s");
        $this->params = $values;

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

    public function getSql()
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
                $sql = "INSERT INTO {$this->table} {$this->fields}";
                return $sql;
                break;
        }
    }

    public function where($where)
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

    public function inner_join($table, $on)
    {
        $this->join[] = "INNER JOIN {$table} ON {$on}";
        return $this;
    }

    public function left_join($table, $on)
    {
        $this->join[] = "LEFT JOIN {$table} ON {$on}";
        return $this;
    }

    public function right_join($table, $on)
    {
        $this->join[] = "RIGHT JOIN {$table} ON {$on}";
        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }


}