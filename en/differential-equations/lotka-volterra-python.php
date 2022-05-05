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

<h1>Lotka Volterra Python</h1>

<h2>Lotka Volterra equations are a model which can be used to study relationship between species, let's implement the Lotka Volterra predator prey model in Python...</h2>

Lotka-Volterra equations are a system of <a href="/en/differential-equations/">equations of the first order</a>. </br>
<a href = "lotka-volterra.php">More on Lotka-Volterra</a>.
</p>

<div id="toc_container">
<p class="toc_title">Lotka Volterra Python/Contents</p>
<ul class="toc_list">
<li><a href="#Setting-up-our-Python-environement">1 Setting up our Python environement</a></li>
<li><a href="#Looking-at-Lotka-Volterra-in-Python-using-a-vector-field">2 Looking at Lotka Volterra in Python using a vector field</a>
<li><a href="#Finding-solutions-to-our-Lotka-Volterra-system-using-odeint">3 Finding solutions to our Lotka Volterra system using odeint.</a></li>
</ul>
</div>

</br>
<h3 id="Setting-up-our-Python-environement">Setting up our Python environement</h3>

<p>
This explanation assumes you the basics of <b>Python</b> and the two libraries we'll use, <b>Mathplotlib</b> and <b>numpy</b>. Althougth it you should be able to follow along even if you're only at a beginner level.</br>
</br>
Let's start by importing the two libraries we'll use in Python:</br>
<div class ="code-block">
<code></br>
<c class="python-basic">import</c> numpy <c class="python-basic">as</c> np</br>
<c class="python-basic">import</c> mathplotlib <c class="python-basic">as</c> plt</br></br>
</code>
</div>
</p>

</br>

<h3 id = "Looking-at-Lotka-Volterra-in-Python-using-a-vector-field">Looking at Lotka Volterra in Python using a vector field</h3>
<p>
Let's take a look at our Lotka Volterra predator prey model:
<img src="/img/differential-equations/lotka-volterra-predator-prey.png" alt="Lotka-Volterra predator prey model equation"></br>
As you can see, it's composed of two simple first order differential equations.
This means we can easily represent it in a two dimensional vector field.
</br>
PHOTO VECTOR FIELD</br>
</br>
To make our vector field, we'll first need a grid of evenly scattered points, those will be the origin of our vectors.
We'll also draw our grid to make sure nothing is amiss. Arbitrarily, we'll make our grid 5000 x 5000 with 25² points.
</p>
<div class ="code-block">
<code></br>
<c class="python-comment"># Making the grid for our points:</c>                 </br>
vector_origin_x, vector_origin_y = np.meshgrid(                                 </br>
&nbsp;&nbsp;&nbsp;&nbsp;np.linspace(<c class="python-basic">1</c>, <c class="python-basic">5000</c>, <c class="python-basic">25</c>),</br>
&nbsp;&nbsp;&nbsp;&nbsp;np.linspace(<c class="python-basic">1</c>, <c class="python-basic">5000</c>, <c class="python-basic">25</c>)</br>
)</br>
</br>
<c class= "python-comment"># Drawing our grid:</c></br>
fig = plt.figure(figsize=(<c class="python-basic">6</c>, <c class="python-basic">6</c>))</br>
ax = fig.add_subplot(<c class="python-basic">1</c>, <c class="python-basic">1</c>, <c class="python-basic">1</c>)</br>
ax.scatter(vector_origin_x, vector_origin_y, s=<c class="python-basic">1</c>, c=<c class="python-string">'red'</c>)</br>
fig.show()</br></br>
</code>
</div>
<p>
<img src="/img/differential-equations/python-first-grid.png" alt="First Python meshgrid, shows our points"></br>
Now that we've got our grid, we just need to draw our vectors on top of it! 😜</br></br>
For that we just need to figure out the direction of our vectors in two dimensional space.</br>
This is where our Lotka Volterra equations come in, if we choose to set our <b>prey population</b> to the <b>x axis</b> and our <b>predator population</b> to the <b>y axis</b>:
<img src="/img/differential-equations/lotka-volterra-predator-prey-python.png" alt="Predator prey Lotka Volterra system describing x and y component of vectors for python implementation"></br>
Let's define those x and y component as functions inside python functions so we can easily apply them to our points later on.</br>
</p>

