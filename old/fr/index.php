<!DOCTYPE html>
<html lang= "fr">
<head>
<title>Simulateur d'Espèces en Ligne</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png"/>
<meta name="Description" content="Simulateur d'espèce en ligne simple et gratuit permettant la simulation et modélisation de relations entre epèces comme les espèces envahissantes et endémiques.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<a class="skip-link" href="#main">Passer directement à l'article</a>

<!-- Bar de Navigation -->
<header><?php readfile("html/navbar.html") ?></header></br>
<!-- Fin Bar de Navigation -->

<main id="main">

<!-- Canvas de la simulation -->
<div class="article" style = "text-align:center;">
<canvas id="board" width="500" height="500"></canvas>
<!-- Fin -->

</br>

<!-- Formulaire pour les parametres de la simulation -->
<div style = "text-align:center;">
<div id = "compteur"></div> 

</br>

<input id="restartSim" type="button" value="Redémarrer la Simulation" onclick="restart();" />
<label class= "hiddenLabel" for="restartSim">Lance ou redémarre la simulation.</label>
</br>

Pause: 
<input id="pause" type="checkbox"/>
<label class= "hiddenLabel" for="pause">Met en pause la simulation.</label>
</br>

Mettre en pause à une certaine génération: <input type="number" min="0" value="100" id="pauseGenerationNumber"> <input id="pauseGeneration" type="checkbox"/>
<label class ="hiddenLabel" for="pauseGenerationNumber">Choisir une génération à laquelle la simulation se mettra en pause.</label>
<label class ="hiddenLabel" for="pauseGeneration">Activer la pause à une certaine génération.</label>

</br>
</br>

Longueur du tableau:
<input type="number" min="10" max="800" value="500" id="longueurTableau">
<label class ="hiddenLabel" for="longueurTableau">Sélectionner la longueur du tableau.</label>

</br>

Hauteur du tableau:
<input type="number" min="10" max="800" value="500" id="hauteurTableau">
<label class ="hiddenLabel" for="hauteurTableau">Sélectionner la hauteur du tableau.</label>

</br>

Longueur des cases:
<input type="number" min="1" max="200" value="10" id="longueurCase">
<label class ="hiddenLabel" for="longueurCase">Sélectionner la longueur des cases.</label>

</br>

Hauteur des cases:
<input type="number" min="1" max="200" value="10" id="hauteurCase">
<label class ="hiddenLabel" for="hauteurCase">Sélectionner la hauteur des cases.</label>

</br>

Probabilité de parsemage:
<input type="number" min="100" max="100000" value="1000" id="probaParsemage">
<label class ="hiddenLabel" for="probaParsemage">Choisir une probabilité de parsemage.</label>

</br>

Génération par secondes:
<input type="number" min="1" max="120" value="60" id="FPS">
<label class ="hiddenLabel" for="FPS">Choisir le nombre de génération par secondes.</label>

</br>
</br>

<!-- Parametre des especes -->
<input id="ajouterEspece" type="button" value="Ajouter une espèce" onclick="ajouterEspece();" />
<input id="supprimerEspece" type="button" value="Supprimer une espèce" onclick="supprimerEspece();" />
<div id= "gestionEspeces"></div>

<label class ="hiddenLabel" for="supprimerEspece">Supprimer une espèce.</label>
<label class ="hiddenLabel" for="ajouterEspece">Ajouter une espèce.</label>
</br>
</br>

<!-- Telechargement du CSV -->
<input id="downloadCSV" type="button" value="Télécharger les données sous format .CSV" onclick="downloadCSV(especesDataCached);" />
</div>

<!-- Fin -->

</br>

<!-- Canvas du Graphique -->
<div style = "text-align:center;">
<canvas id="graph" width="800" height="800"></br></canvas>
</div>
<!-- Fin -->

</div>

</main>

<footer><?php readfile("html/footer.html") ?></footer>

</body>

<script src="scripts/case.js"></script>
<script src="scripts/graph.js"></script>
<script src="scripts/exportCSV.js"></script>
<script src ="scripts/simulation.js"></script>

<script>

home = true;

// Debut de la simulation
afficheEspece();
restart();
main();
graph(1,1,'#7c9ac2');

graphRatios();
document.getElementById("graph").width = graphLongueur;
document.getElementById("graph").height = graphHauteur;

</script>
</html>