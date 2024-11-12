<?php
session_start();
require_once('database.php');
$db = new Database();

$number = $_POST['id'];
$turn = $_POST['turn'];
$codeGame = $_SESSION['codeGame'];
$db->updateCell($number, $turn, $codeGame);
$db->setHasPlayed($_SESSION['codeGame']);