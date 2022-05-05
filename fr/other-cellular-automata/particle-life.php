<!DOCTYPE html>
<html lang= "fr">
<head>
<title>Simulateur d'Espèces en Ligne</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/species-simulator.com/style.css">
<link rel="icon" type="image/png" href="/species-simulator.com/favicon.png"/>
<meta name="Description" content="Collection de modèle et simulation permettant de simuler la vie, les dynamiques de populations, et les relations entre espèces.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<a class="skip-link" href="#main">Passer directement à l'article</a>

<!-- Bar de Navigation -->
<header><?php readfile("../html/navbar.html") ?></header></br>
<!-- Fin Bar de Navigation -->

<main id="main">

<div class="article" style = "text-align:center;">

<h1>Particle Life Simulation en Ligne</h1>

<h2>Inspiré de Clusters de Jeffrey Ventrella, on peut voir apparaitre dans cette simulation des structures rappelant des micro-organismes...</h2>

<p>Au début de chaques simulation de Particle Life, chaques couleur, correspondant chacunes à une espèces, est assigné un chiffre aléatoire pour chaque autre espèce. 
 Ces chiffres correspondront au type et la force de l'intéraction entre ces deux espèces, si il est négatif, elles s'attireront, si il est positif, elles se repousseront.
 Certaines combinaisons pourront donner des résultats rappelant des organismes microscopiques mais pour cela, n'hésiter pas à relancer la simulation plusieurs fois jusqu'à trouver une combinaison intéressante.
</p>

</br>

<canvas id="particleLife" width="1300" height="800"></canvas>
</br>
<label for="pause">Pause : </label>
<input id="pause" type="checkbox"/>

</br>

<button type="button" onclick="restart();">Redémarrer</button>

</br>

<label for="fpsLimit">Limite d'image par seconde:</label>
<input id="fpsLimit" type="number" name="fpsLimit" value="120" min="1" max="2000">

</br>

<label for="nbEspece">Nombre d'espèce :</label>
<input type="number" id="nbEspece" name="nbEspece" value="6" min="1" max="8">

</br>

<label for="nbIndividus">Nombre d'individus :</label>
<input type="number" id="nbIndividus" name="nbIndividus" value="200" min="1" max="1000">

</br>

<label for="G">G :</label>
<input type="number" id="G" name="G" value="0.0981" min="0" max="10">

||

<label for="drag">1/Résistance :</label>
<input type="number" id="drag" name="drag" value="0.98" min="0" max="1">

<script src="/species-simulator.com/scripts/particleLife/particleLife-App.js"></script>

</div>

</main>

<footer><?php readfile("../html/footer.html") ?></footer>

</body>

</html>