<!DOCTYPE html>
<html lang= "fr">
<head>
<title>Comment marche notre simulateur d'espèces ?</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png"/>
<meta name="Description" content="Comment fonctionne notre simulateur d'espèce en ligne.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src ="scripts/resizeIframe.js"></script>
</head>

<body>

<a class="skip-link" href="#main">Passer directement à l'article</a>

<header><?php readfile("html/navbar.html") ?></header></br>

<main id="main">

<div class="article">
<h1>Comment ça marche ?</h1>

<h2>Introduction :</h2>

<p>Bienvenue sur notre site internet. Nous cherchons ici à simuler la compétition entre espèces pour l’accès aux ressources de leur environnement. Nous avons mis au point un modèle à l'aide d'outils informatiques et mathématiques. Vous pouvez le voir en action <a href="index.html">ici</a>. Ci-dessous, nous vous aiderons à comprendre son fonctionnement.</p>

<h2>I-	Une vue simplifiée</h2>

<h3>a)	Les espèces</h3>

<p>Pour mieux comprendre le modèle, prenons un exemple simple :</p>

<img src="img/img1_2_squares.png" alt="tableau simple avec 2 carrés">

<p>Plaçons-nous dans le cas simple d’une compétition entre deux espèces : ici, nous avons un carré bleu clair représentant un individu de l’espèce 1 et un carré bleu foncé représentant un individu de l’espèce 2.</p>

<h3>b)	Modélisation de l’environnement et de ses ressources</h3>

<p>Pour étudier la relation entre ces deux espèces il nous faut d’abord définir un environnement où elles pourront évoluer. Nous avons fait le choix de modéliser ce dernier par un tableau :</p>

<img src="img/img2_empty_table.png" alt="tableau vide">
 
<p>Nous avons également besoin de ressources que les espèces pourront se partager. Nous avons donc choisi de considérer chaque case du tableau comme étant équivalente à une ressource. Par conséquent, un environnement schématisé par un tableau 3x3 contiendra, au total, 9 ressources et un environnement schématisé par un tableau 9x9 contiendra, au total, 81 ressources.</p>
 
<img src="img/img3_total_ressources.png" alt="tableau explication ressources">
 
<p>Il en découle la première règle de notre simulation : chaque ressource, ou case, ne peut être exploitée que par un seul individu à la fois. Par conséquent, à un instant t, une case ne peut être occupée que par un individu. Dans notre exemple, une case, ou ressource, aura donc trois états possibles, nous avons choisi de représenter ces différents états par une valeur comprise entre 0 et 2 :
<ul><li><b>Premier état possible :</b> La case est vide, elle aura alors une valeur de 0.
<li><b>Deuxième état possible :</b> Un individu de l’espèce 1 (bleu clair) occupe la case, elle aura une valeur de 1.
<li><b>Troisième état possible :</b> Un individu de l’espèce 2 (bleu foncé) occupe la case, elle aura une valeur de 2.
</ul></br>Nous pouvons ensuite colorer les cases selon leur valeur donnant le résultat suivant :</p>

<img src="img/img4_ajout_des_couleurs.png" alt="tableau des espèces avec ajout des couleurs">

</br>En occupant une case, les individus sont « nourris » et, si nous n’introduisons pas d’autres paramètres dans le modèle, ils perdureront indéfiniment.</p>

<h3>c)	Reproduction</h3>

<p>Maintenant que nos espèces peuvent exploiter les ressources de leur environnement en occupant les cases du tableau, il faut leur permettre de se reproduire. Il nous faut introduire une nouvelle notion, celle de la génération : à chaque génération, notre programme devra calculer si les individus de notre simulation se reproduisent ou non. Pour cela, nous devrons assigner, à chaque espèce, un taux de reproduction au début de la simulation. Puis, à chaques génération, le programme parcourra toutes les cases <b>vides</b> du tableau et effectuera une série de calculs particuliers :</p>

<p><b>1-</b>	D’abord, il cherche les cases adjacentes de la case vide :</p>

<img src="img/img5_cases_adjacentes_voisins.png" alt="tableau cases adjacentes">

<p>Les cases adjacentes de x sont représentés en rouge.</p>

<p><b>2-</b>	Pour chaque case adjacente peuplé par une espèce, le programme tire un chiffre aléatoire compris entre 1 et 100. Si le chiffre obtenu est inférieur au taux de reproduction de l’espèce, alors, l’espèce marque 1 point pour cette case, sinon, elle ne gagne pas de points.</p>

<p><b>3-</b>	Enfin, le programme comptabilise les points, s’il y a une égalité ou si aucune espèce n’a marqué de points, la case reste vide, sinon, un nouvel individu de l’espèce gagnante est créé sur cette case.</p>
 
<img src="img/img6_mega_recap.png" alt="tableau récapitulatif">

</br>

<img src="img/img7_mega_recap2.png" alt="résumé bilan de l'algorithme">

<p>La base du modèle est maintenant en place :</p>

<iframe src="php/simulation.php?preset=1" style="width:100%;border:none;" title="simulation basique" scrolling="no" onload="resizeIframe(this)"></iframe>

<h2>II-	Paramètres additionnels</h2>

<p>Nous pouvons maintenant ajouter de nouveaux paramètres et de nouvelles règles afin de complexifier le modèle.</p>

<h3>a)	Espérance de vie</h3>

<p>Pour chaque espèce, nous pouvons introduire une notion d’espérance de vie, c’est-à-dire, un nombre maximal de génération assigné à chaque individu. Une fois le nombre atteint, l'individu « meurt », libérant la case qu'il occupait. Par exemple, si notre espèce bleu clair a une espérance de vie de 3, et qu’un nouvel individu de cette espèce est créé sur une case, alors, cet individu occupera cette case pendant 3 générations.</p>

<h3>b)	Taux de prédation</h3>

<p>Nous pouvons ajouter un taux de prédation pour que les espèces puissent se reproduire sur des cases déjà occupées, simulant ainsi relation proie-prédateur. Ce taux de prédation est interprété de la même manière que le taux reproduction mais en examinant seulement les cases occupées au lieu des cases vides.  Par exemple, si pour une case donnée occupée par un individu de l'espèce 1 on a des cases adjacentes occupées en grande majorité par des individus de l'epèce 2, alors l'individu de l'espèce 1 a de forte probabilités de se faire « manger » par l'espèce 2. Cette probabilité sera modulée par le taux de prédation de l'espèce 2, que nous définirons au début de notre simulation. 
</p>
</div>

</main>

<footer><?php readfile("html/footer.html") ?></footer>

</body>