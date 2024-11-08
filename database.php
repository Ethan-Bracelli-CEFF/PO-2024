<?php

class Database
{

    private PDO $db;
    private string $hostname = "localhost";
    private string $port = "3306";
    private string $dbname = "po-2024";
    private string $username = "root";
    private string $pwd = "";

    public function __construct()
    {
        $this->db = new PDO("mysql:host=$this->hostname;port=$this->port;dbname=$this->dbname", $this->username, $this->pwd);
    }

    public function createUser($username)
    {
        $stmt = $this->db->prepare("INSERT INTO player (name) VALUES (:username)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
    }

}