<?php
session_start();
require_once('database.php');
$db = new Database();

$number = $_POST['id'];
$turn = $_POST['turn'];
$codeGame = $_SESSION['codeGame'];
$db->updateCell($number, $turn, $codeGame);
if ($turn == "X"){
    $turn = "O";
} elseif ( $turn == "O"){
    $turn = "X";
}
$db->changeTurnByCodeGame($turn, $codeGame);
