<?php
namespace CMSLite;

class Database{
    private static $conn; 
    
    private static $settings = array(
        \PDO::ATTR_EMULATE_PREPARES => false, 
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION 
    );

    public static function connect(){
        if(!self::$conn){
            self::$conn = new \PDO('mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset='.CHARSET.'', DB_USER, DB_PASS, self::$settings);
        }
    }

    public static function select($rawQuery, $params = array()){
        $stmt = self::$conn->prepare($rawQuery);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    public static function query($rawQuery, $params = array()){
        $stmt = self::$conn->prepare($rawQuery);
        $stmt->execute($params);
    }
    public static function count($rawQuery, $params = array()){
        $stmt = self::$conn->prepare($rawQuery);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
}