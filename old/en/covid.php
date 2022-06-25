<!DOCTYPE html>
<html lang= "fr">
<head>
<title>Simulation simple du Covid 19</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png"/>
<meta name="Description" content="Simulation simple du Covid 19 en ligne, nous appliquons notre simulateur d'espèces au covid 19.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src ="scripts/resizeIframe.js"></script>
</head>

<body>

<a class="skip-link" href="#main">Passer directement à l'article</a>

<header><?php readfile("html/navbar.html") ?></header></br>

<div class="article">

<h1 class="title">Aparte sur le covid 19</h1>

<h2>Introduction :</h2>

<p>Le Covid 19 est un virus qui a boulversé le monde en 2020. Premièrement identifié à Wuhan en Chine, il s'est maintenant répandu sur tout les continents.
Les conséquences du virus sont encore ressenties aujourd'hui.
Montrons la puissance de notre modèle en simulant de manière simple une relation virus-population.</p>

<h2>Objectifs :</h2>

<p>Essayer de modéliser de manière simple, le virus covid 19 à l'aide de notre modèle.</p>

<h2>Le modèle :</h2>

<p>Le modèle comporte plusieurs élément:
<ul>
<li>En <b style ="background-color: #7c9992;">vert</b>: les populations non contaminées.</li>
<li>En <b style ="background-color: #293e58; color: white;">bleu</b>: l'océan.</li>
<li>En <b style ="background-color: #7190a2;">bleu fonçé</b>: les zones contaminées.</li>
<li>En <b style ="background-color: #99aeea;">bleu clair</b>: les zones immunisées.</li>
<li>En <b style ="background-color: #aeaeaa;">gris</b>: les transit infectés.</li>
</ul>
</p>

<iframe src="php/simulation.php?preset=4" style="width:100%;border:none;" title="Simulation du Covid 19"  scrolling="no" onload="resizeIframe(this)"></iframe>

</div>

<footer><?php readfile("html/footer.html") ?></footer>

</body>

<script src="scripts/includer.js"></script>