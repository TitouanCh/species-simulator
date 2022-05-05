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

<h1>Les équations Lotka-Volterra</h1>

<h2>Les équations Lotka-Volterra sont un système d'équations différentielles permettant d'étudier les intéractions entre les populations de différentes espèces...</h2>

Les équations Lotka-Volterra sont un système d'équations du première ordre. Si vous voulez plus d'explication sur les équations différentielles, <a href="/species-simulator.com/fr/differential-equations/">cliquez ici</a>.
</p>

<canvas id="differential" width="800" height="800"></canvas>
</br>

Pause : 
<input id="pause" type="checkbox"/>
 || 
Axes : 
<input id="axes" type="checkbox"/>

</br>
<label for="equation">Equation : y' = </label>
<input type="text" id="equation" name="equation" style = "width:30px; text-align:center;" value="1"> y.
<br>

<label for="dlength">Longueur de des dérivées : </label>
<input type="number" id="dlength" name="dlength" value="0.1">

</br>

<label for="numPoints">Nombre de points : </label>
<input type="number" id="numPoints" name="numPoints" value="500">
 || 
<label for="scale">1/Echelle : </label>
<input type="number" id="scale" name="scale" value="50">

</br>
<button type="button" onclick="ready();">Recalculer</button>

</br>
<p>
</p>

<script src="/species-simulator.com/scripts/differential/differential2.js"></script>

</div>

</main>

<footer><?php readfile("../html/footer.html") ?></footer>

</body>

</html>