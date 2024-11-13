<?php
session_start();
require_once('database.php');
$db = new Database();
$codeGame = $_SESSION['codeGame'];
$_SESSION['win'] = false;

$cells = $db->getCellsByCodeGame($codeGame);
$turn = $db->getTurnByCodeGame($codeGame);
$turn = $turn['turn'];


$cells = $db->getCellsByCodeGame($codeGame);
?>

<?php // verification du gagnant
    $cells = $db->getCellsByCodeGame($codeGame);

    $ListCell = [];
    foreach ($cells as $index => $cell) {
        $ListCell["cell" . ($index + 1)] = [
            "nombre" => $cell['number'],
            "state" => $cell['state']
        ];
    }

    $winCombinations = [
        ["1", "2", "3"],
        ["4", "5", "6"],
        ["7", "8", "9"],
        ["1", "4", "7"],
        ["2", "5", "8"],
        ["3", "6", "9"],
        ["1", "5", "9"],
        ["3", "5", "7"]
    ];

    foreach ($winCombinations as $comb) {
        $xCount = 0;
        $oCount = 0;

        foreach ($comb as $cellIndex) {
            if ($ListCell["cell" . $cellIndex]['state'] == "X") {
                $xCount++;
            }
            else if ($ListCell["cell" . $cellIndex]['state'] == "O"){
                $oCount++;
            }

            if ($xCount == 3) {
                $_SESSION['win'] = "X";
                header('Location: accueil.php'); // temporaire
                exit();
            }
            else if($oCount == 3){
                $_SESSION['win'] = "O";
                header('Location: accueil.php'); // temporaire
                exit();
            }
        }
    }
?>

<!doctype html>
<html lang="en">

<head>
    <title>UMBUSE 2K24 - Game</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        /* Styles pour centrer les boutons du morpion */
        .morpion-grid-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10%;
        }

        .morpion-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            width: 80vw;
            max-width: 400px;
        }

        button.allbtn {
            background-color: #597081;
            padding: 10px;
            aspect-ratio: 1;
            width: 100%;
            border-radius: 30%;
            color: white;
            font-size: 2rem;
        }
    </style>
    <script>
        // Fonction qui actualise la page toutes les secondes
        setInterval(function() {
            location.reload();
        }, 1000); // 1000 millisecondes = 1 seconde
    </script>
</head>

<body>
    <header>
        <div style="background-color: #597081; color: white; padding: 5px" class="text-center">
            <h2>Ultimate Morpion Battle Ultra Simulator Extrem 2k24</h2>
        </div>
    </header>
    <main>
        <div class="morpion-grid-container" style="margin-top:10vh">
            <div class="morpion-grid">
                <?php foreach ($cells as $cell): ?>
                    <button id="<?= $cell['number'] ?>" class="allbtn border-0" onclick="morpion(<?= $cell['number'] ?>)"><?= $cell['state'] ?></button>
                <?php endforeach; ?>

            </div>
        </div>
        <h2 id="tour" style="margin: 10px; margin-top: 7vh" class="text-center">Au tour du joueur <?= $turn ?></h2>
        <button onclick="rejouer()" class="rounded-4 border-0" style="color: white; background-color: #597081; padding: 5px; margin-top: 5vh; width: 30%; margin-left: 35%">Rejouer</button>
    </main>
    <input type="hidden" name="turn" id="turn" value="<?= htmlspecialchars($turn) ?>">
    <footer>
        <div style="background-color: #597081; width: 100%; color: white; position: absolute; bottom: 0" class="text-center">
            <p style="margin-top: 5px; padding-top: 5px">Portes-ouvertes 2024 - Ethan²</p>
        </div>
    </footer>

    <script>
        let gagnant = false;
        let ex = 0;
        let turn = document.getElementById("turn").value;

        async function morpion(id) {
            turn = document.getElementById("turn").value;
            fetch('updateCell.php', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: 'id=' + id + '&turn=' + turn
            });

            const elem = document.getElementById(id);
            if (!gagnant && elem.innerHTML === "") {
                ex++;
                elem.innerHTML = `${turn}`;
                if (ex >= 5) {
                    gagne();
                }
            }
        }


        function exaequo() {
            document.getElementById('tour').innerHTML = `<h2>EX AEQUO</h2>`;
        }

        function rejouer() {
            fetch('replay.php?');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

