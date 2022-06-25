var FPS = 200;

const board = document.getElementById("RPScAi");
const board_ctx = board.getContext("2d");

var colorPalette = ["#cfe8ff", "#5670c2", "#7ec177", "#4e0b3c", "#ad4557", "#ffd21c", "#aabfe0", "#aabfe0"] // DYNAMITE

const board_border = colorPalette[6];
const board_background = colorPalette[7];

var resolutionX = board.width;
var resolutionY = board.height;

var RPScOrdi = 0.0;
var RPScPlayer = 0.0;

var rockImg = new Image;
rockImg.src = "rock.png";
var paperImg = new Image;
paperImg.src = "paper.png";
var scissorsImg = new Image;
scissorsImg.src = "scissors.png";

/* ROCKPAPERSCISSORS --
0.0 - 0.333 : ROCK
0.333 - 0.666 : PAPER
0.666 - 1.0 : SCISSORS
*/

var SCORE = 0;

function ready() {
	RPScOrdi = getRandomFloat();
}

function result(ordi, player) {
	
	if (ordi <= 0.333) {
		if (player <= 0.333) { 
			return 0.0;
		}
		if (player >= 0.666) { 
			return -1.0; 
		}
		return 1.0;
	}
	
	if (ordi >= 0.666) {
		if (player <= 0.333) { 
			return 1.0; 
		}
		if (player >= 0.666) { 
			return 0.0;
		}
		return -1.0;
	}
	
	if (player <= 0.333) {
		return -1.0;
	}
	if (player >= 0.666) {
		return 1.0;
	}
	return 0.0;
	
}

function updateScore() {
	SCORE += result(RPScOrdi, RPScPlayer);
	document.getElementById("score").innerHTML = "POINTS : " + SCORE;
}

function main() {
	setTimeout(function onTick() {
	if (!(document.getElementById('pause').checked)){
		if (listGen.length < population) {
			if (manche < mancheMax) {
				clear_board(board_ctx);
				show(RPScOrdi, 1);
				
			    displayGenome([...genome], "genome");
				
				var decision = takeDecision([...genome], RPScOrdi, "genome");
				RPScPlayer = decision;
				cleanGenome(genome);
				
				show(RPScPlayer, 2);
				updateScore();
				ready();
				manche++;
			} 
			
			if (manche == mancheMax) {
				manche = 0;
				listGen.push([...genome]);
				genome = makeGenome();
				listScore.push(SCORE);
				SCORE = 0;
				ready();
			}
		} else {
			console.log(listScore.sort());
			return ;
		}
		
	}
	main();
  }, 1000/FPS)
}

function show(a, v) {
	var img;
	var y = resolutionY - 110;
	
	if (a <= 0.333) 
	{
		img = rockImg;
	}
	else if (a >= 0.666) 
	{
		img = scissorsImg;
	}
	else {
		img = paperImg;
	}
	
	if (v == 1) {
		y = 10;
	}
	
	board_ctx.drawImage(img, resolutionX/2 - 50, y);
	
	
}

function clear_board(ctx) {
	ctx.fillStyle = board_background;
	ctx.strokestyle = board_border;
	ctx.fillRect(0, 0, board.width, board.height);
	ctx.strokeRect(0, 0, board.width, board.height);
}

function drawPoint(context, x, y, r, color) {
	context.beginPath();
	context.arc(x, y, r, 0, 2 * Math.PI, false);
	context.fillStyle = color;
	context.fill();
	context.lineWidth = 5;
	//context.strokeStyle = 'black';
	//context.stroke();
}

function drawLine(context, xfrom, yfrom, xto, yto, w, color) {
	context.strokeStyle = color;
    context.lineWidth = w;
    context.beginPath();
    context.moveTo(xfrom, yfrom);
    context.lineTo(xto, yto);
    context.stroke();
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function getRandomFloat() {
    return Math.random();
}

ready();
main();

/* AI

200 indiv par generation

node = [x, y, in, w]

*/

var listGen = []
var listScore = []


var population = 200;
var mancheMax = 6;
var manche = 0;

var maxEntree = 5;

function makeGenome() {
	var g = [];
	for (let i = 0; i < getRandomInt(1, 20); i++) {
		var list = [];
		for (let j = 0; j < maxEntree + 3; j++) {
			list.push(getRandomFloat());
		}

		g.push(list);
	}
	return g;
}

function takeDecision(gen, input, e) {
	var b = document.getElementById(e);
	var ctx = b.getContext("2d");
	
	var width = b.width;
	var height = b.height;
	
	var circuit = [[0, 0.5, 0, input]];
	var g = orderGenome([...gen]);

	for (let i = 0; i < g.length; i++) {
		circuit.push(g[i]);
	}
	
	for (let i = 1; i < circuit.length; i++) {
		var listNeuro = getListClosestFoward(circuit, circuit[i][0], circuit[i][1], circuit[i][2]);
		var sum = 0;
		var r = 0;
		for (let j = 0; j < listNeuro.length; j++) {
			sum += listNeuro[j][listNeuro[j].length - 1] * circuit[i][3 + j];
			r += circuit[i][3 + j];
			drawLine(ctx, listNeuro[j][0] * width, listNeuro[j][1] * height, circuit[i][0] * width, circuit[i][1] * height, 1, "red");
		}
		circuit[i].push(sum/ listNeuro.length);
	}
	
	return circuit[circuit.length - 1][circuit[circuit.length - 1].length - 1]
}

function cleanGenome(g) {
	for (let i = 0; i < g.length; i++) {
		g[i].pop();
	}
}

function orderGenome(g) {
	var gOrdered = [];
	for (let i = 0; i < g.length; i++) {
		var baseline = 0;
		if (gOrdered.length > 0) {
			baseline = gOrdered[gOrdered.length - 1][0];
		}
		var memory = 1;
		var current = g[0];
		for (let j = 0; j < g.length; j++) {
			if (baseline < g[j][0] && memory > g[j][0]) {
				current = g[j];
				memory = g[j][0];
			}
		}
		gOrdered.push(current);
	}
	
	return(gOrdered);
}

function getListClosestFoward(g, x, y, a) {
	var list = [];
	for (let i = 0; i < g.length; i++) {
		var baseline = 0;
		if (list.length > 0) {
			baseline = Math.abs(list[list.length - 1][0] - x) + Math.abs(list[list.length - 1][1] - y);
		}
		var memory = 1000;
		var current = g[0];
		var left = 0;
		for (let j = 0; j < g.length; j++) {
			var distance = Math.abs(g[j][0] - x) + Math.abs(g[j][1] - y);
			
			if (baseline < distance && memory > distance && g[j][0] < x) {
				current = g[j];
				memory = distance;
			}
			else if (g[j][0] > x) {
				left++;
			}
		}
		
		list.push(current);
		if (left + list.length == g.length || Math.ceil(a * maxEntree) == list.length) {
			return list;
		}
	}
	
	return list;
}

function displayGenome(g, e) {
	var b = document.getElementById(e);
	var ctx = b.getContext("2d");
	
	var width = b.width;
	var height = b.height;
	
	var r = 3;
	
	clear_board(ctx);
	
	drawLine(ctx, 0, 0, 100, 20, 20, "red");
	
	for (let i = 0; i < g.length; i++) {
		drawPoint(ctx, width * g[i][0] - r/2, height * g[i][1] - r/2, r, colorPalette[2]);
	}
	
	for (let i = 0; i < g.length; i++) {
		drawPoint(ctx, width * g[i][0] - r/2, height * g[i][1] - r/2, r, colorPalette[2]);
	}		
}

var genome = makeGenome();