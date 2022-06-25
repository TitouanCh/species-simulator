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

<h1>Comprendre les automates cellulaires</h1>

<h2>Représenté par une grille, ils évoluent au cours du temps grâce à des règles simples les définissants. Pourtant, malgré ces règles simples, ils pourront aboutir à des résultats surprenants...</h2>
<p>
Les automates cellulaires sont des sytèmes mathématiques qui peuvent être représenté sous la forme d'un tableau 
 remplis de cases vides ou des cases pleine. On nomme ces cases "cellules" et on considera une cellule vivante si sa case est pleine et morte si sa case est vide. 
</p>

<img src="/species-simulator.com/img/cellular-automata/big-glider.png" alt="Un planeur issu du célèbre jeu de la vie de John Conway.">
</br>
</br>

<p>
Il existent de nombreux automates cellulaire mais malgré cela, les automates cellulaires présentent des caractéristiques communes :
 typiquement, on définira pour chaque cellule un voisinage, 
 c'est à dire un ensemble de position relative correspondant à des cellules voisines.
</p>

<p>
Ci-dessous, quelques exemples de voisinages possibles, les voisins de la case blanche sont coloré en bleu:
</p>
<img src="/species-simulator.com/img/cellular-automata/neighbourhood-example.png" alt="Exemples differents de voisinage.">

<p>
A chaque étape de notre simulation,
 les cellules calculeront simultanément leur prochaine état en fonction de leur voisinage et de règles définies en amont de la simulation.
</br>
</br>
Généralement, ces règles sont relativement simple et identiques pour toutes les cellules.
 Par exemple, le célèbre Jeu de la Vie ou Game of Life pour les bilingue,
 du mathématicien John Conway <a href="game-of-life.php">(retrouvé la page dédiée ici)</a>, peut être résumé en seulement 3 règles:
</br>
</br>
</p>
<ul>
<li>Une cellules possédant 2 ou 3 voisins en vie, se maintient.</br>
<li>Une cellule morte avec 3 voisins en vie est colonisée (devient vivante).</br>
<li>Tout autres cellules meurt ou restent mortes.</br>
</ul>
</br>
<img src="/species-simulator.com/img/cellular-automata/glider.gif" alt="Exemples differents de voisinage.">
<p>
Malgré leurs règles simple, les automates cellulaires pourront nous donner des résultats ordonnés tout comme chaotic et très complexes:
</p>
<img src="/species-simulator.com/img/cellular-automata/rule110.png" alt="Exemples differents de voisinage.">
</br>
</br>
<p>
Certains pourront y voir une allégorie de notre propre univers: un monde régit par les règles simples de la physiques, pourtant, extrêmement complexe. D'autres, plus humbles, y verrons tout de même des systèmes très agréable à observer.
</p>

</div>

</main>

<footer><?php readfile("../html/footer.html") ?></footer>

</body>

</html>