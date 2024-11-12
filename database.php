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

    public function playerLeaveGame($userId)
    {
        $stmt = $this->db->prepare("UPDATE player SET Id_Game = 0 WHERE Id_Player = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function countPlayerByGameCode($codeGame)
    {
        $stmt = $this->db->prepare("SELECT COUNT(Id_Player) FROM player WHERE code = :codeGame");
        $stmt->bindParam(':codeGame', $codeGame, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function startGameByGameCode($codeGame)
    {
        $stmt = $this->db->prepare("UPDATE game SET status = 1 WHERE codeGame = :codeGame");
        $stmt->bindParam(':codeGame', $codeGame, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}