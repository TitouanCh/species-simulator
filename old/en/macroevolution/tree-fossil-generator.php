<!DOCTYPE html>
<html lang= "en">
<head>
<title>Phylogenetic Tree and Fossil Generator</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/style.css">
<link rel="icon" type="image/png" href="/favicon.png"/>
<meta name="Description" content="A web tool.">
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

<h1>Tree and Fossil Generator</h1>

<h2>Simple tool to generate tree and fossil data...</h2>


<canvas id="newickParser" width="800" height="800"></canvas>
<input id="pause" type="checkbox"/>
</br>
<!-- <div id="treeString" style="font-weight: bold;">(((D:0.3, E:0.3)B:0.2, C:0.5)A:0.1)F;</div> -->

</br>
Ntips : <input id="ntips" type="number" value="0"/></br>
Speciation (λ) : <input id="speciation" type="number" value="0.1"/></br>
Extinction (µ) : <input id="extinction" type="number" value="0.05"/></br>
Extant Sampling (ρ) : <input id="extant sampling" type="number" value="0.6"/></br>
Fossil Recovery (Ψ) : <input id="fossil recovery" type="number" value="0.05"/></br>
<button type="button" onclick="generateTreeFromData()">Generate Tree</button>
<!--
<script id="simpleSizer">
var sizerWidth = document.getElementById('content').clientWidth;
document.getElementById("newickParser").width = sizerWidth/1.4;
</script>
-->
<script src="/scripts/macroevolution/treeGen.js"></script>
<script src="/scripts/macroevolution/newick.js"></script>
<script>generateTreeFromData();</script>
</div>

</main>

<footer><?php readfile("../html/footer.html") ?></footer>

</body>

</html>