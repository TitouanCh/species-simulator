<!DOCTYPE html>
<html>
<head>
<title>Species Simulator</title>
<link rel='stylesheet' href='style.css'>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<main id = 'Species Simulator'>

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

<main id="content">
<div class="article">
<header>
<div id='Species Simulator' class='simulation_title'>
<h1>Species Simulator</h1>
<h2>Species Simulator - Species-Simulator.com</h2>
</div>
</header>

<div>
<div id='Species Simulator online simulator' class='online_simulator' style="text-align: center;">
<canvas id='Species Simulator simulation' class='simulation_canvas'  width = '900' height='900'>
</div>

<div id='Species Simulator parameters' class='simulation_parameters' style="background-color: #333; color: white; padding: 20px; text-align: center; border-radius: 20px;">
<div style="font-style: italic;">Parameters --</div><hr style="background-color: black; border: none; height: 1px;">
<label for="tableWidth">Table width: </label>
<input type="number" min="0" value="100" id="tableWidth"><br>
<label for="tableHeight">Table height: </label>
<input type="number" min="0" value="100" id="tableHeight"><br>
<label for="cellWidth">Cell width: </label>
<input type="number" min="0" value="100" id="cellWidth"><br>
<label for="cellHeight">Cell height: </label>
<input type="number" min="0" value="100" id="cellHeight"><br><br><hr style="background-color: black; border: none; height: 1px;">
<label class="hiddenLabel" for="restartSim">Restart Simulation: </label>
<button id="restartSpeciesSim" onclick="restart();"><object data="arrow_circle.svg" width="32" style="pointer-events: none;"></object></button>
</div>

<script src='./scripts/utils.js'></script>
<script src='./scripts/Ssimulation.js'></script>
<script src='./scripts/Species_Cell.js'></script>
<script src='./scripts/species_simulator.js'></script>
</div>

<div id='Species Simulator' description class='simulation_description'>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel tellus sodales, pulvinar velit sit amet, auctor est. Aenean porttitor ipsum ut neque pretium interdum. Maecenas facilisis quis nunc nec commodo. In hac habitasse platea dictumst. Curabitur libero libero, cursus sit amet purus eget, tempus vulputate metus. In sem augue, faucibus vel hendrerit a, gravida vel enim. Phasellus nec odio quam. In cursus nulla a luctus pellentesque. Cras eget ipsum eu est venenatis lobortis ac vel nulla. Aliquam et turpis interdum, eleifend purus et, consectetur lacus. Nulla efficitur accumsan augue vitae molestie. Ut vitae laoreet ante. Nullam dictum a turpis quis tempus.
</div>

</div>
</main>

</body>
</html>