<div class ="code-block">
<code></br>
<c class="python-comment"># parameters</c></br>
alpha, beta, gamma, delta = <c class="python-basic">0.1</c>, <c class="python-basic">5e-5</c>, <c class="python-basic">0.04</c>, <c class="python-basic">5e-5</c></br>
</br>
<c class="python-comment">
# our derivatives which will correspond to our vector components</br>
# df: f derivarive, dg: g derivative, f: prey population, g: predator population</br>
</c>
</br>
<c class="python-basic"><b>def</b></c> <c class="python-function">df</c>(f, g):</br>
&nbsp;&nbsp;&nbsp;&nbsp;<c class="python-basic"><b>return</b></c> f * (alpha - (beta * g))</br>
</br>
<c class="python-basic"><b>def</b></c> <c class="python-function">dg</c>(f, g):</br>
&nbsp;&nbsp;&nbsp;&nbsp;<c class="python-basic"><b>return</b></c> g * (-gamma + (delta * f))</br>
</br></code>
</div>

<p>
Next, all we need to do is to apply our functions to all the points in our grid.
</p>

<div class ="code-block">
<code></br>
<c class="python-comment"># applying our functions and storing the results</c></br>
dprey, dpredator = df(vector_origin_x, vector_origin_y), dg(vector_origin_x, vector_origin_y)</br>
</br>
<c class="python-comment"># normalising our vectors so they are all the same length</c></br>
normalisation = np.sqrt(dprey**<c class="python-basic">2</c> + dpredator**<c class="python-basic">2</c>)</br>
</br>
<c class="python-comment"># displaying it all:</c></br>
fig = plt.figure(figsize=(<c class="python-basic">8</c>, <c class="python-basic">8</c>))</br>
ax = fig.add_subplot(<c class="python-basic">1</c>, <c class="python-basic">1</c>, <c class="python-basic">1</c>)</br>
</br>
<c class="python-comment">
# quiver is the mathplotlib function that allows us to draw vector fields</br>
# arguments: vector origin x coordinates, vector origin y coordinates, vector x component, vector y component</br>
</c>
ax.quiver(vector_origin_x, vector_origin_y, dprey/normalisation, dpredator/normalisation, angles=<c class="python-string">'xy'</c>)</br>
</br>
ax.axis(<c class="python-string">'equal'</c>)</br>
ax.set_title(<c class="python-string">"Lotka Volterra predator prey vector field"</c>)</br>
ax.set_xlabel(<c class="python-string">"Prey Population"</c>)</br>
ax.set_ylabel(<c class="python-string">"Predator Population"</c>)</br>
plt.show()</br>
</br></code>
</div>

<p>
Below is our final result, a beautiful lotka volterra vector field 😎 </br>
Hope you were able to follow along, you'll find the complete code below as well.
<img src="/img/differential-equations/python-lotka-volterra-vector-field.png" alt="Lotka volterra vector field, made with python and mathplotlib, complete">
</p>

