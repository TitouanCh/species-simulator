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

<h1>Présentation des équations différentielles</h1>

<h2>Les équations différentielles sont des équations dont la ou les inconnues sont des fonctions. Elles sont des outils puissants nous permettant de prédire le monde qui nous entoure...</h2>

<p><b>Interessons-nous dans un premier temps au équations différentielles d'ordre 1 :</b></br>
L'ordre d'une équations différentielles correspond au degré maximal de dérivation auquel l'une des fonctions inconnues à été soumise.
 Par conséquent, la ou les inconnues d'une équation d'ordre 1 sera dérivée au maximum une seule fois.
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
<input type="number" id="dlength" name="dlength" value="10">

</br>

<label for="numPoints">Nombre de points : </label>
<input type="number" id="numPoints" name="numPoints" value="500">
 || 
<label for="scale">1/Echelle : </label>
<input type="number" id="scale" name="scale" value="10">

</br>
<button type="button" onclick="ready();">Recalculer</button>

</br>
<p>
<b>Exemple d'une équation du premier ordre et solution : y'(t) = αy(t)</b>
</br>
Ci-dessus, nous avons tracé l'équation : y'(t) = αy(t). Avec α un paramètre variable.
</br>
Sur le graphique, nous observons des courbes rappelant la fonction exponentielle. 
</br></br>
En effet, intuitivement, nous pouvons trouver la solution de l'équation : y(t) = exp(αt). On aura alors : y'(t) = αexp(αt) = αy(t).
</br>
Les équations différentielles du premier ordre sont souvene simples à résoudre, cependant, lorsque l'ordre des équations augmentent, elles deviennent plus complexes voir impossible. 
Nous pourrons alors utiliser des modèlisations comme le graphique ci-dessus pour mieux les comprendre sans avoir besoin de trouver leurs solutions.
</br></br>

<b>Appliquation :</b></br>
Cette équation, pourtant très simple, peut nous permettre d'étudier les dynamiques de populations.
</br>
En effet, elle peut servir à modéliser la croissance d'une population.</br>
On aura :</br>
y' : correspondant à la vitesse de croissance de la population.</br>
y : correspondant à la taille de la population.</br>
α : correspondant au taux de croissance de la population.</br>
Avec notre équation : y'(t) = αy(t), nous obtenons une croissance de notre population (y') proportionelle à la taille de notre population (y) et notre taux de croissance (α).</br>
</br>
Les équations différentielles sont donc des outils puissants pour étudier des phénomènes où la variation d'un paramètre modifiera la vitesse de changement d'un autre paramètre ou du même paramètre.
</p>

<script src="/species-simulator.com/scripts/differential/differential1.js"></script>

</div>

</main>

<footer><?php readfile("../html/footer.html") ?></footer>

</body>

</html>