<html lang="en">
        <head>
            <title>Particle Life Online</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="Description" content="Recreation of the automaton : Particle Life, available online in your browser.">
            <link rel="stylesheet" href="style.css">
            <link rel="icon" type="image/png" href="/favicon.png"/> 
            <?php include ("google-tag.php"); ?>
        </head>
        <body>
<?php include ("site-header.php"); ?>
<div id='content'>
<div class="article">
    <h1>Particle life</h1>
    <p class="short-intro">
<span style="color: #df8886; font-style: normal;">Winter 2021 ~ @TitouanCh</span><br>
Particle Life - Species-Simulator.com
Inspired by Clusters from Jeffrey Ventrella, we can observe in this simulation emergent behaviors reminding us of micro-organisms...
</p>

<div id='Particle Life online simulator' class='online_simulator' style='text-align: center;'>
<canvas id='Particle Life simulation' class='simulation_canvas'  width = '900' height='1525'>
</div>
<div id='Species Simulator parameters' class='simulation_parameters' style="background-color: #333; color: white; padding: 20px; text-align: center; border-radius: 20px; margin-top: 12px;">

<label for="enviroWidth">Enviro Width :</label>
<input type="number" id="enviroWidth" name="enviroWidth" value="1300" min="10" max="10000">
 || 
<label for="enviroHeight">Enviro Height :</label>
<input type="number" id="enviroHeight" name="enviroHeight" value="800" min="10" max="10000">

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
<input type="number" id="trail" name="trail" value="0.8" min="0" max="1">

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
<b>Performance (BETA)--</b> <br>

<label for="partitioning">Space Partitioning : </label>
<input id="partitioning" type="checkbox"/>

<label for="multithreading">Multithreading : </label>
<input id="multithreading" type="checkbox"/>



<br>
</div>

<script>
    document.getElementById('enviroWidth').value = parseInt(document.getElementsByClassName("simulation_canvas")[0].parentElement.offsetWidth)
</script>

<script src=./scripts/utils.js></script>
<script src=./scripts/Ssimulation.js></script>
<script src=./scripts/particle-life/particle_point></script>
<script src=./scripts/particle-life/particle_life></script>

<h2>What is particle life?</h2>

<p>Particle life is a simulation that depicts life-like behavior arising from particles following a set of simple rules. Particle life reminds me a lot of John Conway’s game of life in that sense. However, the execution and mechanics of these two models differ significantly.</p>

<h2> What are the rules of particle life?</h2>

<p>Particle life is made up of many particles. You can see them flying around above. Each particle has the ability to either attract or repel other particles.</p>

<p>How particles interact, if they repel or attract each other, is dependent on their color.
At the start of the simulation, particles are randomly assigned a color, which represents their species. Next, each possible pair of colors (order matters) is assigned a random number. This random number will determine the nature of the interaction between the two colors: a negative number indicates an attractive force, while a positive number represents a repulsive force.
</p>

    <table style ="max-width: 600px;">
    <caption>Table with possible values</caption>
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

<p>Interactions don’t have to be symmetrical. For example, in the table above: blue attracts green but green repels blue, this can result in an interesting glider effect.</p>

    <canvas id='Particle-Life-glider' class='glider_canvas' width=300 height=150></canvas>
    
    <div id="particle-life-table-caption" class="caption">Particle Life "Glider"</div>

<p>The strength of particle interactions diminishes based on the distance between two particles. This distance is determined using a selected norm. Additionally, if two particles get too close, a strong repelling force is applied to prevent them from passing through each other.</p>

<p>All these interactions can lead to endless energy creation in our simulation. We counteract this by adding a strong friction force to all particles, which prevents them from continuously accelerating.</p>

<p>That's all there really is to it, still, even with those simple rules we can get some fun results.</p>

<h2> How is it made?</h2>

<p>Particle life is built using JavaScript entirely.</p>

<p>However, due to the O(n^2) complexity of each step in the simulation, as calculating the next position of each particle requires determining the resulting force from each other particle acting on it, we need to employ two methods to optimize the simulation.</p>

<ul>
<li>The first method is space partitioning, where we divide the simulation space into partitions. For each particle, we only need to calculate the interaction with particles from its partition and neighboring partitions.</li>

<li>The second method is multithreading which is built on top of space partitioning. We can assign different partitions to different threads. The performance benefit of this method varies because serializing the data and sending it to the threads each frame proves to be quite expensive.</li>
</ul>
</div>
<script src=./scripts/particle-life/glider.js></script>
<?php include ("site-side.php"); ?>
</div>
        </body>
    </html>