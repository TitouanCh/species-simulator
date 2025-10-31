const board_border = "black";
const board_background = "black";

var FPS = 12;
var numPoints = 500;
var scale = 50;
var dlength = 0.1;
var alpha = 2;
var beta = -.5;
var gamma = -6;
var delta = 5;

var data = [] // [x, y, x', y']
var colorPalette = ["#597d64", "#e8094a", "#315465", "#7b118b", "#02aacf", "#bfe6c7", "#6e4358", "#305557"] // DYNAMITE
var colorTransitionDelta = 0
var colorTransitionSpeed = 0.001

const board = document.getElementById("differential");
const board_ctx = board.getContext("2d");

var resolutionX = board.width;
var resolutionY = board.height;

function ready(first = false) {
	data = [];
	alpha = document.getElementById("alpha-equation").value;
	beta = document.getElementById("beta-equation").value;
	gamma = document.getElementById("gamma-equation").value;
	delta = document.getElementById("delta-equation").value;
	
	if (likelyMobile && first) {
		alpha = 3;
		beta = -.5;
		gamma = -2;
		delta = 0.8;
		console.log("Loaded Lotka Volterra ~ Mobile Settings");
	}
	
	//console.log(alpha, beta, gamma, delta);
	dlength = parseFloat(document.getElementById("dlength").value);
	numPoints = parseInt(document.getElementById("numPoints").value);
	scale = parseFloat(document.getElementById("scale").value);
	
	populate(data, numPoints);
}

function main() {
	setTimeout(function onTick() {
	if (!(document.getElementById('pause').checked)){
		clear_board();
		calculNdraw(data);
		if (document.getElementById('axes').checked) {
			drawAxes();
		}
	}
	main();
	
  }, 1000/FPS)
}

function clear_board() {
	//  Select the colour to fill the drawing
	board_ctx.fillStyle = board_background;
	//  Select the colour for the border of the canvas
	board_ctx.strokestyle = board_border;
	// Draw a "filled" rectangle to cover the entire canvas
	board_ctx.fillRect(0, 0, board.width, board.height);
	// Draw a "border" around the entire canvas
	board_ctx.strokeRect(0, 0, board.width, board.height);
}

function drawCircle(context, x, y, r, color) {
	context.beginPath();
	context.arc(x + (resolutionX/2), -y + (resolutionY/2), r, 0, 2 * Math.PI, false);
	context.fillStyle = color;
	context.fill();
	context.lineWidth = 5;
	//context.strokeStyle = 'black';
	//context.stroke();
}

function drawPoint(context, x, y, size, color) {
	context.fillRect(x * scale - size/2, -y * scale + (resolutionY) - size/2, size, size);
	context.fillStyle = color;
	context.fill();
}

function drawLine(context, x1, y1, x2, y2, color, width = 1) {
	context.beginPath();
	context.moveTo(x1 * scale, -y1 * scale + (resolutionY));
    context.lineTo(x2 * scale, -y2 * scale + (resolutionY));
	context.strokeStyle = color;
	context.lineWidth = width;
	context.stroke();
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function getRandomFloat(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.random() * (max - min + 1) + min;
}

function populate(d, n) {
	for (var i = 0; i < n; i++) {
		d.push([getRandomFloat(0, resolutionX/scale), getRandomFloat(0, resolutionY/scale), 0, 0])
	}
}

function calculNdraw(list) {
	for (var i = 0; i < list.length; i++) {
		list[i][2] = equation1(list[i][0], list[i][1]);
		list[i][3] = equation2(list[i][0], list[i][1]);
		
		var blue = list[i][3]*scale/resolutionX * 255;
		var green = list[i][0]*scale/resolutionX * 255;
		var red = Math.sin(colorTransitionDelta) * 255;
		var color = "rgb(" + Math.abs(red).toString() + "," + Math.abs(green).toString() + "," + Math.abs(blue).toString() + ")";
		
		drawPoint(board_ctx, list[i][0], list[i][1], 2, color);
		drawLine(board_ctx, list[i][0], list[i][1], list[i][0] + (dlength * list[i][2]), list[i][1] + (dlength * list[i][3]), color)
	}
	colorTransitionDelta += colorTransitionSpeed;
}

function drawAxes() {
	drawLine(board_ctx, 0, 0, resolutionX, 0, "white", 3);
	drawLine(board_ctx, 0, -resolutionY/2, 0, resolutionY/2, "white", 3);
	
	board_ctx.fillStyle = "white";
	board_ctx.font = "30px Arial";
	board_ctx.fillText("y", 10, resolutionY/4);
	board_ctx.fillText("t", 10, resolutionY/2 + 30);
}

function equation1(x, y) {
	return alpha * x + (beta * x * y);
}

function equation2(x, y) {
	return gamma * y + (delta * x * y);
}

window.onload = function() {
	ready(true);
	main();
};