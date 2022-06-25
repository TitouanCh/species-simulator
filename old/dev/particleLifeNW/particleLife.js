const board_border = 'white';
const board_background = "white";

var FPS = 120;
var nombreIndividus;

var data = [] // [specie, x, y, vx, vy, nx, ny]
var forceBook = []
var massBook = []
var colorPalette = ["#597d64", "#e8094a", "#315465", "#7b118b", "#02aacf", "#bfe6c7", "#6e4358", "#305557"] // DYNAMITE

var numSpecies = 5
var G = 900.81

const board = document.getElementById("particleLife");
const board_ctx = board.getContext("2d");

var resolutionX = board.width;
var resolutionY = board.height;

var dragCoef = 0.98

function ready() {
	setupForceBook(forceBook, numSpecies);
	setupMassBook(massBook, numSpecies);
	populate(data, 100, numSpecies);
}

function main() {
	setTimeout(function onTick() {
	if (!(document.getElementById('pause').checked)){
		clear_board();
		calculNdraw(data, 0.1);
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

function calculNdraw(d, delta) {
	for (var i = 0; i < d.length; i++) {
		var specie = d[i][0];
		
		var forceX = 0;
		var forceY = 0;
		
		// Calculate force other on self
		for (var j = 0; j < d.length; j++) {
			if (j != i) {
				var distance = Math.sqrt(Math.pow(d[j][1] - d[i][1], 2) + Math.pow(d[j][2] - d[i][2], 2));

				if (distance > 0.0 && distance < 800.0) {
					var normalizedVectorX = (d[i][1] - d[j][1]) / distance;
					var normalizedVectorY = (d[i][2] - d[j][2]) / distance;
					
					var fG;
					// var fG = Math.sin((distance - 40.0) / G) * (massBook[specie] * massBook[d[j][0]]);
					// if (distance > 20.0){
						// fG *= forceBook[d[j][0]][specie]
					// }
					if (distance < 25.0) {
						// fG = -Math.exp(-distance + 20.0);
						fG = (Math.pow(distance - 25, 4));
					}
					else if (distance > 412.5) {
						fG = (-distance + 80) / (G);
						fG *= forceBook[d[j][0]][specie] * massBook[d[j][0]] * massBook[specie];
					}
					else {
						fG = ((-Math.pow((distance - 412.5) / 90, 2) * 0.02) + 550) / (G);
						fG *= forceBook[d[j][0]][specie] * massBook[d[j][0]] * massBook[specie];
					}
					
					
					forceX += fG * normalizedVectorX;
					forceY += fG * normalizedVectorY;
				}
			}

		}
		
		var dragX = forceX * dragCoef;
		var dragY = forceY * dragCoef;
		
		var accelX = (forceX - dragX) / massBook[specie];
		var accelY = (forceY - dragY) / massBook[specie];
		
		d[i][3] += accelX * delta; //vx
		d[i][4] += accelY * delta; //vy
		
		d[i][5] = d[i][1] + (d[i][3] * delta); //nx
		d[i][6] = d[i][2] + (d[i][4] * delta); //ny
		
		if (d[i][5] < 0) {
			d[i][5] = 0;
			d[i][3] = 10;
		}
		if (d[i][5] > resolutionX) {
			d[i][5] = resolutionX;
			d[i][3] = -10;
		}
		if (d[i][6] < 0) {
			d[i][6] = 0;
			d[i][4] = 10;
		}
		if (d[i][6] > resolutionY) {
			d[i][6] = resolutionY;
			d[i][4] = -10;
		}
		
		drawPoint(board_ctx, d[i][1], d[i][2], 10, colorPalette[d[i][0]]);
	}
	
	for (var i = 0; i < d.length; i++) {
		d[i][1] = d[i][5]; //x
		d[i][2] = d[i][6]; //y
	}
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

function setupForceBook(book, num) {
	for (var i = 0; i < num; i++) {
		var row = [];
		for (var j = 0; j < num; j++) {
			if (j != i) {
				row.push(getRandomInt(-10, 10));
			} else {
				row.push(-5);
			}
			
		} 	
		book.push(row)
	}
}

function setupMassBook(book, num) {
	for (var i = 0; i < num; i++) {
		book.push(getRandomInt(1, 5))
	}
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function populate(d, n, num) {
	for (var i = 0; i < n; i++) {
		d.push([i%num, getRandomInt(0, resolutionX), getRandomInt(0, resolutionY), 0, 0, 0, 0])
	}
}

ready();
main();