<!DOCTYPE html>
<html>
<head>
<title>Understanding Cellular Automatas</title>
<link rel='stylesheet' href='style.css'>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<body>
<header style="position: sticky; top: 0; width: 100%">
    <ul style="background: linear-gradient(0.25turn, #333 35%, #000);">
    <li><a href="/en/index.php" style="font-weight: bold;">LOGO -- Species-Simulator.com</a></li>
    <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Cellular Automata</a>
        <div class="dropdown-content">
            <a href="/en/cellular-automata/">Understanding Cellular Automata</a>
            <a href="/en/cellular-automata/game-of-life.php">John Conway's Game of Life</a>
            <!-- <a href="/en/cellular-automata/elementary-cellular-automata.php">Elementary Cellular Automata</a> -->
            <a href="/en/cellular-automata/species-simulator.php">Species Simulator</a>
        </div>
    </li>
    <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Other Automata</a>
        <div class="dropdown-content">
            <a href="/en/other-cellular-automata/particle-life.php">Particle Life</a>
        </div>
    </li><li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Differential Equations</a>
        <div class="dropdown-content">
            <a href="/en/differential-equations/">Basic Differential Equations</a>
            <a href="/en/differential-equations/lotka-volterra.php">Lotka-Volterra</a>
        </div>
    <!-- <li><a href="/en/case-studies">Case Study</a></li> -->
    </li><li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Macroevolution</a>
        <div class="dropdown-content">
            <a href="/en/macroevolution/newick-tree-parser.php">Newick Tree Parser</a>
            <a href="/en/macroevolution/tree-fossil-generator.php">Tree and Fossil Data Generator</a>
        </div>
    </li>
    
    <li class="phone-menu">
        <div class="phone-button" width="16" style="position: absolute; top: 16px; right: 16px;">
          <object data="menu.svg" width="16" style="pointer-events: none; filter: invert(100%);"></object>
        </div>
    </li>
    </ul>
    
    <script>
    function resizeTaskBar() {
        var phone = window.innerWidth < 1100;
        var phone_menu = document.getElementsByClassName("phone-menu")[0];
        var desktop_menu = document.getElementsByClassName("dropdown");
        if (phone) {
            phone_menu.style.display = "initial";
            for (let i = 0; i < desktop_menu.length; i++) {
                desktop_menu[i].style.display = "none";
            }
        }
        else {
            phone_menu.style.display = "none";
            for (let i = 0; i < desktop_menu.length; i++) {
                desktop_menu[i].style.display = "initial";
            }
        }
    }
    
    resizeTaskBar();
    addEventListener("resize", (event) => {resizeTaskBar()});
    </script>
</header>
<main id = 'Understanding Cellular Automatas'>
<div class='article'>
<div id='Understanding Cellular Automatas' class='simulation_title'>
<h1>Understanding Cellular Automatas</h1>
<h2>Understanding Cellular Automatas - Species-Simulator.com</h2>
</div>
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
</body>
</html>
