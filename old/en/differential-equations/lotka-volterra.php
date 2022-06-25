<!DOCTYPE html>
<html lang= "en">
<head>
<title>Lotka Volterra</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/style.css">
<link rel="icon" type="image/png" href="/favicon.png"/>
<meta name="Description" content="What are Lotka-Volterra equations ? They are simple differential equations, let's try to understand what that means.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7406710081936352"crossorigin="anonymous"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VRLJ6ZZSXJ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-VRLJ6ZZSXJ');
</script>
</head>

<body>

<a class="skip-link" href="#main">Skip to the article.</a>

<!-- Bar de Navigation -->
<header><?php readfile("../html/navbar.html") ?></header></br>
<!-- Fin Bar de Navigation -->

<main id="main">

<div id="content" class="article" style = "text-align:center;">

<h1>Lotka Volterra</h1>

<h2>Lotka Volterra equations are a system of differential equations used to model interactions between different species...</h2>

Lotka-Volterra equations are a system of <a href="/en/differential-equations/">equations of the first order</a>.
</p>

<canvas id="differential" width="800" height="800"></canvas>

<script id="simpleSizer">
var likelyMobile = false;
var sizerWidth = document.getElementById('content').clientWidth;
document.getElementById("differential").width = sizerWidth/1.4;

if (sizerWidth < 400) {
	document.getElementById("differential").height = sizerWidth*1.5;
	likelyMobile = true;
}
</script>

</br>

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
<button type="button" onclick="ready();">Initialize</button>

</br>
</br>



<p>Learn more about Lotka-Volterra...</p>

<div id="toc_container">
<p class="toc_title">Lotka-Volterra/Contents</p>
<ul class="toc_list">
<li><a href="#General-Knowledge-about-Lotka-Volterra">1 General Knowledge about Lotka Volterra</a></li>
<li><a href="#Two-types-of-Lotka-Volterra-models">2 Two types of Lotka-Volterra models</a>
<ul>
<li><a href="#Lotka-Volterra-predator-prey-model">2.1 Lotka Volterra predator prey model</a></li>
<li><a href="#Lotka-Volterra-competition-model">2.2 Lotka-Volterra competition model</a></li>
</ul>
</li>
<li><a href="#More-on-Lotka-Volterra-models">3 More on Lotka-Volterra models...</a></li>
<ul>
<li><a href="#Lokta-Volterra-and-Python">3.1 Lotka Volterra predator and Python</a></li>
</ul>
</ul>
</div>

</br>
<h3 id="General-Knowledge-about-Lotka-Volterra">General Knowledge about Lotka Volterra:</h3>

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

</br>
<h3 id = "Two-types-of-Lotka-Volterra-models">Two types of Lotka Volterra models:</h3>
<p>
There are two types of Lotka-Volterra equations, let's take a look at the expression of their derivative</br>
</br>
The <b id = "Lotka-Volterra-predator-prey-model">Lotka Volterra predator prey model</b>:</br>
</br>
<img src="/img/differential-equations/lotka-volterra-predator-prey.png" alt="Lotka-Volterra predator prey model equation"></br>
Discovered first and the simpler version of the two, it's the model we chose to represent above in a vector field.</br>
Frequently used to describe a system in which a predator and a prey interact. It can only simulate interactions between two species.</br>
To learn more, click here.</br>
</br>
and the <b id = "Lotka-Volterra-competition-model">Lotka Volterra competition model</b>:</br>
</br>
<img src="/img/differential-equations/lotka-volterra-competition-model.png" alt="Lotka-Volterra competition model"></br>
Similar to the predator-prey model, this model takes into account any N species and can simulate more diverse interactions (predator-prey, mutualism, etc...).</br>
The equation shown above is to compute the population of species i. Of course, it needs to be repeated as many times as there are species in our model.
To learn more, click here.</br>

</p>

</br>
<h3 id = "More-on-Lotka-Volterra-models">More on Lotka Volterra models...</h3>

<p>
<b id = "Lokta-Volterra-and-Python">Lotka Volterra and Python</b></br>
Want a detailled look at implementing the Lotka Volterra in python using numpy and mathplotlib?</br>
<a href="./lotka-volterra-python.php">Click here.</a></br>


</p>

<script src="/scripts/differential/differential2.js"></script>

</div>

</main>

<footer><?php readfile("../html/footer.html") ?></footer>

</body>

</html>