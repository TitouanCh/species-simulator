<!DOCTYPE html>
<html>
<head>
<title>Species Simulator</title>
<link rel='stylesheet' href='style.css'>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<body>
<header>
    <ul style="background: linear-gradient(0.25turn, #333 35%, #000);">
    <li style="width:280px;">
        <a href="/en/index.php" style="font-weight: bold; padding-left: 34px">
        <img class="species-simulator-logo" src="/img/logo4.png" height="36">Species-Simulator.com</a>
    </li>
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
    </li>
    <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Differential Equations</a>
        <div class="dropdown-content">
            <a href="/en/differential-equations/">Basic Differential Equations</a>
            <a href="/en/differential-equations/lotka-volterra.php">Lotka-Volterra</a>
        </div>
    <!-- <li><a href="/en/case-studies">Case Study</a></li> -->
    </li>
    <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Macroevolution</a>
        <div class="dropdown-content">
            <a href="/en/macroevolution/newick-tree-parser.php">Newick Tree Parser</a>
            <a href="/en/macroevolution/tree-fossil-generator.php">Tree and Fossil Data Generator</a>
        </div>
    </li>
    
    <li class="phone-menu">
        <input id="test" type="checkbox"/>
        <div class="phone-button" width="16">
          <object data="menu.svg" width="16" style="pointer-events: none;"></object>
        </div>
        <div class="phone-side-menu">
            <ul class="phone-list">
                <li id="phone-home" class="phone-list-item show">
                    <a href="index.php">Home</a>
                </li>
                <li id="phone-cellular-automata" class="phone-list-item show">
                    Cellular Automata
                </li>
                <li id="phone-other-automata" class="phone-list-item show">
                    Other Automata
                </li>
                <li id="phone-differential-equations" class="phone-list-item show">
                    Differential Equations
                </li>
                <li id="phone-macroevolution" class="phone-list-item show">
                    Macroevolution
                </li>
            </ul>
        </div>

        <script>
            itemsList = document.querySelector('.phone-list');

            const phoneCatalog = {
                "phone-cellular-automata" : ["<a href='/en/cellular-automata/'>Understanding Cellular Automata</a>", "<a href='/en/cellular-automata/game-of-life.php'>John Conway's Game of Life</a>", "<a href='/en/cellular-automata/species-simulator.php'>Species Simulator</a>"],
                "phone-other-automata" : ["<a href='/en/other-cellular-automata/particle-life.php'>Particle Life</a>"],
                "phone-differential-equations" : ["<a href='/en/differential-equations/'>Basic Differential Equations</a>", "<a href='/en/differential-equations/lotka-volterra.php'>Lotka-Volterra</a>"],
                "phone-macroevolution" : ["<a href='/en/macroevolution/newick-tree-parser.php'>Newick Tree Parser</a>", "<a href='/en/macroevolution/tree-fossil-generator.php'>Tree and Fossil Data Generator</a>"],
                "base" : ["<a href='index.php'>Home</a>", "Cellular Automata", "Other Automata", "Differential Equations", "Macroevolution"]
            };

            function addPhoneButton(text) {
                const newItem = document.createElement('li');
                newItem.innerHTML = text;
                newItem.classList.add("phone-list-item");
                itemsList.appendChild(newItem);
                setTimeout(() => {
                    newItem.classList.add('show');
                }, 10);
            }

            function phoneButtonClick() {
                let passed = false;
                itemsList.querySelectorAll(".phone-list-item").forEach((item) => {
                    if (this.innerHTML != item.innerHTML) {
                        item.classList.remove('show');
                        if (!passed) {item.classList.add("shrink");}
                        setTimeout(() => {
                            item.remove();
                        }, 400);
                    } else {
                        passed = true;
                        item.innerHTML = "← &nbsp; &nbsp; <b>" + item.innerHTML + "</b>";
                        item.onclick = phoneBackClick;
                    }
                });
                setTimeout(() => {
                    phoneCatalog[this.id].forEach((item) => {
                        addPhoneButton(item);
                    });
                }, 400);
                
            }

            function phoneBackClick() {
                itemsList.querySelectorAll(".phone-list-item").forEach((item) => {
                    item.classList.remove('show');
                    setTimeout(() => {
                        item.remove();
                    }, 400);
                });

                itemsList = document.querySelector('.phone-list');

                setTimeout(() => {
                    let _i = 0;
                    phoneCatalog["base"].forEach((item) => {
                        addPhoneButton(item);
                        console.log(itemsList.children);
                        if (_i == 1) {
                            itemsList.children[itemsList.children.length - 1].id = 'phone-cellular-automata';
                        }
                        if (_i == 2) {
                            itemsList.children[itemsList.children.length - 1].id = 'phone-other-automata';
                        }
                        if (_i == 3) {
                            itemsList.children[itemsList.children.length - 1].id = 'phone-differential-equations';
                        }
                        if (_i == 4) {
                            itemsList.children[itemsList.children.length - 1].id = 'phone-macroevolution';
                        }
                        _i++;

                        if (phoneCatalog[itemsList.children[itemsList.children.length - 1].id]) {itemsList.children[itemsList.children.length - 1].onclick = phoneButtonClick;};
                    });
                }, 400);
            }

            itemsList.querySelectorAll(".phone-list-item").forEach((item) => {
                if (phoneCatalog[item.id]) {item.onclick = phoneButtonClick};
            });

        </script>
    </li>
    </ul>
