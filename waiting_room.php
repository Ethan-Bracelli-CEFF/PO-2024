<?php
session_start();
require_once('database.php');
$db = new Database();
$codeGame = $_SESSION['codeGame'];
$playerNumber = $db->countPlayerByGameCode($codeGame);
$playerNumber = $playerNumber["COUNT(Id_Player)"];

if ($playerNumber > 2){
    echo "<script>alert('Cette partie a déjà commencé !');</script>";
    header('Location: hub.php');
} else if ($playerNumber === 2){
    $cellNumber = $db->countCellsByGameCode($codeGame);
    $cellNumber = $cellNumber["COUNT(Id_Cells)"];
    if ($cellNumber < 9){
        for ($i = 1; $i < 10; $i++){
            $state = ""; // vide
            $number = $i;
            $codeGame = $_SESSION['codeGame'];
            $db->addCell($state, $number, $codeGame);
        }
        $db->startGameByGameCode($codeGame);
    }
    header('Location: game.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    

    $db->playerLeaveGame($userId);
    $playerNumber = $db->countPlayerByGameCode($codeGame);
    $playerNumber = $playerNumber["COUNT(Id_Player)"];
    $_SESSION['codeGame'] = null;
    if ($playerNumber = 0){
        $db->deleteGameByGameCode($codeGame);
    }
    header("Location: hub.php");
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>UMBUSE 2K24 - Waiting Room</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />

    <meta http-equiv="refresh" content="1">
</head>

<body>
    <header>
        <div style="background-color: #597081; color: white; padding: 5px" class="text-center">
            <h2>Ultimate Morpion Battle Ultra Simulator Extrem 2k24</h2>
        </div>
    </header>
    <main>
        <div class="container" style="margin-top: 15vh;">
            <h1 class="text-center" style="font-size: 4em">En attente</h1>
            <h2 class="text-center" style="margin-top:15%">Cette parti à besoin d'un deuxième joueur pour être commencée</h2>
            <h3 class="text-center" style="margin-top:20%">Code de la game : <?php echo($codeGame) ?></h3>
            <form action="" method="POST">
            <button style="width:30%; color: white; background-color: #597081; padding: 5px; margin-left: 35%; margin-top: 5vh" class="rounded-4 border-0" type="submit">Quitter</button>
            </form>
        </div>
    </main>
    <footer>
        <div style="background-color: #597081; width: 100%; color: white; position: absolute; bottom: 0" class="text-center">
            <p style="margin-top: 5px; padding-top: 5px">Portes-ouvertes 2024 - Ethan²</p>
        </div>
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>