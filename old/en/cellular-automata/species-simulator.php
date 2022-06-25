<!DOCTYPE html>
<html lang= "en">
<head>
<title>Online Species Simulator</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/style.css">
<link rel="icon" type="image/png" href="/favicon.png"/>
<meta name="Description" content="A simulator capable of simulating species free online, interactions between invasives and endemic species.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7406710081936352"crossorigin="anonymous"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VRLJ6ZZSXJ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-VRLJ6ZZSXJ');
</script>
</head>

<body>

<a class="skip-link" href="#main">Skip to article</a>

<header><?php readfile("../html/navbar.html") ?></header></br>

<main id="main">

<div class="article" style = "text-align:center;">
<h1>Species Simulator</h1>
<h2>An online stochastic species simulator, useful for studying interactions between invasive and endemic species...</h2>
<canvas id="board" width="500" height="500"></canvas>

</br>

<div style = "text-align:center;">
<div id = "compteur"></div> 

</br>

<input id="restartSim" type="button" value="Restart Simulation" onclick="restart();" />
<label class= "hiddenLabel" for="restartSim">Restart Simulation</label>
</br>

Pause : 
<input id="pause" type="checkbox"/>
<label class= "hiddenLabel" for="pause">Pause the simulation.</label>
</br>

Pause at a certain generation : <input type="number" min="0" value="100" id="pauseGenerationNumber"> <input id="pauseGeneration" type="checkbox"/>
<label class ="hiddenLabel" for="pauseGenerationNumber">Choose a generation at which the simulation will pause.</label>
<label class ="hiddenLabel" for="pauseGeneration">Activate the pause at a certain generation function.</label>

</br>
</br>

Width of table :
<input type="number" min="10" max="800" value="500" id="longueurTableau">
<label class ="hiddenLabel" for="longueurTableau">Select the width of the table.</label>

</br>

Height of table :
<input type="number" min="10" max="800" value="500" id="hauteurTableau">
<label class ="hiddenLabel" for="hauteurTableau">Select the height of the table.</label>

</br>

Width of cells :
<input type="number" min="1" max="200" value="10" id="longueurCase">
<label class ="hiddenLabel" for="longueurCase">Select the width of the cells.</label>

</br>

Height of cells :
<input type="number" min="1" max="200" value="10" id="hauteurCase">
<label class ="hiddenLabel" for="hauteurCase">Select the height of the cells.</label>

</br>

1/Probability of colonization on first pass :
<input type="number" min="100" max="100000" value="1000" id="probaParsemage">
<label class ="hiddenLabel" for="probaParsemage">Choose the probability that a cell will be colonize on the first pass/setup of the simulation.</label>

</br>

Generation per second :
<input type="number" min="1" max="120" value="60" id="FPS">
<label class ="hiddenLabel" for="FPS">Choose the number of generation per second.</label>

</br>
</br>

<input id="ajouterEspece" type="button" value="Add a new specie" onclick="ajouterEspece();" />
<input id="supprimerEspece" type="button" value="Delete a specie" onclick="supprimerEspece();" />
<div id= "gestionEspeces"></div>

<label class ="hiddenLabel" for="supprimerEspece">Delete a specie.</label>
<label class ="hiddenLabel" for="ajouterEspece">Add a new specie.</label>
</br>
</br>

<!-- Telechargement du CSV -->
<input id="downloadCSV" type="button" value="Download data in .CSV format" onclick="downloadCSV(especesDataCached);" />
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

<footer><?php readfile("../html/footer.html") ?></footer>

</body>

<script src="/scripts/species-simulator/case.js"></script>
<script src="/scripts/species-simulator/graphEN.js"></script>
<script src="/scripts/species-simulator/exportCSV.js"></script>
<script src ="/scripts/species-simulator/simulationEN.js"></script>

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