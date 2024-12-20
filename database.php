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

    public function createGame($codeGame, $hasPlayed, $status, $turn){
        $stmt = $this->db->prepare("INSERT INTO game (`codeGame`, `hasPlayed`, `status`, `turn`) VALUES (:code, :hasPlayed, :status, :turn)");
        $stmt->bindParam(':code', $codeGame);
        $stmt->bindParam(':hasPlayed', $hasPlayed);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':turn', $turn);
        $stmt->execute();
    }

    public function setGameCodeForPlayer($username, $codeGame){
        $stmt = $this->db->prepare("UPDATE player SET `codeGame` = :codeGame WHERE `name` = :username");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':codeGame', $codeGame);
        $stmt->execute();
    }

    public function verifyCodeGameUser($codeGame){
        $stmt = $this->db->prepare("SELECT * FROM game WHERE `codeGame` = :codeGame");
        $stmt->bindParam(":codeGame", $codeGame);
        $stmt->execute();

        if($stmt->rowCount() == 1){
            return true;
        }
        else{
            return false;
        }
    }

    public function playerLeaveGame($userId)
    {
        $stmt = $this->db->prepare("UPDATE player SET codeGame = 0 WHERE Id_Player = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function countPlayerByGameCode($codeGame)
    {
        $stmt = $this->db->prepare("SELECT COUNT(Id_Player) FROM player WHERE codeGame = :codeGame");
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

    public function deleteGameByGameCode($codeGame)
    {
        $stmt = $this->db->prepare("DELETE FROM game WHERE codeGame = :codeGame");
        $stmt->bindParam(':codeGame', $codeGame, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function verifyUsername($username){
        $stmt = $this->db->prepare("SELECT * FROM player WHERE `name` = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        if($stmt->rowCount() >= 1){
            return false;
        }
        else{
            return true;
        }
    }

    public function verifyCodeGameGeneration($codeGame) 
    {
        $stmt = $this->db->prepare("SELECT * FROM game WHERE `codeGame` = :codeGame");
        $stmt->bindParam(":codeGame", $codeGame);
        $stmt->execute();

        if($stmt->rowCount() >= 1){
            return false;
        }
        else{
            return true;
        }
    }

    public function addCell($state, $number, $codeGame)
    {
        $stmt = $this->db->prepare("INSERT INTO cells (`state`, `number`, `codeGame`) VALUES (:state, :number, :codeGame)");
        $stmt->bindParam(":state", $state);
        $stmt->bindParam(":number", $number);
        $stmt->bindParam(":codeGame", $codeGame);
        $stmt->execute();
    }

    public function updateCell($number, $turn, $codeGame){
        $stmt = $this->db->prepare("UPDATE cells SET `state` = :turn WHERE `codeGame` = :codeGame AND `number` = :number");
        $stmt->bindParam(":number", $number);
        $stmt->bindParam(":turn", $turn);
        $stmt->bindParam(":codeGame", $codeGame);
        $stmt->execute();
    }
    public function countCellsByGameCode($codeGame)
    {
        $stmt = $this->db->prepare("SELECT COUNT(Id_Cells) FROM cells WHERE codeGame = :codeGame");
        $stmt->bindParam(':codeGame', $codeGame, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCellsByCodeGame($codeGame)
    {
        $stmt = $this->db->prepare("SELECT * FROM cells WHERE codeGame = :codeGame");
        $stmt->bindParam(':codeGame', $codeGame, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTurnByCodeGame($codeGame)
    {
        $stmt = $this->db->prepare("SELECT turn FROM game WHERE codeGame = :codeGame");
        $stmt->bindParam(':codeGame', $codeGame, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function changeTurnByCodeGame($turn, $codeGame)
    {
        $stmt = $this->db->prepare("UPDATE game SET `turn` = :turn WHERE `codeGame` = :codeGame");
        $stmt->bindParam(":turn", $turn);
        $stmt->bindParam(":codeGame", $codeGame);
        $stmt->execute();
    }

    public function replay($codeGame){
        $stmt = $this->db->prepare("UPDATE cells SET `state` = '' WHERE `codeGame` = :codeGame");
        $stmt->bindParam(":codeGame", $codeGame);
        $stmt->execute();

        $this->changeTurnByCodeGame("X", $codeGame);
    }

    public function setPlayerTurn($turn, $username)
    {
        $stmt = $this->db->prepare("UPDATE player SET `turn` = :turn WHERE `name` = :username");
        $stmt->bindParam(":turn", $turn);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
    }

    public function getTurnByPlayer($username)
    {
        $stmt = $this->db->prepare("SELECT `turn` from `player` WHERE `name` = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPlayerPlayingByCodeGame($codeGame, $turn){
        $stmt = $this->db->prepare("SELECT `name` from `player` WHERE `codeGame` = :codeGame AND `turn` = :turn");
        $stmt->bindParam(":codeGame", $codeGame);
        $stmt->bindParam(":turn", $turn);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}