</header>
<main id = 'Species Simulator'>
<div class='article'>
<div id='Species Simulator' class='simulation_title'>
<h1>Species Simulator</h1>
<h2>Species Simulator - Species-Simulator.com</h2>
</div>
<div id='Species Simulator online simulator' class='online_simulator' style='text-align: center;'>
<canvas id='Species Simulator simulation' class='simulation_canvas'  width = '900' height='1525'>
</div>
<div id='Species Simulator parameters' class='simulation_parameters' style="background-color: #333; color: white; padding: 20px; text-align: center; border-radius: 20px;">

<label class="hiddenLabel" for="restartSim">Restart Simulation: </label>
<button id="restartSpeciesSim" onclick="species_simulation.start();"><object data="arrow_circle.svg" width="32" style="pointer-events: none;"></object></button>
<label class="hiddenLabel" for="pauseSim">Pause: </label>
<button id="restartSpeciesSim" onclick="species_simulation.pause = !species_simulation.pause; if (species_simulation.pause) {document.getElementById('restartSpeciesSimIcon').data = 'play.svg';} else {document.getElementById('restartSpeciesSimIcon').data = 'pause.svg';}"><object id="restartSpeciesSimIcon" data="pause.svg" width="32" style="pointer-events: none;"></object></button>

<hr style="background-color: black; border: none; height: 1px;">

<div style="margin-top: 25px; margin-bottom: 35px">
<div style="font-style: italic; margin-top: 10px; margin-bottom: 10px">Parameters --</div>
<label for="tableWidth">Table width: </label>
<input type="number" min="0" value="100" id="tableWidth"><br>
<label for="tableHeight">Table height: </label>
<input type="number" min="0" value="100" id="tableHeight"><br>
<label for="cellWidth">Cell width: </label>
<input type="number" min="0" value="100" id="cellWidth"><br>
<label for="cellHeight">Cell height: </label>
<input type="number" min="0" value="100" id="cellHeight"><br>
<label for="FPS">Generation per second: </label>
<input type="number" min="0" value="60" id="FPS"><br>
</div>

<hr style="background-color: black; border: none; height: 1px;">

<input id="addSpecies" type="button" value="Add a new species" onclick="species_simulation.add_species();">
<input id="deleteSpecies" type="button" value="Delete species" onclick="species_simulation.delete_species();">
<div id="speciesPanel" style="gap: 4px;"></div>

<br>
</div>
<div id='Species Simulator' description class='simulation_description'>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel tellus sodales, pulvinar velit sit amet, auctor est. Aenean porttitor ipsum ut neque pretium interdum. Maecenas facilisis quis nunc nec commodo. In hac habitasse platea dictumst. Curabitur libero libero, cursus sit amet purus eget, tempus vulputate metus. In sem augue, faucibus vel hendrerit a, gravida vel enim. Phasellus nec odio quam. In cursus nulla a luctus pellentesque. Cras eget ipsum eu est venenatis lobortis ac vel nulla. Aliquam et turpis interdum, eleifend purus et, consectetur lacus. Nulla efficitur accumsan augue vitae molestie. Ut vitae laoreet ante. Nullam dictum a turpis quis tempus.
</div>
<script src=./scripts/utils.js></script>
<script src=./scripts/Ssimulation.js></script>
<script src=./scripts/species-simulator/Species_Cell.js></script>
<script src=./scripts/species-simulator/species_simulator.js></script>
</div>
</main>
</body>
</html>
