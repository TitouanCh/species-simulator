<!DOCTYPE html>
<html>
<head>
<title>Game of Life</title>
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
<main id = 'Game of Life'>
<div class='article'>
<div id='Game of Life' class='simulation_title'>
<h1>Game of Life</h1>
<h2>Game of Life - Species-Simulator.com</h2>
<div id='Game of Life-short-description' class='short_description'>Discover the Game of Life from the famous mathematician John Conway. A cellular automaton in your browser...</div></div>
<div id='Game of Life online simulator' class='online_simulator' style='text-align: center;'>
<canvas id='Game of Life simulation' class='simulation_canvas'  width = '900' height='1525'></canvas>
</div>
<div id='Species Simulator parameters' class='simulation_parameters' style="background-color: #333; color: white; padding: 20px; text-align: center; border-radius: 20px;">

<button type="button" onclick="unpause();">Pause/Play</button>

<button type="button" onclick="restartRegular();">Restart</button>

<button type="button" onclick="restartClear();">Clear</button>

<button type="button" onclick="restartRandomize();">Randomize</button>

<label for="fpsLimit">Image per second limit:</label>
<input id="fpsLimit" type="number" name="fpsLimit" value="120" min="1" max="2000">

</br>

<label for="brush">Structure to spawn on mouse click :</label>

<select name="pattern" id="brush">
    <option value="glider">Glider</option>
    <option value="square">Square</option>
    <option value="r-pentomino">R-Pentomino</option>
    <option value="boat">Boat</option>
    <option value="oscillator">Oscillator</option>
</select>

</br>
Certain parameters might require a restart to take effect.
</br>

<label for="pointSize">Cell size :</label>
<input type="number" id="pointSize" name="pointSize" value="2.0" min="1" max="200">
    || 
<label for="borderSize">Size between cells :</label>
<input type="number" id="borderSize" name="borderSize" value="1.0" min="1" max="200">

</br>

<label for="borderSize">Grid Width :</label>
<input type="number" id="displayWidth" name="displayWidth" value="1260" min="10" max="10000">
    || 
<label for="borderSize">Grid Height :</label>
<input type="number" id="displayHeight" name="displayHeight" value="840" min="10" max="10000">

<label for="seed">Seed (Long primes works best):</label>
<input type="number" id="seed" name="seed" min="0.0" max="100">

</div>
<div id='Game of Life' description class='simulation_description'>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel tellus sodales, pulvinar velit sit amet, auctor est. Aenean porttitor ipsum ut neque pretium interdum. Maecenas facilisis quis nunc nec commodo. In hac habitasse platea dictumst. Curabitur libero libero, cursus sit amet purus eget, tempus vulputate metus. In sem augue, faucibus vel hendrerit a, gravida vel enim. Phasellus nec odio quam. In cursus nulla a luctus pellentesque. Cras eget ipsum eu est venenatis lobortis ac vel nulla. Aliquam et turpis interdum, eleifend purus et, consectetur lacus. Nulla efficitur accumsan augue vitae molestie. Ut vitae laoreet ante. Nullam dictum a turpis quis tempus.
</div>
<script id="vertex-shader-2d" type="notjs">
attribute vec2 a_coord;

uniform vec2 u_resolution;
uniform vec2 u_size;

varying vec2 v_size;
varying vec2 v_coord;
varying vec2 v_resolution;

void main() {
    gl_PointSize = u_size.x*2.0;
    
    vec2 pos = vec2(a_coord.x * 2.0 - 1.0, a_coord.y * 2.0 - 1.0);

    v_coord = a_coord;
    v_resolution = u_resolution;
    v_size = u_size;

    gl_Position = vec4(pos, 0, 1);
}
</script>
    
<script id="fragment-shader-2d" type="notjs">
precision mediump float;

uniform sampler2D u_texture;
uniform float u_once;
uniform vec3 u_mouse;
uniform float u_mouse_data;

varying vec2 v_size;
varying vec2 v_coord;
varying vec2 v_resolution;

float rand(vec2 co) {
    if (u_once < 1.0) {
        return fract(sin(dot(co.xy ,vec2(12.9898, 78.233))) * 43758.5453 * u_once);
    }
    return fract(sin(dot(co.xy ,vec2(u_once, 78.233))) * u_once);
}

