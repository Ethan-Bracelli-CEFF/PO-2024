<?php
session_start();
require_once('db.php');
$db = new Database;

$number = $_GET['id'];
$turn = $_GET['turn'];
$codeGame = $_SESSION['codeGame'];
$db->updateCell($number, $turn, $codeGame);