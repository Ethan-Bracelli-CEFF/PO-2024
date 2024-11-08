<!doctype html>
<html lang="en">
    <head>
        <title>A12</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <style>
            button.allbtn {
                background-color: #597081;
                width: 25vw;
                height: 25vw;
                margin: 2.5%;
                vertical-align: middle;
                border-radius: 30%;
            }
            button {
                color: white;
                width:30%;
                color: white; 
                background-color: #597081; 
                padding: 5px; 
                margin-left: 35%; 
                margin-top: 10%
            }
        </style>
    </head>
    <body>
        <header>
            <div style="background-color: #597081; color: white; padding: 5px" class="text-center"><h2>Ultimate Morpion Battle Ultra Simulator Extrem 2k24</h2></div>
        </header>
        <main>
            <div class="container" style="margin-top: 20%">
                <button id="1" class="allbtn border-0" onclick="morpion('1')"></button>
                <button id="2" class="allbtn border-0" onclick="morpion('2')"></button>
                <button id="3" class="allbtn border-0" onclick="morpion('3')"></button><br>

                <button id="4" class="allbtn border-0" onclick="morpion('4')"></button>
                <button id="5" class="allbtn border-0" onclick="morpion('5')"></button>
                <button id="6" class="allbtn border-0" onclick="morpion('6')"></button><br>

                <button id="7" class="allbtn border-0" onclick="morpion('7')"></button>
                <button id="8" class="allbtn border-0" onclick="morpion('8')"></button>
                <button id="9" class="allbtn border-0" onclick="morpion('9')"></button><br>

                <h2 id="tour" style="margin: 10px" class="text-center">Au tour du joueur X</h2>

                <button onclick="re()" class="rounded-4 border-0">
                    Rejouer
                </button>
            </div>
        </main>
        <footer>
            <div style="background-color: #597081; width: 100%; color: white; position: absolute; bottom: 0" class="text-center"><p style="margin-top: 5px; padding-top: 5px">Portes-ouvertes 2024 - Ethan²</p></div>
        </footer>  

        <script>
            let joueur = 1;
            let gagnant = false;
            let ex = 0;

            function morpion(id) {
                const elem = document.getElementById(id);
                if (!gagnant && elem.innerHTML === "") {
                    ex++;
                    elem.innerHTML = joueur === 1 ? `<h1>X</h1>` : `<h1>O</h1>`;
                    document.getElementById('tour').innerHTML = `<h2>Au tour du joueur ${joueur === 1 ? 'O' : 'X'}</h2>`;
                    joueur = 1 - joueur; // Switch player
                    if (ex >= 5) { // Minimum moves required for a win
                        gagne();
                    }
                }
            }

            function gagne() {
                const winCombinations = [
                    ["1", "2", "3"], ["4", "5", "6"], ["7", "8", "9"], // Rows
                    ["1", "4", "7"], ["2", "5", "8"], ["3", "6", "9"], // Columns
                    ["1", "5", "9"], ["3", "5", "7"] // Diagonals
                ];

                winCombinations.some(combination => {
                    const [a, b, c] = combination.map(id => document.getElementById(id).innerHTML);
                    if (a && a === b && b === c) {
                        document.getElementById('tour').innerHTML = `<h2>Le joueur ${a.includes('X') ? 'X' : 'O'} a gagné</h2>`;
                        gagnant = true;
                        disableAllButtons();
                        return true;
                    }
                });

                if (ex === 9 && !gagnant) {
                    exaequo();
                }
            }

            function disableAllButtons() {
                for (let i = 1; i <= 9; i++) {
                    document.getElementById(i.toString()).disabled = true;
                }
            }

            function exaequo() {
                document.getElementById('tour').innerHTML = `<h2>EX AEQUO</h2>`;
            }

            function re() {
                location.reload(true);
            }
        </script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>