<!DOCTYPE html>
<html lang= "en">
<head>
<title>Newick Tree Parser</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/style.css">
<link rel="icon" type="image/png" href="/favicon.png"/>
<meta name="Description" content="A free basic tree parser.">
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

<h1>Newick Tree Parser</h1>

<h2>Display trees in the Newick format using this free simple online parser...</h2>


<canvas id="newickParser" width="800" height="800"></canvas>

</br>
Pause : 
<input id="pause" type="checkbox"/>
</br>
Newick Tree : </br>
<textarea id="treeString" cols="100" rows="5" style="font-weight: bold;">(A:0.1,B:0.2,((E:0.1, F:0.1)C:0.3,((Z:0.02, U:0.04, I:0.2, H:0.21)X:0.2, P:0.112)D:0.05)E:0.1)F;</textarea>

</br>
<button type="button" onclick="ready()">Regenerate</button>

<script id="simpleSizer">
var sizerWidth = document.getElementById('content').clientWidth;
document.getElementById("newickParser").width = sizerWidth/1.4;
</script>

<script src="/scripts/macroevolution/newick.js"></script>

</br>
</br>
</br>
</div>

</main>

<footer><?php readfile("../html/footer.html") ?></footer>

</body>

</html>