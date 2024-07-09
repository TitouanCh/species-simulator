<html lang="en">
        <head>
            <title>Game of Life</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="Description" content="The Game of Life online in your browser, by famous mathematician John Conway.">
            <link rel="stylesheet" href="style.css">
            <link rel="icon" type="image/png" href="/favicon.png"/> 
            <?php include ("google-tag.php"); ?>
        </head>
        <body>
<?php include ("site-header.php"); ?>
<div id='content'>
<div class="article">
    <h1>John Conway's Game of Life</h1>
    <p class="short-intro">
<span style="color: #df8886; font-style: normal;">Summer 2020 ~ @TitouanCh</span><br>
    Discover the Game of Life from the famous mathematician John Conway. A cellular automaton in your browser.
    The Game of Life is easily one of if not the most famous cellular automaton. Despite it's simple rules, it can generates some remarquables structures.</p>
<div id='Game of Life online simulator' class='online_simulator' style='text-align: center;'>
<canvas id='Game of Life simulation' class='simulation_canvas'  width = '900' height='1525'>
</div>
<div id='Species Simulator parameters' class='simulation_parameters' style="background-color: #333; color: white; padding: 20px; text-align: center; border-radius: 20px; margin-top: 18px;">

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

<h2>John Conway</h1>

<div style="display: flex; gap: 30px;">
<div>
<p>John Conway <i>(1937-2020)</i> was an English mathematician from Liverpool.</p>
<p>In <i>October 1970</i>, Scientific American published a column featuring some of his work, most notably Conway's Game of Life, a mathematical game that generates structures and patterns resembling real-life phenomena.</p>
<p>Conway was once quoted as saying he hated the Game of Life because he felt it overshadowed much of his other work, and that after solving the game he found it uninteresting. However, later in his life, he retracted many of these statements, expressing reconciliation with the game and stating that he was quite proud of it.</p>
</div>
<div class="image-div"><img src="./images/conway.jpeg" alt="Mathematician John Horton Conway">Mathematician John Horton Conway</div>
</div>
<h2>Game of life and cellular automata</h1>
<div class="image-div"><img src="./images/conway_game_of_life.webp" alt="John Horton Conway playing the game of life on an old computer" height="300"><br>Conway playing Game of Life on a computer in 1970</div>
<p>The game of life is a cellular automaton. This means that the game is played on a grid of cells. At any point in time cells can be either dead or alive.</p>
<p>The game is not really a game in the sense that there is only one player. Cells evolve collectively across the grid, moving, appearing, and disappearing in each step according to three seemingly straightforward rules:</p>
<ul>
<li>An alive cell with 2 or 3 alive neighbors, stays alive.</li>
<li>A dead cell with 3 alive neighbors, is colonised (becomes alive).</li>
<li>All other cells stay dead or die.</li>
</ul>
<h2>My implementation</h1>
<p>There are various approaches to implementing the Game of Life, but they generally fall into two main categories:</p>
<ol>
<li><b>CPU-bound simulations:</b> The simplest method to implement the game of life is to create a grid of cells represented as a 2D array in CPU memory. The simulation progresses step by step by calculating the next state of each cell sequentially. This straightforward approach, though easy to understand, tends to be slow, especially as the grid size increases. In fact, its performance deteriorates exponentially with larger grids. While multi-threading in conjunction with space partitioning can be applied to improve speed, there are more efficient alternatives.</li>
<li><b>GPU-bound simulations:</b> A faster approach is to use the Graphics Processing Unit (GPU) to parallelize the Game of Life. The nature of the game makes it a perfect fit for GPU parallelization. GPUs are designed to handle lots of calculations simultaneously, which is exactly what is needed for updating thousands of cells at once.</li>
</ol>
<p>For my implementation, I decided to utilize OpenGL. Implementation the game of life into two fragment shaders. One that simply copies the current state to an image buffer and a second that applies the game rules to the buffer. This approach is very fast, and can be played straight into the browser using WebGL as seen above.</p>
<p>Using OpenGL and shaders not only makes the Game of Life run smoothly but also shows off how powerful GPUs can be for handling simple simulations like this. It's a cool way to quickly dive into both graphics programming, GPU parralelization and the world of cellular automata which was my goal for this project.</p>

</div>

<?php include ("site-side.php"); ?>
</div>
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
        </body>
    </html>