<!DOCTYPE html>
<html lang= "fr">
<head>
<title>Simulation de l'invasion des Lapins et l'impact sur les Wallabies en Australie</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png"/>
<meta name="Description" content="Modélisation et simulation de la relation entre les lapins : espèce envahissante et les wallabies : espèce endémique ainsi que différentes solutions.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src ="scripts/resizeIframe.js"></script>
</head>

<body>

<a class="skip-link" href="#main">Passer directement à l'article</a>

<header><?php readfile("html/navbar.html") ?></header></br>

<main id="main">

<div class="article">

<h1>L'invasion des lapins en Australie</h1>

<h2>Introduction :</h2>

<p>Pour mieux comprendre les interactions de compétition pour les ressources entre deux espèces, nous allons nous concentrer sur le cas des lapins et des wallabies.
En effet les wallabies sont des espèces menacées qui font l’objet de nombreuses tentatives de réintroductions en Australie.
Même si ce déclin est multifactoriel, les conséquences de l’introduction des lapins furent terribles.
En effet, en 1859, le Britannique Thomas Austin a importé 12 couples de lapins, aujourd’hui on en dénombre 200 millions.
Ces derniers se sont tellement multipliés que la compétition pour les ressources influe sur les populations de wallabies.
C’est notamment le cas pour les wallabies des rochers parmi lesquels 5 espèces sont menacées selon la liste rouge de l’UICN, le petit pétrogale (Petrogale concinna), le pétrogale d’Australie occidentale, (P. lateralis), le wallaby des rochers à queue en pinceau (P. penicillata), le pétrogale de Proserpine (P. persephone) et le pétrogale de sharman (P. sharmanii).
À travers l’étude des résultats de notre modèle nous tenteront de trouver des solutions viables afin protéger ces espèces.</p>

<h2>Objectifs :</h2>

<p>Nous cherchons à modéliser l'impact de cette importation sur l'espèce endemique à l'Australie: les wallabies.</p>

<img src="img/walliby.jpg" alt="walliby australie">


<h1>Le modèle : </h1>

<h2>Première simulation :</h2>

<p>Pour notre première simulation, introduisons d'abord des végétaux en vert puis des wallabies en marron clair afin de vérifier si les wallabies sont capables de s'implanter dans le milieu.</p>

<iframe src="php/simulation.php?preset=5" style="width:100%;border:none;" title="Simulation Wallabies et Végétaux" class="simulation" scrolling="no" onload="resizeIframe(this)"></iframe>


<h2>Ajout des lapins :</h2>

<p>Maintenant que nous avons vérifié que les wallabies sont capables de se développer dans leur milieu, introduisons les lapins en marron foncé. Nous les introduirons 500 générations après l'introduction des wallabies pour que ces derniers ai le temps de se développer, simulant ainsi la situation en Australie.</br></p>

<iframe src="php/simulation.php?preset=2" style="width:100%;border:none;" title="Simulation Wallabies, Lapins et Végétaux" class="simulation" scrolling="no" onload="resizeIframe(this)"></iframe>

<p>On observe une disparition rapide des wallabies après l'introduction des lapins.</p>


<h1>Solutions :</h1>

<p>Les Australiens ont réfléchis et employé diverses solutions afin de combattre l'invasion des lapins.</p>


<h2>La chasse intensive :</h2>

<p>Pour simuler une chasse intensive des lapins, réduisons de moitié l'esperance de vie des lapins.</p>

<iframe src="php/simulation.php?preset=6" style="width:100%;border:none;" title="Simulation Wallabies, Lapins et Végétaux avec Chasse Intensive des lapins" class="simulation" scrolling="no" onload="resizeIframe(this)"></iframe>


<h2>L'introduction du renard :</h2>

<p>Le renard étant un prédateur naturel des lapins sur le continent, les Australiens ont jugé bon de l'introduire en Australie.</p>

<iframe src="php/simulation.php?preset=7" style="width:100%;border:none;" title="Simulation Wallabies, Lapins, Renards et Végétaux" class="simulation" scrolling="no" onload="resizeIframe(this)"></iframe>



<h2>Utilisation de l'arme biologique :</h2>

<p>Après cet échec cuisant, les Australiens ont ensuite décidé d'intoduire un virus hautement contagieux tueur de lapin : la myxomatose.</p>

<iframe src="php/simulation.php?preset=8" style="width:100%;border:none;" title="Simulation Wallabies, Lapins, Renards et Myxomatose"class="simulation" scrolling="no" onload="resizeIframe(this)"></iframe>



<h2>Réserve naturelle :</h2>

<p>Enfin, les Australiens créent des réserves naturelles afin de sauvegardé les wallabies.</p>

<iframe src="php/simulation.php?preset=9" style="width:100%;border:none;" title="Simulation des réserves naturelles, Wallabies et Lapins" class="simulation" scrolling="no" onload="resizeIframe(this)"></iframe>

</div>

</main>

<footer><?php readfile("html/footer.html") ?></footer>

</body>