vec2 normalizeVec(vec2 a) {
    vec2 result = (a + vec2(1.0, 1.0)) / vec2(2.0, 2.0);
    return result;
}

vec2 unNormalizeVec(vec2 b) {
    vec2 result = (b * vec2(2.0, 2.0)) - vec2(1.0, 1.0);
    return result;
}

int get(vec2 offset) {
    if ( (texture2D(u_texture, unNormalizeVec(((normalizeVec(v_coord) * v_resolution) + offset) / v_resolution))).b > 0.9 ) {
        return int(1);
    }
    return int(0);
}

float toBinary(float s) {
    float n = 0.0;
    float source = s;
    if (source >= 256.0) {
        n += 100000000.0;
        source -= 256.0;
    }
    if (source >= 128.0) {
        n += 10000000.0;
        source -= 128.0;
    }
    if (source >= 64.0) {
        n += 1000000.0;
        source -= 64.0;
    } 
    if (source >= 32.0) {
        n += 100000.0;
        source -= 32.0;
    }
    if (source >= 16.0) {
        n += 10000.0;
        source -= 16.0;
    }
    if (source >= 8.0) {
        n += 1000.0;
        source -= 8.0;
    }
    if (source >= 4.0) {
        n += 100.0;
        source -= 4.0;
    }
    if (source >= 2.0) {
        n += 10.0;
        source -= 2.0;
    }
    if (source >= 1.0) {
        n += 1.0;
        source -= 1.0;
    }

    return n;
}


void main() {
    if (u_once > 0.0) {
        gl_FragColor = vec4(v_coord, cos(rand(v_coord)), 1);
    } else {
        vec2 offset = vec2((v_size.x + v_size.y));
        int sum =
        get(vec2(-1.0, -1.0) * offset) +
        get(vec2(-1.0,  0.0) * offset) +
        get(vec2(-1.0,  1.0) * offset) +
        get(vec2( 0.0, -1.0) * offset) +
        get(vec2( 0.0,  1.0) * offset) +
        get(vec2( 1.0, -1.0) * offset) +
        get(vec2( 1.0,  0.0) * offset) +
        get(vec2( 1.0,  1.0) * offset);
        
        if (sum == 3) {
            gl_FragColor = vec4(v_coord, 1.0, 1.0);
        }
        else if (sum == 2){
            gl_FragColor = texture2D(u_texture, v_coord);
        } else {
            gl_FragColor = vec4(0.0, 0.0, 0.0, 1.0);
        }
        
        if (u_mouse.z > 0.0) {
            
            float data = u_mouse_data;
            float previous = 0.0;
            
            for (float i = 0.0; i < 3.0; i++) {
                float currentlyLooking = pow(10.0, i) * 10.0;
                float currentData = floor(mod(data, currentlyLooking));
                currentData -= previous;
                previous += currentData;
                
                currentData = currentData / currentlyLooking * 10.0;
                
                currentData = toBinary(currentData);
                
                float previous2 = 0.0;
                
                for (float j = 0.0; j < 3.0; j++) {
                    float currentlyLooking2 = pow(10.0, j) * 10.0;
                    float currentData2 = floor(mod(currentData, currentlyLooking2));
                    currentData2 -= previous2;
                    previous2 += currentData2;
                    
                    currentData2 = currentData2 / currentlyLooking2 * 10.0;
                    
                    
                    if (currentData2 > 0.0) {
                        vec2 nemo = vec2(j, i) * offset;
                        vec2 dory = unNormalizeVec(((normalizeVec(u_mouse.xy) * v_resolution) + nemo) / v_resolution);
                        
                        if (abs(v_coord.y - dory.y) + abs(v_coord.x - dory.x) < 0.000001) {
                            gl_FragColor = vec4(1.0, 1.0, 1.0, 1.0);
                        }
                        
    
                    }
                    
                }
                
            }
        }
    }
    
}
</script>

<script id="copy-shader-2d" type="notjs">
precision mediump float;

uniform sampler2D u_texture;
varying vec2 v_coord;

void main() {
    gl_FragColor = texture2D(u_texture, v_coord);
}
</script>
<script src=./scripts/utils.js></script>
<script src=./scripts/Ssimulation.js></script>
<script src=./scripts/game-of-life/GoL.js></script>
</div>
</main>
</body>
</html>
