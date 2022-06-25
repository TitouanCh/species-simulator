<!DOCTYPE html>
<html lang= "en">
<head>
<title>Understanding Basic Differential Equations</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/style.css">
<link rel="icon" type="image/png" href="/favicon.png"/>
<meta name="Description" content="A basic explanation of differential equations of the first order.">
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

<a class="skip-link" href="#main">Skip to the article</a>

<!-- Navigation Bar -->
<header><?php readfile("../html/navbar.html") ?></header></br>

<main id="main">

<div id = "content" class="article" style = "text-align:center;">

<h1>Understanding Basic Differential Equations</h1>

<h2>Differential equations are equations where the variable is a function. They are a powerful tool to model the world around us...</h2>

<p><b>Differential equations of the first order :</b></br>
The order of a differential equation corresponds to the highest degree of derivation found in the equation.
 For example : y = y' + 1, the order is equal to 1 because y' is the highest degree of derivation found in the equation.
</br>In this article, we'll only look at differential equations of the first order as they are the most simple.
</p>

<canvas id="differential" width="800" height="800"></canvas>

<script id="simpleSizer">
var sizerWidth = document.getElementById('content').clientWidth;
document.getElementById("differential").width = sizerWidth/1.4;
</script>

</br>

Pause : 
<input id="pause" type="checkbox"/>
 || 
Axes : 
<input id="axes" type="checkbox"/>

</br>
<label for="equation">Equation : y' = </label>
<input type="text" id="equation" name="equation" style = "width:30px; text-align:center;" value="1"> y.
<br>

<label for="dlength">Vector Size : </label>
<input type="number" id="dlength" name="dlength" value="10">

</br>

<label for="numPoints">Number of points : </label>
<input type="number" id="numPoints" name="numPoints" value="500">
 || 
<label for="scale">1/Scale : </label>
<input type="number" id="scale" name="scale" value="10">

</br>
<button type="button" onclick="ready();">Initialize</button>

</br>
<p>
<b>First order equation example : y'(t) = αy(t)</b>
</br>
We graphed the equation : y'(t) = αy(t) above. With α a parameter.
</br>
Sur le graphique, nous observons des courbes rappelant la fonction exponentielle. 
</br></br>
To graph the equation, we first chose random points on the graph with the y-axis representing y and the x-axis representing t. 
 Then we draw vectors (y, y') to represent were the equation will tend to evolve to next.
</br>
The drawn vectors help us gain a better understanding of the equation and possibly help us find a solution.
</br>
We can observe curves reminding us of exponential functions. Indeed the solution to the equation is y(t) = exp(α + t).
</br></br>

<b>What can differential equations be used for ?</b></br>
Despite its simplicity, the equation we've just studied has many application.
For example, we can use it to model population dynamics.
</br>
We can use it to model the growth of a population.</br>
We'll have :</br>
y' : correponding to the speed at which the population is growing.</br>
y : corresponding to the population size.</br>
α : corresponding to the population's growth factor.</br>
With our equation : y'(t) = αy(t), our growth speed (y') will be proportional to our population size (y) and our growth factor (α).</br>
</br>
Differential equations are incredible tools to study phenomenons where the rate of change is affected by its parameters.
</p>

<script src="/scripts/differential/differential1.js"></script>

</div>

</main>

<footer><?php readfile("../html/footer.html") ?></footer>

</body>

</html>