<!DOCTYPE html>
<html>
<head>
<title>Understanding Cellular Automatas</title>
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
<i style="text-align: center;">Example table : alive cells are white, dead cells are grey.</i>
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
<i style="text-align: center;">Different possible neighborhood examples : neighboors of the white cell are colored in blue.</i>
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
<i style="text-align: center;">Glider structure found in the Game of Life, this structure is able to move forever in a direction.</i></br></br>
<p>
Despite their simple rules, cellular automata can produce extremely complex behaviors, that can result in chaotic or organised structures.
</p>
<img src="/img/cellular-automata/rule110.png" alt="Exemples differents de voisinage.">
<i style="text-align: center;">Elementary cellular automata</i>
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
