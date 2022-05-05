<!DOCTYPE html>
<html>
<head>
<title>Simulation</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>

</style>
</head>

<body>

<main id="main">

<canvas id="newickParser" width="800" height="800"></canvas>
<input id="pause" type="checkbox"/>
</br>
<div id="treeString" style="font-weight: bold;">(((D:0.3, E:0.3)B:0.2, C:0.5)A:0.1)F;</div>

</br>
Ntips : <input id="ntips" type="number" value="0"/></br>
Speciation (λ) : <input id="speciation" type="number" value="0.1"/></br>
Extinction (µ) : <input id="extinction" type="number" value="0.05"/></br>
Extant Sampling (ρ) : <input id="extant sampling" type="number" value="0.6"/></br>
Fossil Recovery (Ψ) : <input id="fossil recovery" type="number" value="0.05"/></br>
<button type="button" onclick="generateTreeFromData()">Generate Tree</button>

<script src="treeGen.js"></script>
<script src="newick.js"></script>


</main>

</body>

</html>