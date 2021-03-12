<?php


namespace App\Concerns;


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