<div class ="code-block">
<code></br>
<c class="python-basic">import</c> numpy <c class="python-basic">as</c> np</br>
<c class="python-basic">import</c> mathplotlib <c class="python-basic">as</c> plt</br></br>
</br>
</br>
<c class="python-comment"># Making the grid for our points:</c>                 </br>
vector_origin_x, vector_origin_y = np.meshgrid(                                 </br>
&nbsp;&nbsp;&nbsp;&nbsp;np.linspace(<c class="python-basic">1</c>, <c class="python-basic">5000</c>, <c class="python-basic">25</c>),</br>
&nbsp;&nbsp;&nbsp;&nbsp;np.linspace(<c class="python-basic">1</c>, <c class="python-basic">5000</c>, <c class="python-basic">25</c>)</br>
)</br>
</br>
<c class="python-comment"># parameters</c></br>
alpha, beta, gamma, delta = <c class="python-basic">0.1</c>, <c class="python-basic">5e-5</c>, <c class="python-basic">0.04</c>, <c class="python-basic">5e-5</c></br>
</br>
<c class="python-comment">
# our derivatives which will correspond to our vector components</br>
# df: f derivarive, dg: g derivative, f: prey population, g: predator population</br>
</c>
</br>
<c class="python-basic"><b>def</b></c> <c class="python-function">df</c>(f, g):</br>
&nbsp;&nbsp;&nbsp;&nbsp;<c class="python-basic"><b>return</b></c> f * (alpha - (beta * g))</br>
</br>
<c class="python-basic"><b>def</b></c> <c class="python-function">dg</c>(f, g):</br>
&nbsp;&nbsp;&nbsp;&nbsp;<c class="python-basic"><b>return</b></c> g * (-gamma + (delta * f))</br>
</br>
<c class="python-comment"># applying our functions and storing the results</c></br>
dprey, dpredator = df(vector_origin_x, vector_origin_y), dg(vector_origin_x, vector_origin_y)</br>
</br>
<c class="python-comment"># normalising our vectors so they are all the same length</c></br>
normalisation = np.sqrt(dprey**<c class="python-basic">2</c> + dpredator**<c class="python-basic">2</c>)</br>
</br>
<c class="python-comment"># displaying it all:</c></br>
fig = plt.figure(figsize=(<c class="python-basic">8</c>, <c class="python-basic">8</c>))</br>
ax = fig.add_subplot(<c class="python-basic">1</c>, <c class="python-basic">1</c>, <c class="python-basic">1</c>)</br>
</br>
<c class="python-comment">
# quiver is the mathplotlib function that allows us to draw vector fields</br>
# arguments: vector origin x coordinates, vector origin y coordinates, vector x component, vector y component</br>
</c>
ax.quiver(vector_origin_x, vector_origin_y, dprey/normalisation, dpredator/normalisation, angles=<c class="python-string">'xy'</c>)</br>
</br>
ax.axis(<c class="python-string">'equal'</c>)</br>
ax.set_title(<c class="python-string">"Lotka Volterra predator prey vector field"</c>)</br>
ax.set_xlabel(<c class="python-string">"Prey Population"</c>)</br>
ax.set_ylabel(<c class="python-string">"Predator Population"</c>)</br>
plt.show()</br>
</br></code>
</div>

</br>
<h3 id = "Finding-solutions-to-our-Lotka-Volterra-system-using-odeint">Finding solutions to our Lotka Volterra system using odeint</h3>

<p>
Now that we've made our sick vector field, let's try to find some solutions to our equations in Python.</br>
One way to do that is to use the odeint function from the <b>scipy</b> package.</br>
</br>
Let's start by importing the function:</br>
</br>
</p>
<div class ="code-block">
<code></br>
<c class="python-basic">from</c> scipy.integrate <c class="python-basic">import</c> odeint</br>
</br>
</code>
</div>

<p>
</br>
Odeint only takes a single function as a parameter, to simplify everything a bit let's redefine our system as a single two parameter function:
</p>

<div class ="code-block">
<code>
</br>
<c class="python-comment">
# While we are at it, let's define our initial populations as well</br>
# f0: initial prey population, g0: initial predator population</br>
</c>
f0, g0 = <c class="python-basic">800</c>, <c class="python-basic">672</c></br>
</br>
<c class="python-comment"># our multivariable function</c></br>
<c class="python-basic"><b>def</b></c> F(X, t=<c class="python-basic">0</c>):</br>
&nbsp;&nbsp;&nbsp;&nbsp;<c class="python-basic"><b>return</b></c> np.array([df(X[<c class="python-basic">0</c>], X[<c class="python-basic">1</c>]), dg(X[<c class="python-basic">0</c>], X[<c class="python-basic">1</c>])])</br>

</br>
</code>
</div>

<p>
Now, we just need for which points we'll calculate our solution, apply odeint to our function and extract our data.
</p>

<div class ="code-block">
<code>
</br>

<c class="python-comment"># points for our solution</c></br>  
t = np.linspace(<c class="python-basic">0</c>, <c class="python-basic">200</c>, <c class="python-basic">400</c>)</br>
</br>
<c class="python-comment"># odeint</c></br>
X = odeint(F, np.array([f0, g0]), t)</br>
</br>
<c class="python-comment"># extracting our data</c></br>
prey_population = []</br>
predator_population = []</br>
</br>
<c class="python-basic"><b>for</b></c> a <c class="python-basic"><b>in</b></c> X:</br>
&nbsp;&nbsp;&nbsp;&nbsp;prey_population.append(a[<c class="python-basic">0</c>])</br>
&nbsp;&nbsp;&nbsp;&nbsp;predator_population.append(a[<c class="python-basic">1</c>])</br>
</br>
</br>
prey_population = np.array(prey_population)</br>
predator_population = np.array(predator_population)</br>

</br>
</code>
</div>

<p>
Finally, let's plot our solution:
</p>

<div class ="code-block">
<code>
</br>

