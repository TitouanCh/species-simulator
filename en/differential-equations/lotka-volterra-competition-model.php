<!DOCTYPE html>
<html lang= "en">
<head>
<title>Lotka Volterra Python</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/style.css">
<link rel="icon" type="image/png" href="/favicon.png"/>
<meta name="Description" content="Using python, numpy and mathplotlib, studying Lotka-Volterra is easy, I'm going to show you how.">
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

<h1>Lotka Volterra Competition Model</h1>

<h2>The lotka volterra competition model is a system of two differential equations that can be used to study the relationship between two species, a predator and a prey...</h2>

Lotka-Volterra equations are a system of <a href="/en/differential-equations/">equations of the first order</a>. </br>
<a href = "lotka-volterra.php">More on Lotka-Volterra</a>.
</p>

<div id="toc_container">
<p class="toc_title">Lotka Volterra Competition Model/Contents</p>
<ul class="toc_list">
<li><a href="#Setting-up-our-Python-environement">1 Setting up our Python environement</a></li>
<li><a href="#Looking-at-Lotka-Volterra-in-Python-using-a-vector-field">2 Looking at Lotka Volterra in Python using a vector field</a>
<li><a href="#Finding-solutions-to-our-Lotka-Volterra-system-using-odeint">3 Finding solutions to our Lotka Volterra system using odeint.</a></li>
</ul>
</div>

</br>
<h3 id="Setting-up-our-Python-environement">Introduction to the Lotka Volterra competition model</h3>

<p>
The Lotka Volterra competiton model is a simple model used to study population dynamics.
</p>

</br>

<h3 id = "Looking-at-Lotka-Volterra-in-Python-using-a-vector-field">Lotka Volterra Competition Model System of Equations</h3>

<p>
Let's take a look at the equations used to describe the model :
<img src="/img/differential-equations/lotka-volterra-predator-prey.png" alt="Lotka-Volterra predator prey model equation"></br>

<b>f</b> and <b>g</b> correspond to our prey and predator populations respectively.</br>
<b>f'</b> and <b>g'</b> are used to describe our prey and predator populations' variations.</br>
</br>
<b>α</b> is used as a coeficient for our prey population's growth, you can see that it is proportional to our prey population. This makes sense as more parents means more offsprings.</br>  
<b>β</b> is used as a coeficient for our prey population's decline as a result of predation by the predator population. Since predation has a negative impact on our prey population, this coeficient is negative.</br> 
<b>γ</b> is used as a coeficient for our predator population's growth, it is negative as the predator population naturally declines without sources of food.</br>
<b>δ</b> is used as a coeficient to model the positive impact of the prey population on the predator population. Naturally, more prey means more growth for the predator population.</br>
</p>

</div>

</main>

<footer><?php readfile("../html/footer.html") ?></footer>

</body>

</html>