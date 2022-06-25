var FPS = 5;

const board = document.getElementById("puyoPuyoAi");
const board_ctx = board.getContext("2d");

var colorPalette = ["#cfe8ff", "#5670c2", "#7ec177", "#4e0b3c", "#ad4557", "#ffd21c", "#aabfe0", "#aabfe0"] // DYNAMITE

const board_border = colorPalette[6];
const board_background = colorPalette[7];

var resolutionX = board.width;
var resolutionY = board.height;

/* Data -> Puyo -- Table

0 : empty

1 : blue
2 : green
3 : purple
4 : red
5 : yellow

11 : curr blue
12 : curr green
13 : curr purple
14 : curr red
15 : curr yellow

*/
var data = [];
var tableSize = [6, 12];

var sendNextPuyo = false;
var comboChain = 1;
var SCORE = 0;

/* Mode

0 : AI
1 : Player

*/
var mode = 1;
var currInput = 0;

document.onkeydown = checkKey;

function ready() {
	for (let i = 0; i <	tableSize[1]; i++) {
		var row = [];
		for (let j = 0; j < tableSize[0]; j++) {
			row.push(0);
		}
		data.push(row);
	}
	
	SCORE = 0;
	addPuyo(data);
}

function step(d) {
	sendNextPuyo = true;
	var gravActed = false;
	
	// GRAVITY --
	for (let i = 0; i < d.length; i++) {
		for (let j = 0; j < d[i].length; j++) {
			var c = d[i][j];
			if (c > 0) {
				if (i > 0) {
					if (d[i - 1][j] == 0) {
						d[i - 1][j] = c;
						d[i][j] = 0;
						sendNextPuyo = false;
						gravActed = true;
					}
					
					else if (d[i][j] > 10) {
						d[i][j] -= 10;
						for (let k = 0; k < d.length; k++) {
							for (let l = 0; l < d[i].length; l++) {
								if (d[k][l] > 10) {
									d[k][l] -= 10;
								}
							}
						}
					}
				} 
				
				else if (d[i][j] > 10) {
					d[i][j] -= 10;
				}
				
				if (c > 10){
					sendNextPuyo = false;
				}
			}
		}
	}
	
	// SCORE --
	if (!gravActed) {
		for (let i = 0; i < d.length; i++) {
			for (let j = 0; j < d[i].length; j++) {
				if (d[i][j] > 0) {
					var v = get_voisin(j, i, d, []);

					if (v.length >= 4) {
						for (let k = 0; k < v.length; k++) {
							d[v[k][1]][v[k][0]] = 0;
						}
						
						updateScore(10 * v.length * comboChain);
						
						comboChain += 1;
						sendNextPuyo = false;	
					}
				}
			}
		}
	}
	
	return d;
}

function get_voisin(x, y, d, l) {
	var list = l;
	var possible_voisin = []
	var c = d[y][x];
	list.push([x, y]);
	
	if (x > 0) {
		possible_voisin.push([-1, 0]);
	}
	if (x < tableSize[0] - 1) {
		possible_voisin.push([1, 0]);
	}
	if (y > 0) {
		possible_voisin.push([0, -1]);
	}
	if (y < tableSize[1] - 1) {
		possible_voisin.push([0, 1]);
	}
	
	/* DIAGONALS -- WOOPS !!!
	if (x > 0 && y > 0) {
		possible_voisin.push([-1, -1]);
	}
	if (x < tableSize[0] - 1 && y < tableSize[1] - 1) {
		possible_voisin.push([1, 1]);
	}
	if (x > 0 && y < tableSize[1] - 1) {
		possible_voisin.push([-1, 1]);
	}
	if (x < tableSize[0] - 1 && y > 0) {
		possible_voisin.push([1, -1]);
	} */
	
	for (let i = 0; i < possible_voisin.length; i++) {
		var posToCheck = [x + possible_voisin[i][0], y + possible_voisin[i][1]];
		if (d[posToCheck[1]][posToCheck[0]] == c) {
			var alreadyChecked = false;
			for (let k = 0; k < list.length; k++) {
				if (posToCheck[0] == list[k][0] && posToCheck[1] == list[k][1]) {
					alreadyChecked = true;
					break;
				}
			}
			
			if (!alreadyChecked) {
				list = get_voisin(posToCheck[0], posToCheck[1], d, list);
			}
		}
	}
	
	return(list);
}