fig = plt.figure(figsize=(<c class="python-basic">8</c>, <c class="python-basic">8</c>))</br>
ax = fig.add_subplot(<c class="python-basic">1</c>, <c class="python-basic">1</c>, <c class="python-basic">1</c>)</br>
</br>
ax.plot(t, prey_population, label=<c class="python-string">"Prey Population"</c>, linewidth=<c class="python-basic">2</c>, color=<c class="python-string">'green'</c>)</br>
ax.plot(t, predator_population, label=<c class="python-string">"Predator Population"</c>, linewidth=<c class="python-basic">2</c>, color=<c class="python-string">'navy'</c>)</br>
</br>
ax.legend()</br>
</br>
ax.set_title(<c class="python-string">"Evolution of predator and prey population over time (Lotka-Volterra)"</c>)</br>
ax.set_xlabel(<c class="python-string">"$t$"</c>)</br>
ax.set_ylabel(<c class="python-string">"Nombre d'individus"</c>)</br>
</br>
plt.show()</br>

</br>
</code>
</div>

<p>
<img src="/img/differential-equations/python-lotka-volterra-solution.png" alt="Lotka volterra solution plotted in mathplotlib">
You can clearly observe the prey and predator populations interacting with one another, when the prey population increases so does the predator population. In turn, the prey population decreases followed by the predator population. The cyclic nature of the model is plainly visible.</br>
You can find to full code below.
</p>

<div class ="code-block">
<code>
</br>

<c class="python-basic">from</c> scipy.integrate <c class="python-basic">import</c> odeint</br>
</br>
</br>
<c class="python-comment">
# While we are at it, let's define our initial populations as well</br>
# f0: initial prey population, g0: initial predator population</br>
</c>
f0, g0 = <c class="python-basic">800</c>, <c class="python-basic">672</c></br>
</br>
<c class="python-comment"># our multivariable function</c></br>
<c class="python-basic"><b>def</b></c> F(X, t=<c class="python-basic">0</c>):</br>
&nbsp;&nbsp;&nbsp;&nbsp;<c class="python-basic"><b>return</b></c> np.array([df(X[<c class="python-basic">0</c>], X[<c class="python-basic">1</c>]), dg(X[<c class="python-basic">0</c>], X[<c class="python-basic">1</c>])])</br>
</br>
</br>
<c class="python-comment"># points for our solution</c></br>  
t = np.linspace(<c class="python-basic">0</c>, <c class="python-basic">200</c>, <c class="python-basic">400</c>)</br>
</br>
<c class="python-comment"># odeint</c></br>
X = odeint(F, np.array([f0, g0]), t)</br>
</br>
<c class="python-comment"># extracting our data</c></br>
prey_population = []</br>
predator_population = []</br>
</br>
<c class="python-basic"><b>for</b></c> a <c class="python-basic"><b>in</b></c> X:</br>
&nbsp;&nbsp;&nbsp;&nbsp;prey_population.append(a[<c class="python-basic">0</c>])</br>
&nbsp;&nbsp;&nbsp;&nbsp;predator_population.append(a[<c class="python-basic">1</c>])</br>
</br>
</br>
prey_population = np.array(prey_population)</br>
predator_population = np.array(predator_population)</br>
</br>
</br>
fig = plt.figure(figsize=(<c class="python-basic">8</c>, <c class="python-basic">8</c>))</br>
ax = fig.add_subplot(<c class="python-basic">1</c>, <c class="python-basic">1</c>, <c class="python-basic">1</c>)</br>
</br>
ax.plot(t, prey_population, label=<c class="python-string">"Prey Population"</c>, linewidth=<c class="python-basic">2</c>, color=<c class="python-string">'green'</c>)</br>
ax.plot(t, predator_population, label=<c class="python-string">"Predator Population"</c>, linewidth=<c class="python-basic">2</c>, color=<c class="python-string">'navy'</c>)</br>
</br>
ax.legend()</br>
</br>
ax.set_title(<c class="python-string">"Evolution of predator and prey population over time (Lotka-Volterra)"</c>)</br>
ax.set_xlabel(<c class="python-string">"$t$"</c>)</br>
ax.set_ylabel(<c class="python-string">"Nombre d'individus"</c>)</br>
</br>
plt.show()</br>

</br>
</code>
</div>

</div>

</main>

<footer><?php readfile("../html/footer.html") ?></footer>

</body>

</html>