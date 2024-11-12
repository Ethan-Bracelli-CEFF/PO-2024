<?php
session_start();
require_once('database.php');
$db = new Database();

$codeGame = $_SESSION['codeGame'];
// $db->replay($codeGame);