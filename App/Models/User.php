<?php

namespace App\Models;

use App\Models\Model;

class User extends Model
{
    protected static $table = 'users';
    public $id; 
    public $name;
    public $email;
    public $password;

    public static function search($term)
    {
        $table = static::$table;
        $db = self::getDbInstance();
        
        $stmt = $db->prepare("
            SELECT * FROM {$table} 
            WHERE id = :term 
            OR name LIKE :search 
            OR email LIKE :search
        ");
        
        $searchTerm = "%{$term}%";
        $stmt->bindParam(':term', $term, \PDO::PARAM_INT);
        $stmt->bindParam(':search', $searchTerm, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    protected static function getDbInstance()
    {
        if (!isset(self::$dbInstance)) {
            self::$dbInstance = Connection::getInstance();
        }
        return self::$dbInstance;
    }
   
    

}
