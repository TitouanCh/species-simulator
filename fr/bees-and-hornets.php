<!DOCTYPE html>
<html lang= "fr">
<head>
<title>L'invasion des Frelons Asiatiques et l'impact sur les Abeilles en Europe, modélisation simple</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png"/>
<meta name="Description" content="Modélisation ou simulation simple de l'invasion des frelons asiatiques en Europe et en France, nous nous intéressons à l'impact de cette invasion sur la population d'abeilles locale.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src ="scripts/resizeIframe.js"></script>
</head>

<body>

<a class="skip-link" href="#main">Passer directement à l'article</a>

<header><?php readfile("html/navbar.html") ?></header></br>

<main id="main">

<div class="article">

<h1 class="title">L'impact des frelons asiatiques sur les abeilles</h1>

<h2>Introduction :</h2>

<p>En 2004, le frelon asiatique, espèce endémique d'Asie, est introduit en France. Par la suite, il se diffusera rapidement dans toute l'Europe.
L'impacte de cette espèce invasive sur notre biodiversité suscite de grosses inquétudes auprès des chercheurs. 
Ils s'intéressent notamment aux conséquences de cette invasion sur les populations d'abeilles déja fragilisées par l'utilisation massive des néonicotinoides (insectisides utilisées en agriculture).
En effet, les frelons se nourrissent de fruits et de petits insectes, les abeilles, riches en protéines, sont capturées par le frelon et ramenées à la colonie pour être dévorées par les larves.
L'invasion des frelons asiatiques accélèreraient la disparition des abeilles.
Contrairement aux abeilles asiatiques qui ont développées des stratégies de défence face aux frelons asiatiques, les abeilles européennes sont des cibles faciles et peuvent être décimé en grand nombre par les frelons.
</p>

<h2>Objectifs :</h2>

<p>A travers un modèle simple, nous chercherons à modéliser la relation complexe entre les abeilles et frelons.</p>

<img src="img/bees.jpg" alt="bee hive honey">

<h2>Le modèle :</h2>

<p>Le modèle comporte plusieurs élément:
<ul>
<li>En <b style ="background-color: #ffe478;">jaune</b>: les ruches d'abeilles qui produisent des drones et stockent le miel. Une fois que la ruche à récupèrer assez de miel elle produirera une reine qui ira fonder une nouvelle colonie.</li>
<li>En <b style ="background-color: #ffb570;">orange</b>: les abeilles, lorsqu'elles entre en contact avec une plante elles récupèrent du pollen qu'elles essayerons de ramener à la colonie pour le tranformer en miel. Elles se repèrent grace à des phéronomes.</li>
<li>En <b style ="background-color: #ff6b97;">rose</b>: les nids de frelons asiatiques. Comme les ruches, ils produisent des drones et stockent les ressources jusqu'à pouvoir produire une nouvelle reine.</li>
<li>En <b style ="background-color: #66ffe3;">bleu</b>: les frelons, lorsqu'ils rentrent en contact avec une abeille il la capture et essaye de la ramener à leur colonie. Ils se repèrent comme les abeilles : grâce à des phéronomes.</li>
<li>En <b style ="background-color: #3d6e70; color: white;">vert foncé</b>: les végétaux, ils produisent des graines et peuvent être détruits s'il y a une densité d'insectes trop importante.</li>
<li>En <b style ="background-color: #8c3f5d; color: white;">violet</b>: les graines, elles  se déplace aléatoirement et donneront des végétaux.</li>
</ul>
</p>

</br>

<iframe src="php/simulation.php?preset=3" style="width:100%;border:none;" title="Simulation des abeilles" class = "simulation" scrolling="no" onload="resizeIframe(this)"></iframe>

</div>

</main>

<footer><?php readfile("html/footer.html") ?></footer>

</body>