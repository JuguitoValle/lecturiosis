<?php

namespace App\Models;

use App\Models\Connection;
use App\Interfaces\ModelInterface;
use pdo;


class Model implements ModelInterface
{
    protected static  $table = '';

    protected static ?\PDO $dbInstance = null;

    protected function __construct()
    {
        if (!isset(self::$dbInstance)) {
            self::$dbInstance = Connection::getInstance(); 
        }
    }

    protected static function getTable(): string
    {
        return static::$table;
    }

    public function save()
    {

    }

    public function delete()
    {

    }

    public function findById($id)
    {
        $table = static::getTable();
         $sql = "SELECT * FROM $table where id =$id";
         $result =self::$dbInstance->prepare($sql);
         $result->execute();
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public static function get()
    {
        $table = static::getTable();
        if (!isset(self::$dbInstance)) {
            self::$dbInstance = Connection::getInstance();
        }

        $sql = "SELECT * FROM $table";
        $result = self::$dbInstance->prepare($sql);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}