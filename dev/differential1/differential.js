const board_border = "black";
const board_background = "black";

var FPS = 120;
var numPoints = 500;
var scale = 10
var dlength = 10

var data = [] // [t, y, y']
var colorPalette = ["#597d64", "#e8094a", "#315465", "#7b118b", "#02aacf", "#bfe6c7", "#6e4358", "#305557"] // DYNAMITE
var colorTransitionDelta = 0
var colorTransitionSpeed = 0.001

const board = document.getElementById("differential");
const board_ctx = board.getContext("2d");

var resolutionX = board.width;
var resolutionY = board.height;

function ready() {
	populate(data, numPoints);
}

function main() {
	setTimeout(function onTick() {
	if (!(document.getElementById('pause').checked)){
		clear_board();
		calculNdraw(data);
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
	context.fillRect(x * scale - size/2, -y * scale + (resolutionY/2) - size/2, size, size);
	context.fillStyle = color;
	context.fill();
}

function drawLine(context, x1, y1, x2, y2, color) {
	context.beginPath();
	context.moveTo(x1 * scale, -y1 * scale + (resolutionY/2));
    context.lineTo(x2 * scale, -y2 * scale + (resolutionY/2));
	context.strokeStyle = color;
	context.lineWidth = 1;
	context.stroke();
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function populate(d, n) {
	for (var i = 0; i < n; i++) {
		d.push([getRandomInt(0, resolutionX/scale), getRandomInt(-resolutionY/2/scale, resolutionY/2/scale), 0])
	}
}

function calculNdraw(list) {
	for (var i = 0; i < list.length; i++) {
		list[i][2] = equation(list[i][1]);
		
		var blue = list[i][0]*scale/resolutionX * 255;
		var green = Math.sin(colorTransitionDelta) * 150;
		var red = 155
		var color = "rgb(" + Math.abs(red).toString() + "," + Math.abs(green).toString() + "," + Math.abs(blue).toString() + ")";
		
		drawPoint(board_ctx, list[i][0], list[i][1], 2, color);
		drawLine(board_ctx, list[i][0], list[i][1], list[i][0] + dlength, list[i][1] + list[i][2], color)
	}
	colorTransitionDelta += colorTransitionSpeed;
}

function equation(y) {
	return y;
}

ready();
main();