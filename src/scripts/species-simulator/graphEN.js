
const graphBoard = document.getElementById("graph");
const graphBoard_ctx = graphBoard.getContext("2d");

var graphLongueur = 800;
var graphHauteur = 800;

var graphScaleOffset = 30

var graphCoef = 1;

var listeOfPoints = [];

graphRatios();


function graph(x, y, color){
	graphBoard_ctx.fillStyle = color;
	graphBoard_ctx.fillRect(x/graphCoef + graphScaleOffset, - y + graphHauteur - graphScaleOffset, 3, 3);
	
	listeOfPoints.push([x, y, color])
}

function graphCalc(arr_y, generation){
	if (generation > (graphLongueur-(graphScaleOffset)*2)*graphCoef){
		resizeGraph();
	}
	
	arr_y.forEach(function(valeur) {
		if (valeur[0] > 0){
			graph(generation, valeur[0], valeur[1]);
		}
	})
	
}

function restartGraph(){
	clear_graph();
	drawScale();
	listeOfPoints = [];
	graphCoef = 1;
}

function clear_graph() {
	//  Select the colour to fill the drawing
	graphBoard_ctx.fillStyle = board_background;
	//  Select the colour for the border of the canvas
	graphBoard_ctx.strokestyle = board_border;
	// Draw a "filled" rectangle to cover the entire canvas
	graphBoard_ctx.fillRect(0, 0, graphLongueur, graphHauteur);
	// Draw a "border" around the entire canvas
	graphBoard_ctx.strokeRect(0, 0, graphLongueur, graphHauteur);
}

function resizeGraph(){
	clear_graph();
	graphCoef = graphCoef*2;
	drawScale();
	listeOfPoints.forEach(function(point) {
		graph(point[0], point[1], point[2]); 
	})
}

function drawScale(){
	graphBoard_ctx.strokeStyle = 'black';
	graphBoard_ctx.lineWidth = 2;
	
	// x axis
	graphBoard_ctx.beginPath();
	graphBoard_ctx.moveTo(graphScaleOffset, graphHauteur - graphScaleOffset);
	graphBoard_ctx.lineTo(graphLongueur - graphScaleOffset, graphHauteur - graphScaleOffset);
	graphBoard_ctx.stroke();
	
	// y axis
	graphBoard_ctx.beginPath();
	graphBoard_ctx.moveTo(graphScaleOffset, graphHauteur - graphScaleOffset);
	graphBoard_ctx.lineTo(graphScaleOffset, graphScaleOffset);
	graphBoard_ctx.stroke();
	
	// text
	var textOffset = -3;
	graphBoard_ctx.fillStyle = "black";
	graphBoard_ctx.textAlign = "center";
	graphBoard_ctx.font = "10px Arial";
	graphBoard_ctx.fillText("Generation", graphLongueur/2, graphHauteur - (graphScaleOffset/2 + textOffset));
	
	graphBoard_ctx.rotate(-(Math.PI/2));
	graphBoard_ctx.fillText("Number of Individuals", -graphLongueur/2, graphScaleOffset/2 - textOffset);
	graphBoard_ctx.rotate(Math.PI/2);
	
	// Valeurs max
	graphBoard_ctx.fillText(totalRessources, graphScaleOffset, graphScaleOffset + textOffset);
	graphBoard_ctx.rotate(Math.PI/2);
	graphBoard_ctx.fillText((graphLongueur-(graphScaleOffset)*2)*graphCoef, graphLongueur - graphScaleOffset, -graphHauteur + textOffset + graphScaleOffset);
	graphBoard_ctx.rotate(-(Math.PI/2));
}

function graphRatios() {
	
	while (graphLongueur > screen.width - 175) {
		graphLongueur = graphLongueur - 50;
		graphHauteur = graphHauteur - 50;
	}
}