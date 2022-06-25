<!DOCTYPE html>
<html lang= "en">
<head>
<title>Particle Life Online</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/style.css">
<link rel="icon" type="image/png" href="/favicon.png"/>
<meta name="Description" content="Recreation of the automaton : Particle Life, available online in your browser.">
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

<a class="skip-link" href="#main">Skip directly to the article</a>

<!-- Navigation Bar -->
<header><?php readfile("../html/navbar.html") ?></header></br>

<main id="main">

<div id="content" class="article" style = "text-align:center;">

<h1>Particle Life Online</h1>

<h2>Inspired by Clusters from Jeffrey Ventrella, we can observe in this simulation emergent behaviors reminding us of micro-organisms...</h2>

<p>Each color or species interacts in a random way with other species.
 Particles can attract or repel each other leading to fun results. Try restarting the simulation multiple times until you find something interesting.</p>

</br>

<canvas id="particleLife" width="1300" height="800"></canvas>

</br>

<label for="enviroWidth">Enviro Width :</label>
<input type="number" id="enviroWidth" name="enviroWidth" value="1300" min="10" max="10000">
 || 
<label for="enviroHeight">Enviro Height :</label>
<input type="number" id="enviroHeight" name="enviroHeight" value="800" min="10" max="10000">

<script id="simpleSizer">
var sizerWidth = document.getElementById('content').clientWidth;
document.getElementById("enviroWidth").value = sizerWidth/1.5;
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

||

<label for="drag">1/Friction :</label>
<input type="number" id="drag" name="drag" value="0.98" min="0" max="1">

<script src="/scripts/particleLife/particleLife-App.js"></script>

</br>
</br>

<p>
<b>How it works :</b></br>
At the start of each simulation, each color, corresponding to a specie, is assigned a random number for each different specie.</p></br>
<table style = "margin: auto;">
   <tr>
       <td>---/---</td>
       <td>Blue</td>
       <td>Green</td>
	   <td>Red</td>
   </tr>
   <tr>
       <td>Blue</td>
       <td>---/---</td>
       <td>1.8</td>
	   <td>-5.2</td>
   </tr>
   <tr>
       <td>Green</td>
       <td>-4.3</td>
       <td>---/---</td>
	   <td>0.7</td>
   </tr>
   <tr>
       <td>Red</td>
       <td>-3.2</td>
       <td>7.3</td>
	   <td>---/---</td>
   </tr>
</table></br>
<i>Table with possible values</i>
</br></br>
<p>This number will define if the interaction between the two colors. A negative number will result in attraction and a positive number in repulsion.
</br>
Interactions are not symmetrical, for example : blue can attract green but green can repel blue (this will result in a sort of glider effect).
</p>
<img src="/img/particle-life/glider.gif" alt="Glider particle life.">
<i>Particle Life "Glider".</i>
</br></br>
<p>
The force of these interactions diminishes based on the distance between the two particles.
 Also, if two particles get too close, we'll apply a strong repelling force so as they don't go througth each other.
 Still, these interactions mean that energy can be endlessy created in our simulation. 
 To combat this, we add a friction force to all particles to prevent them from endlessly gaining speed.
</br>
</br>
<b>That's all there really is to it, still, even with those simple rules we can get some fun results.
</p>

</div>

</main>

<footer><?php readfile("../html/footer.html") ?></footer>

</body>

</html>