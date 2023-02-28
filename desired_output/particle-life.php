<!DOCTYPE html>
<html>
<head>
<title>Particle Life</title>
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
<main id = 'Particle Life'>
<div class='article'>
<div id='Particle Life' class='simulation_title'>
<h1>Particle Life</h1>
<h2>Particle Life - Species-Simulator.com</h2>
</div>
<div id='Particle Life online simulator' class='online_simulator' style='text-align: center;'>
<canvas id='Particle Life simulation' class='simulation_canvas'  width = '900' height='1525'>
</div>
<div id='Species Simulator parameters' class='simulation_parameters' style="background-color: #333; color: white; padding: 20px; text-align: center; border-radius: 20px;">

<label for="enviroWidth">Enviro Width :</label>
<input type="number" id="enviroWidth" name="enviroWidth" value="1300" min="10" max="10000">
 || 
<label for="enviroHeight">Enviro Height :</label>
<input type="number" id="enviroHeight" name="enviroHeight" value="800" min="10" max="10000">

<script id="simpleSizer">
//var sizerWidth = document.getElementById('content').clientWidth;
//document.getElementById("enviroWidth").value = sizerWidth/1.5;
</script>

</br>
<label for="pause">Pause : </label>
<input id="pause" type="checkbox"/>

</br>

<button type="button" onclick="restart();">Restart</button>

</br>

<label for="fpsLimit">Image per second limit :</label>
<input id="fpsLimit" type="number" name="fpsLimit" value="120" min="1" max="2000">

</br>

<label for="nbEspece">Number of different species :</label>
<input type="number" id="nbEspece" name="nbEspece" value="6" min="1" max="8">

</br>

<label for="nbIndividus">Number of individuals :</label>
<input type="number" id="nbIndividus" name="nbIndividus" value="200" min="1" max="1000">

</br>

<label for="G">G :</label>
<input type="number" id="G" name="G" value="0.0981" min="0" max="10">

<label for="trail">Trail Modifier :</label>
<input type="number" id="trail" name="trail" value="0.3" min="0" max="1">

||

<label for="drag">1/Friction :</label>
<input type="number" id="drag" name="drag" value="0.98" min="0" max="1">

<br>

<select name="norme" id="norme">
    <option value="norme2">Euclian</option>
    <option value="norme1">Absolute</option>
    <option value="max">max</option>
    <option value="exponential">exponential</option>
    <option value="weird">Weird</option>
</select>


</br>
</br>
<b>Performance --</b> <br>

<label for="partitioning">Space Partitioning : </label>
<input id="partitioning" type="checkbox" checked="true"/>

<label for="multithreading">Multithreading : </label>
<input id="multithreading" type="checkbox" checked="true"/>

</div>
<div id='Particle Life' description class='simulation_description'>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel tellus sodales, pulvinar velit sit amet, auctor est. Aenean porttitor ipsum ut neque pretium interdum. Maecenas facilisis quis nunc nec commodo. In hac habitasse platea dictumst. Curabitur libero libero, cursus sit amet purus eget, tempus vulputate metus. In sem augue, faucibus vel hendrerit a, gravida vel enim. Phasellus nec odio quam. In cursus nulla a luctus pellentesque. Cras eget ipsum eu est venenatis lobortis ac vel nulla. Aliquam et turpis interdum, eleifend purus et, consectetur lacus. Nulla efficitur accumsan augue vitae molestie. Ut vitae laoreet ante. Nullam dictum a turpis quis tempus.
</div>
<script src=./scripts/utils.js></script>
<script src=./scripts/Ssimulation.js></script>
<script src=./scripts/particle-life/particle_point></script>
<script src=./scripts/particle-life/particle_life></script>
</div>
</main>
</body>
</html>
