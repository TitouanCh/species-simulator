<html lang="en">
        <head>
            <title>Lotka Volterra equations</title>
            <meta
            name="description"
            content="The famous lotka volterra predator-prey equations differential equations illustrated in the browser">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="style.css">
            <link rel="icon" type="image/png" href="/favicon.png"/> 
            <?php include ("google-tag.php"); ?>
        </head>
        <body>
<?php include ("site-header.php"); ?>
<div id='content'>
<div class="article">
    <h1>Lotka Volterra</h1>
    <p class="short-intro">
<span style="color: #df8886; font-style: normal;">Summer 2021 ~ @TitouanCh</span><br>
Lotka Volterra equations are a system of differential equations used to model interactions between different species...
</p>

<canvas id="differential" width="800" height="800"></canvas>

<script id="simpleSizer">
var sizerWidth = document.getElementById('content').clientWidth;
document.getElementById("differential").width = document.getElementById("differential").parentElement.offsetWidth;
</script>

<div id='Species Simulator parameters' class='simulation_parameters' style="background-color: #333; color: white; padding: 20px; text-align: center; border-radius: 20px; margin-top: 18px;">

Pause : 
<input id="pause" type="checkbox"/>
 || 
Axes : 
<input id="axes" type="checkbox"/>

</br>

Values :

<label for="alpha-equation">Alpha : </label>
<input type="number" id="alpha-equation" name="alpha-equation" style = "width:30px; text-align:center;" value="2.5">,

<label for="beta-equation">Beta : </label>
<input type="number" id="beta-equation" name="beta-equation" style = "width:30px; text-align:center;" value="-0.2">,

<label for="delta-equation">Delta : </label>
<input type="number" id="delta-equation" name="delta-equation" style = "width:30px; text-align:center;" value="0.4">,

<label for="gamma-equation">Gamma : </label>
<input type="number" id="gamma-equation" name="gamma-equation" style = "width:30px; text-align:center;" value="-3">,


<br>

<label for="dlength">Vector Size : </label>
<input type="number" id="dlength" name="dlength" value="0.1">

</br>

<label for="numPoints">Number of points : </label>
<input type="number" id="numPoints" name="numPoints" value="5000">
 || 
<label for="scale">1/Scale : </label>
<input type="number" id="scale" name="scale" value="50">

</br>
<hr style="background-color: #292929;">
<button type="button" onclick="ready();">Initialize</button>

</br>
</div>

<h2 id="General-Knowledge-about-Lotka-Volterra">General Knowledge about Lotka Volterra</h2>

<p>
In the 1920's Alfred <b>Lotka</b> and Vito <b>Volterra</b> independently proposed the first mathematical model describing a predator-prey relationship.</br>
</br>
This discovery would give birth new discipline: mathematical ecology or theorical ecology, the science of using mathematical, computational and conceptual models to study ecological systems like population dynamics or ecosystem interrelationships.</br>
</br>


Above, you can see the predator-prey Lotka-Volterra model represented in a vector field. You can easily observe the cyclic nature of the model. It’s made by scattering random points on a graph, with the x coordinates and y coordinates representing the prey and predator population respectively. Then we can use our differential equations described below to draw a vector toward the next estimated position of our data point.</br></br>

It's quite enjoyable to look at, have a go at changing the various parameters and see if you can make some abstract art. The graph’s colors evolve over time.
</br>
</br>
If the simulation is making your browser slow down, try lowering the number of points or pausing the Lotka Volterra simulation.</br>
</p>

<h2 id = "Two-types-of-Lotka-Volterra-models">Two types of Lotka Volterra models</h2>
<p>
There are two types of Lotka-Volterra equations, let's take a look at the expression of their derivative</br>
</br>
The <b id = "Lotka-Volterra-predator-prey-model">Lotka Volterra predator prey model</b>:</br>
</br>
<img src="/img/differential-equations/lotka-volterra-predator-prey.png" alt="Lotka-Volterra predator prey model equation"></br>
Discovered first and the simpler version of the two, it's the model we chose to represent above in a vector field.</br> <br>
Frequently used to describe a system in which a predator and a prey interact. It can only simulate interactions between two species.</br>
<!--To learn more, click here.</br>--> 
</br>
and the <b id = "Lotka-Volterra-competition-model">Lotka Volterra competition model</b>:</br>
</br>
<img src="/img/differential-equations/lotka-volterra-competition-model.png" alt="Lotka-Volterra competition model"></br>
Similar to the predator-prey model, this model takes into account any N species and can simulate more diverse interactions (predator-prey, mutualism, etc...).</br> <br>
The equation shown above is to compute the population of species i. Of course, it needs to be repeated as many times as there are species in our model.
<!--To learn more, click here.</br>-->
</p>

</br>
<!--<h3 id = "More-on-Lotka-Volterra-models">More on Lotka Volterra models...</h3>

<p>
<b id = "Lokta-Volterra-and-Python">Lotka Volterra and Python</b></br>
Want a detailled look at implementing the Lotka Volterra in python using numpy and mathplotlib?</br>
<a href="./lotka-volterra-python.php">Click here.</a></br>
-->

</p>

<script id="simpleSizer">
var likelyMobile = false;
document.getElementById("differential").width = document.getElementById("differential").parentElement.offsetWidth;

if (sizerWidth < 400) {
	likelyMobile = true;
}
</script>
<script src="/scripts/differential/differential2.js"></script>

</div>
<?php include ("site-side.php"); ?>
</div>
        </body>
    </html>