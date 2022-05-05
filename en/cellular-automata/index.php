<!DOCTYPE html>
<html lang= "en">
<head>
<title>What are Cellular Automatas ?</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/style.css">
<link rel="icon" type="image/png" href="/favicon.png"/>
<meta name="Description" content="Cellular Automata are fun to look at and can produce extremely complex behaviors, but what exactly are they ?">
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

<a class="skip-link" href="#main">Skip directly to the article</a>

<!-- Navigation Bar -->
<header><?php readfile("../html/navbar.html") ?></header></br>

<main id="main">

<div class="article" style = "text-align:center;">

<h1>Understanding Cellular Automata</h1>

<h2>Usually represented in the form of a grid with flickering lights, cellular automata evolve over time using habitually very simple rules.
Yet, they can somehow produce extremely complex behaviors...</h2>

<p>
A cellular automaton is a mathematical system that can be represented in the form of a table. 
The cells in the table typically only have two possible state : on or off corresponding to : alive or dead.
</p>

<img src="/img/cellular-automata/big-glider.png" alt="Un planeur issu du célèbre jeu de la vie de John Conway.">
<i>Example table : alive cells are white, dead cells are grey.</i>
</br>
</br>
<p>
<b>Calculating if a cell is dead or alive :</b>
</br>
To know if a cell is dead or alive we'll first need to define it's neighborhood.
</br>
</br>What's a neighborhood ? 
</br>
</br>It corresponds to the cells that we consider are neighbors to our cell. 
In a cellular automaton, the state of a cell will depend on the state of its neighbors. 
So, to calculate the state of our cell, we first need to define who are its neighbors. 
Usually, we'll pick relative positions corresponding to adjacent cells.</p>
<img src="/img/cellular-automata/neighbourhood-example.png" alt="Exemples differents de voisinage.">
<i>Different possible neighborhood examples : neighboors of the white cell are colored in blue.</i>
</br>
</br>
<p>
For every step of our simulation,
 each cell will simultaneously calculate it's next state depending on if it's neighbors are dead or alive.
</br>
</br>
In simpler cellular automata, each cell will simply add up its neirboring alive cells and depending on a set threshhold will become alive or stay dead.</br></br>
In <a href="game-of-life.php">Conway's Game of Life</a>, the most famous cellular automaton :</p>
<ul>
<li>An alive cell with 2 or 3 alive neighbors, stays alive.</br>
<li>A dead cell with 3 alive neighbors, is colonised (becomes alive).</br>
<li>All other cells stay dead or die.</br>
</ul>
</br>

More complex automata can have more complicated rules.
</br>
</br>
</p>

<img src="/img/cellular-automata/glider.gif" alt="Exemples differents de voisinage.">
<i>Glider structure found in the Game of Life, this structure is able to move forever in a direction.</i></br></br>
<p>
Despite their simple rules, cellular automata can produce extremely complex behaviors, that can result in chaotic or organised structures.
</p>
<img src="/img/cellular-automata/rule110.png" alt="Exemples differents de voisinage.">
<i>Elementary cellular automata</i>
</br>
</br>
<p>
Some might see in cellular automata an allegory of our own universe. The arguably simple and universal laws of physics allow objects (cells) to interact and produce complexe results.
They are also incredibly fun to interact with and watch.
</p>

</div>

</main>

<footer><?php readfile("../html/footer.html") ?></footer>

</body>

</html>