function draw_data(d) {
	var r = resolutionX/12;
	for (let i = 0; i < d.length; i++) {
		for (let j = 0; j < d[i].length; j++) {
			
			var color = d[d.length - i - 1][j];
			if (color > 10) {
				color -= 10;
			}
			
			drawPoint(board_ctx, j * resolutionX/6 + r, i * resolutionY/12 + r, r, colorPalette[color]);
		}
	}
}

function updateScore(v) {
	SCORE += v;
	document.getElementById("score").innerHTML = "SCORE : " + SCORE;
}

function addPuyo(d) {
	comboChain = 1;
	var r = getRandomInt(1, 5);
	var s = getRandomInt(1, 5);
	d[d.length - 1] = [0, 0, 10 + r, 10 + s, 0, 0];
}

function input(d, a) {
	/* Inputs --
	1 : Right
	2 : Left
	3 : Rotate
	*/
	
	if (a == 1) {
		for (let i = 0; i < d.length; i++) {
			for (let j = d[i].length - 1; j >= 0; j--) {
				if (d[i][j] > 10) {
					if (j < tableSize[0]) {
						if (d[i][j + 1] == 0) {
							d[i][j + 1] = d[i][j];
							d[i][j] = 0;
						}
					}
				}
			}
		}
	}
	
	if (a == 2) {
		for (let i = 0; i < d.length; i++) {
			for (let j = 0; j < d[i].length; j++) {
				if (d[i][j] > 10) {
					if (j > 0) {
						if (d[i][j - 1] == 0) {
							d[i][j - 1] = d[i][j];
							d[i][j] = 0;
						}
					}
				}
			}
		}
	}
	
	if (a == 3) {
		for (let i = 0; i < d.length; i++) {
			for (let j = 0; j < d[i].length; j++) {
				if (d[i][j] > 10) {
					if (j <= d[i].length && i > 0) {
						// Right -> Down
						if (d[i][j + 1] > 10 && d[i - 1][j] == 0) {
							d[i - 1][j] = d[i][j + 1];
							d[i][j + 1] = 0;
						}
						
						// Down -> Right
						else if (d[i - 1][j] > 10 && d[i][j + 1] == 0){
							d[i][j + 1] = d[i - 1][j];
							d[i - 1][j] = 0;
						}
					}
				}
			}
		}
	}
	
	if (a == 4) {
		for (let i = 0; i < d.length; i++) {
			for (let j = 0; j < d[i].length; j++) {
				if (d[i][j] > 10) {
					if (j <= d[i].length && i > 0) {
						// Right -> Mirror
						if (d[i][j + 1] > 10) {
							var buffer = d[i][j + 1];
							d[i][j + 1] = d[i][j];
							d[i][j] = buffer;
						}
						
						// Down -> Mirror
						else if (d[i - 1][j] > 10 && d[i][j + 1] == 0){
							var buffer = d[i - 1][j];
							d[i - 1][j] = d[i][j];
							d[i][j] = buffer;
						}
					}
				}
			}
		}
	}
	
	return d;
}

function main() {
	setTimeout(function onTick() {
	if (!(document.getElementById('pause').checked)){
		clear_board();
		data = step(data);
		if (mode == 1) {
			data = input(data, currInput);
			currInput = 0;
		}
		if (sendNextPuyo) {addPuyo(data);}
		draw_data(data);
	}
	main();
  }, 1000/FPS)
}

function clear_board() {
	board_ctx.fillStyle = board_background;
	board_ctx.strokestyle = board_border;
	board_ctx.fillRect(0, 0, board.width, board.height);
	board_ctx.strokeRect(0, 0, board.width, board.height);
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

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function checkKey(e) {

    e = e || window.event;

    if (e.keyCode == '38') {
        // up arrow
		currInput = 3;
    }
    else if (e.keyCode == '40') {
        // down arrow
		currInput = 4;
    }
    else if (e.keyCode == '37') {
       // left arrow
	   currInput = 2;
    }
    else if (e.keyCode == '39') {
       // right arrow
	   currInput = 1;
    }

}

ready();
main();

/* AI

Genome : [ [x, y, in, out, w0, w1, w2, w3, w4, w5, w6, w7, w8, w9] ]
-> each value is a float between 0 and 1

*/