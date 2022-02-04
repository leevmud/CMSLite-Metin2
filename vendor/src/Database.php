<?php
namespace CMSLite;

class Database{
    private $conn; 
    
    private $settings = array(
        \PDO::ATTR_EMULATE_PREPARES => false, 
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION 
    );

    public function __construct(){
        try {
            $this->conn = new \PDO('mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset='.CHARSET.'', DB_USER, DB_PASS, $this->settings);

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $this->conn;
    }

    public function select($rawQuery, $params = array()){
        $stmt = $this->conn->prepare($rawQuery);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    public function query($rawQuery, $params = array()){
        $stmt = $this->conn->prepare($rawQuery);
        $stmt->execute($params);
    }
    public function count($rawQuery, $params = array()){
        $stmt = $this->conn->prepare($rawQuery);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
}