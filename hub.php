<?php
    session_start();
    require_once('database.php');
    $db = new Database();

    $_SESSION['errorMessage'] = "";

    if(isset($_POST['createGame'])){
        function generationNumber($db){
            $codeGame= rand(10000, 100000);
            if($db->verifyCodeGameGeneration($codeGame)){
                $_SESSION['codeGame'] = $codeGame;
            }
            else{
                generationNumber($db);
            }

            $hasPlayed = false;
            $status = 0;
            $turn = "X";

            $db->createGame($_SESSION['codeGame'], $hasPlayed, $status, $turn);
            $db->setGameCodeForPlayer($_SESSION['username'], $_SESSION['codeGame']);
            header("Location: waiting_room.php");
            exit;
        }

        generationNumber($db);
    }
    else if(isset($_POST['joinGame'])){
        $codeGame = $_POST['codeGame'];

        if($db->verifyCodeGameUser($codeGame)){
            $db->setGameCodeForPlayer($_SESSION['username'], $codeGame);
            $_SESSION['codeGame'] = $codeGame;
            header('Location: waiting_room.php');
            exit;
        }
        else{
            $_SESSION['errorMessage'] = "Veuillez entrer un code correct";
        }
    }
?>

<!doctype html>
<html lang="en">

    <head>
        <title>UMBUSE 2K24 - Hub</title>
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
    </head>

    <body>
        <header>
            <div style="background-color: #597081; color: white; padding: 5px" class="text-center">
                <h2>Ultimate Morpion Battle Ultra Simulator Extrem 2k24</h2>
            </div>
        </header>
        <main>
            <form action="" method="post">
                <button style="margin-left: 25vw; margin-top: 30vw;padding: 5px; background-color: #597081; color: white; width: 50vw; font-size: x-large" class="border-0 rounded-4" type="submit" name="createGame">Créer une partie</button>
            </form>

            <h2 style="margin-top: 30vw;" class="text-center">Rejoindre une partie : </h2>
            <form action="" method="post">
                <input type="text" name="codeGame" style="background-color: rgba(89, 112, 129, 0.5);; color: white; width: 50%; margin-left: 25%; margin-top: 5%" class="rounded-4 text-center border-0" placeholder="Code de la partie"><br>
                <button style="width:30%; color: white; background-color: #597081; padding: 5px; margin-left: 35%; margin-top: 10vw" class="rounded-4 border-0" type="submit" name="joinGame">Confirmer</button>
            </form>
            <h4 style="color: red; margin-top: 10vw" class="text-center"><?= $_SESSION['errorMessage'] ?></h4>
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