<!DOCTYPE html>
<html>
<head>
<title>Simulation</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="style.css">
</head>

<body>

<?php $var = $_GET["preset"]; ?>

<!-- Canvas de la simulation -->
<div class="article" style = "text-align:center;">
<canvas id="board" width="500" height="500"></canvas>
<!-- Fin -->

</br>

<!-- Formulaire pour les parametres de la simulation -->
<div style = "text-align:center;">
<div id = "compteur"></div> 

</br>

<input id="restartSim" type="button" value="Lancer la Simulation!" onclick="restart();" />

</br>

Pause: 
<input id="pause" type="checkbox"/>

<?php
if ( $var == 3) {
	echo 'Pheromone View: <input id="pheroView" type="checkbox"/>';
}
?>

</br>

Mettre en pause à une certaine génération: <input type="number" min="0" value="100" id="pauseGenerationNumber"> <input id="pauseGeneration" type="checkbox"/>

</br>
</br>

<!-- Telechargement du CSV -->
<input id="downloadCSV" type="button" value="Télécharger les données sous format .CSV" onclick="downloadCSV(especesDataCached);" />
</div>

<!-- Fin -->

</br>

<!-- Canvas du Graphique -->
<div style = "text-align:center;">
<canvas id="graph" width="500" height="500" style="border:1px solid #000000;"></canvas>
</div>
<!-- Fin -->

</div>

</body>



<?php
if ( $var == 3 ) { // Abeilles et Frelons :)
	echo '<script src ="../scripts/abeilleOnly/case-AbeilleOnly.js"></script>';
	echo '<script src="../scripts/abeilleOnly/simulation-AbeilleOnly.js"></script>';
} else if ($var == 4) {
	echo '<script src="../scripts/case.js"></script>';
	echo '<script src="../scripts/covidOnly/simulation-covidOnly.js"></script>';
} else if ($var == 8) {
	echo '<script src="../scripts/case.js"></script>';
	echo '<script src="../scripts/myxomatoseOnly/simulation-myxomatoseOnly.js"></script>';
} else {
	echo '<script src="../scripts/case.js"></script>';
	echo '<script src ="../scripts/simulation.js"></script>';
}
?>

<script src="../scripts/graph.js"></script>
<script src="../scripts/exportCSV.js"></script>

<script>

var params = location.href.split('?')[1].split('&');
var preset = parseInt(params[0].split('=')[1]);

home = false;
workerPath = "../scripts/setupworker.js";
graphLongueur = 500;
graphHauteur = 500;

if (preset == 1) { // Barebones
	simulationType = 2;
	parsemageType = 2;
	workerPath = "../scripts/setupworker.js";
}

if (preset == 2) { // Lapin Walla Basic
	simulationType = 1;
	parsemageType = 3;
	generationInvasion = 500;
	especesData = [ [30, 100, '#2E8B57', 0, [false, false, false]], [2, 10, '#997978', 5, [true, false, false]], [2, 6, '#392E2B', 10, [true, false, false]] ];
	longueurTableau = 700;
	hauteurTableau = 700;
	
}

if (preset == 3){ // Abeille et Frelons
	workerPath = "../scripts/abeilleOnly/setupworker-AbeilleOnly.js";
	longueurTableau = 1000;
	hauteurTableau = 1000;
	graphLongueur = 1000;
	graphHauteur = 1000;
}

if (preset == 4) { // Covid
	longueurTableau = 1000;
	hauteurTableau = 600;
}

if (preset == 5) { // Walla Vegetaux
	simulationType = 1;
	parsemageType = 3;
	generationInvasion = 500;
	especesData = [ [30, 100, '#2E8B57', 0, [false, false]], [2, 10, '#997978', 5, [true, false]] ];
	longueurTableau = 700;
	hauteurTableau = 700;
	
}

if (preset == 6) { // Lapin Walla Chasseur
	simulationType = 1;
	parsemageType = 3;
	generationInvasion = 500;
	especesData = [ [30, 100, '#2E8B57', 0, [false, false, false]], [2, 10, '#997978', 5, [true, false, false]], [2, 3, '#392E2B', 10, [true, false, false]] ];
	longueurTableau = 700;
	hauteurTableau = 700;
	
}

if (preset == 7) { // Lapin Walla Renard 
	simulationType = 1;
	parsemageType = 3;
	generationInvasion = 500;
	especesData = [ [30, 100, '#2E8B57', 0, [false, false, false, false]], [2, 10, '#997978', 5, [true, false, false]], [2, 6, '#392E2B', 10, [true, false, false, false]], [10, 40, '#FF5733', 30, [false, true, true, false]] ];
	longueurTableau = 700;
	hauteurTableau = 700;
	
}

if (preset == 8) { // Lapin Walla Myxomatose 
	simulationType = 1;
	parsemageType = 3;
	generationInvasion = 500;
	longueurTableau = 700;
	hauteurTableau = 700;
	
}

if (preset == 9) { // Lapin Walla Réserve Naturelle 
	simulationType = 1;
	parsemageType = 4;
	generationInvasion = 1000;
	especesData = [ [30, 100, '#2E8B57', 0, [false, false, false, false]], [30, 100, '#426442', 0, [false, false, false, false]], [2, 10, '#997978', 5, [true, true, false, false]], [2, 6, '#392E2B', 10, [false, true, false, false]] ];
	longueurTableau = 700;
	hauteurTableau = 700;
	
}

document.getElementById("board").width = longueurTableau;
document.getElementById("board").height = hauteurTableau;
document.getElementById("graph").width = graphLongueur;
document.getElementById("graph").height = graphHauteur;

// Debut de la simulation

main();

</script>
</html>