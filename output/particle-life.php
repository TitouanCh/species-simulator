<!DOCTYPE html>
<html>
<head>
<title>Particle Life</title>
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
<main id = 'Particle Life'>
<div class='article'>
<div id='Particle Life' class='simulation_title'>
<h1>Particle Life</h1>
<h2>Particle Life - Species-Simulator.com</h2>
<div id='Particle Life-short-description' class='short_description'>Each color or species interacts in a random way with other species. Particles can attract or repel each other leading to fun results. Try restarting the simulation multiple times until you find something interesting.</div></div>
<div id='Particle Life online simulator' class='online_simulator' style='text-align: center;'>
<canvas id='Particle Life simulation' class='simulation_canvas'  width = '900' height='1525'></canvas>
</div>
<div id='Species Simulator parameters' class='simulation_parameters' style="background-color: #333; color: white; padding: 20px; text-align: center; border-radius: 20px;">

<label for="enviroWidth">Enviro Width :</label>
<input type="number" id="enviroWidth" name="enviroWidth" value="1300" min="10" max="10000">
 || 
<label for="enviroHeight">Enviro Height :</label>
<input type="number" id="enviroHeight" name="enviroHeight" value="800" min="10" max="10000">

</br>
<label for="pause">Pause: </label>
<input id="pause" type="checkbox"/>

</br>

<button type="button" onclick="restart();">Restart</button>

</br>

<label for="fpsLimit">Image per second limit:</label>
<input id="fpsLimit" type="number" name="fpsLimit" value="120" min="1" max="2000">

</br>

<label for="nbEspece">Number of different species:</label>
<input type="number" id="nbEspece" name="nbEspece" value="6" min="1" max="8">

</br>

<label for="nbIndividus">Number of individuals:</label>
<input type="number" id="nbIndividus" name="nbIndividus" value="200" min="1" max="1000">

</br>

<label for="G">G:</label>
<input type="number" id="G" name="G" value="0.0981" min="0" max="10">

||

<label for="trail">Trail Modifier:</label>
<input type="number" id="trail" name="trail" value="0.3" min="0" max="1">

||

<label for="drag">1/Friction:</label>
<input type="number" id="drag" name="drag" value="0.98" min="0" max="1">

<br>

<label for="norme">Norm:</label>
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

<label for="partitioning">Space Partitioning: </label>
<input id="partitioning" type="checkbox" checked="true"/>

<label for="multithreading">Multithreading: </label>
<input id="multithreading" type="checkbox" checked="true"/>

</div>
<div id="particle-life-description" class='simulation_description'>

    <h2>What is particle life?</h2>

    <p>
        Particle life is a simulation that depicts life-like behavior arising from particles following a set of simple rules. Inspired by Clusters from Jeffrey Ventrella, we can observe in this simulation emergent behaviors reminding us of micro-organisms...
    </p>
        
    <h2>What are the rules of particle life?</h2>
    
    <p>
        Particle life is made up of many particles. You can see them flying around above. Each particle has the ability to either attract or repel other particles.
    </p>
    
    <p>
        How particles interact, if they repel or attract each other, is dependent on their color.
    </p>
    
    <p>
        At the start of the simulation, particles are randomly assigned a color, which represents their species. Next, each possible pair of colors (order matters) is assigned a random number. This random number will determine the nature of the interaction between the two colors: a negative number indicates an attractive force, while a positive number represents a repulsive force.
    </p>
    
    <table style ="max-width: 600px;">
        <tbody>
            <tr>
                <td style="background: lightgrey; width: 25%;"></td>
                <td style="background: #315465; color: white; font-weight: bold; width: 25%;">Blue</td>
                <td style="background: #597d64; color: white; font-weight: bold; width: 25%;">Green</td>
                <td style="background: #e8094a; color: white; font-weight: bold; width: 25%;">Red</td>
            </tr>
            <tr>
                <td style="background: #315465; color: white; font-weight: bold;">Blue</td>
                <td style="background: lightgrey;"></td>
                <td>1.8</td>
                <td>-5.2</td>
            </tr>
            <tr>
                <td style="background: #597d64; color: white; font-weight: bold;">Green</td>
                <td>-4.3</td>
                <td style="background: lightgrey;"></td>
                <td>0.7</td>
            </tr>
            <tr>
                <td style="background: #e8094a; color: white; font-weight: bold;">Red</td>
                <td>-3.2</td>
                <td>7.3</td>
                <td style="background: lightgrey;"></td>
            </tr>
        </tbody>
    </table>
    
    <div id="particle-life-table-caption" class="caption">Table with possible values</div>
    
    <p>
        Interactions don't have to be symmetrical. For example, in the table above: blue attracts green but green repels blue, this can result in an interesting glider effect.
    </p>
    
    <canvas id='Particle-Life-glider' class='glider_canvas' width=300 height=150></canvas>
    
    <div id="particle-life-table-caption" class="caption">Particle Life "Glider"</div>
    
    <p>
        The strength of particle interactions diminishes based on the distance between two particles. This distance is determined using a selected norm. Additionally, if two particles get too close, a strong repelling force is applied to prevent them from passing through each other.
    </p>
    
    <p>
        All these interactions can lead to endless energy creation in our simulation. We counteract this by adding a strong friction force to all particles, which prevents them from continuously accelerating.
    </p>
    
    <p>
        That's all there really is to it, still, even with those simple rules we can get some fun results.
    </p>
    
    <h2>
        How is it made?
    </h2>
    
    <p>
        My version of <b>particle life</b> is built using JavaScript entirely.
    </p>
    
    <p>
        However, due to the O(n²) complexity of each step in the simulation, as calculating the next position of each particle requires determining the resulting force from each other particle acting on it, we need to employ two methods to optimize the simulation.
    </p>
    
    <ul>
        <li>The first method is space partitioning, where we divide the simulation space into partitions. For each particle, we only need to calculate the interaction with particles from its partition and neighboring partitions.</li>
        <li>The second method is multithreading which is built on top of space partitioning. We can assign different partitions to different threads. The performance benefit of this method varies because serializing the data and sending it to the threads each frame proves to be quite expensive.</li>
    </ul>

</div>
<script src=./scripts/utils.js></script>
<script src=./scripts/Ssimulation.js></script>
<script src=./scripts/particle-life/particle_point.js></script>
<script src=./scripts/particle-life/particle_life.js></script>
<script src=./scripts/particle-life/glider.js></script>
</div>
</main>
</body>
</html>
