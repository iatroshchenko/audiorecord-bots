<?php


namespace App\Traits\Model;


trait ExposesTableName
{
    public static function getTableNameStatic()
    {
        return (new self())->getTableName();
    }

    public function getTableName()
    {
        return $this->table;
    }
}
