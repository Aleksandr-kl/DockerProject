<?php

namespace App\Core\Database;

use App\Core\Core;


class ActiveRecord
{
    protected $table;
    protected array $fields=[];
    protected Database $database;
    function __construct( )
    {

    }
    function __set(string $name, $value): void
    {
        $this->fields[$name]=$value;
        // TODO: Implement __set() method.
    }
    function __get(string $name)
    {
        return $this->fields[$name];
        // TODO: Implement __get() method.
    }
    function __call(string $name, array $arguments)
    {
        switch ($name){
            case 'save':
                $builder=new QueryBuilder();
                if(!empty($arguments[0])){
                    $this->table=$arguments[0];
                }
                if(!empty($this->table)){
                    $builder->insert( $this->fields)->into($arguments[0]);
                    Core::GetInstance()->GetDatabase()->execute($builder);
                }



                echo $builder->getSql();

                break;
        }
        // TODO: Implement __call() method.
    }
}