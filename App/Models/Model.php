<?php

namespace App\Models;

use App\Models\Connection;
use App\Interfaces\ModelInterface;
use pdo;


class Model implements ModelInterface
{
    protected static  $table = '';

    protected static ?\PDO $dbInstance = null;

    public function __construct()
    {
        if (!isset(self::$dbInstance)) {
            self::$dbInstance = Connection::getInstance(); 
        }
    }

    protected static function getTable(): string
    {
        return static::$table;
    }

    public function save(): bool
{
    $table = static::getTable();
    if (!isset(self::$dbInstance)) {
        self::$dbInstance = Connection::getInstance();
    }

    if (isset($this->id)) {
        // ActualizaR DATOS
        if (isset($this->password)) {
            $sql = "UPDATE {$table} SET name = :name, email = :email, password = :password WHERE id = :id";
        } else {
            $sql = "UPDATE {$table} SET name = :name, email = :email WHERE id = :id";
        }
        
        $stmt = self::$dbInstance->prepare($sql);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
    } else {
        
        $stmt = self::$dbInstance->prepare("
            INSERT INTO {$table} (name, email, password)
            VALUES (:name, :email, :password)
        ");
    }

    $stmt->bindParam(':name', $this->name, \PDO::PARAM_STR);
    $stmt->bindParam(':email', $this->email, \PDO::PARAM_STR);
    
    if (isset($this->password) || !isset($this->id)) {
        $stmt->bindParam(':password', $this->password, \PDO::PARAM_STR);
    }
    
    return $stmt->execute();
}

    public function delete(): bool
{
    if (!isset($this->id)) {
        throw new \RuntimeException("No se puede eliminar un objeto sin ID");
    }

    $table = static::getTable();
    if (!isset(self::$dbInstance)) {
        self::$dbInstance = Connection::getInstance();
    }

    $stmt = self::$dbInstance->prepare("DELETE FROM {$table} WHERE id = :id");
    $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
    
    return $stmt->execute();
}

    public function findById($id)
{
    $table = static::getTable();
    $sql = "SELECT * FROM $table WHERE id = :id";
    $result = self::$dbInstance->prepare($sql);
    $result->bindParam(':id', $id, \PDO::PARAM_INT);
    $result->execute();
    
    return $result->fetchAll(\PDO::FETCH_OBJ);
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