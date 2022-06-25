var FPS = 5;

const board = document.getElementById("newickParser");
const board_ctx = board.getContext("2d");

const board_border = "black";
const board_background = "white";

var resolutionX = board.width;
var resolutionY = board.height;

var treeString = "";
var tree;

var test = 0;

function ready() {
	//treeString = document.getElementById('treeString').innerHTML;
	var r = getRandomInt(3, 7);
	tree = generateTree(r, poisson, poisson, 20, 1);
	console.log('your tree --> ', tree);
	document.getElementById('ntips').value = r;
	//console.log(str2tree(treeString));
}

function generateTreeFromData() {
	var ntips = parseInt(document.getElementById('ntips').value);
	var lambda = parseFloat(document.getElementById('speciation').value);
	var mu = parseFloat(document.getElementById('extinction').value);
	
	tree = generateTree(ntips, poisson, poisson, lambda, mu);
	console.log('NewickMastermind: Here is your tree : ', tree);
}

function main() {
	setTimeout(function onTick() {
	if (!(document.getElementById('pause').checked)){
		clear_board(board_ctx);
		
		drawTree(board_ctx, resolutionX, resolutionY, tree);
		
	}
	main();
  }, 1000/FPS)
}

function str2tree(str) {
	
	// Suppression espace + point virgule
	str = str.replace(/\;/g, "");
	str = str.replace(/ /g, "");
	
	// Premier formatage str ...ok!
	str = str.replace(/\:/g, '":');
	str = str.replace(/\,/g, '],["');
	
	// Ajout guillemets vers parentheses
	str = str.replace(/\(/g, '["');
	str = str.replace(/\)/g, ']],["');
	
	// Remplacement guillemets parantheses
	str = str.replace(/\[\"\[/g, "[[");
	str = str.replace(/\[\"\[/g, "[[");
	
	// Double points -> virgule
	str = str.replace(/\:/g, ",");
	// str = str.replace(/\'/g, '"');
	
	str += '"]]';
	str = "[[" + str
	
	return JSON.parse(str);
}

function drawTree(ctx, w, h, tree, offsetx = 0, offsety = 0, marg_height = 10, marg_side = 40, circles = false) {
	var weightsList = [];
	var totalChildren = 0;
	
	// First pass to count the children and assign weights to each node
	for (let i = 0; i < tree.length; i++) {
		weightsList.push(countChildren(tree[i], 0));
		totalChildren += weightsList[weightsList.length - 1];
		if (weightsList[weightsList.length - 1] > 1) {
			i++;
		}
	}
	
	// Draw
	var space_h = h - marg_height;
	var space_sum = (marg_height/2) + offsety;
	var increments = space_h/totalChildren;
	var y1, y2;
	
	var base_x = marg_side/2 + offsetx;
	
	var k = 0;
	
	for (let i = 0; i < tree.length; i++) {
		var y = weightsList[i - k] * 0.5 * increments;
		if (circles) { drawPoint(ctx, base_x, y + space_sum, 5, "black"); }
		
		if (i == 0) {
			y1 = space_sum + y;
		}
		
		var x = tree[i][1] * w;
		
		if (weightsList[i - k] > 1) {
			x = tree[i+1][1] * w;
			drawTree(ctx, w, y * 2, tree[i], x + base_x, space_sum, marg_height, 0);
			i++;
			k++;
		}
		
		if (i == tree.length - 1) {
			y2 = space_sum + y;
		}
		
		drawLine(ctx, base_x, y + space_sum, x + base_x, y + space_sum, "black");
		if (circles || base_x + x >= resolutionX * 0.9773809523809521) { drawPoint(ctx, base_x + x, y + space_sum, 5, "black"); }
		
		if (tree[i].length == 3 && typeof tree[i][0] === 'string') {
			for (let a = 0; a < tree[i][2].length; a++) {
				drawTriangle(ctx, base_x + (tree[i][2][a] * w), y + space_sum - 2, 14, "brown");
			}
		}
		
		
		space_sum += y * 2;
	}
	
	drawLine(ctx, base_x, y1, base_x, y2, "dark green");
}

function countChildren(obj, already_counted) {
	if (typeof(obj[1]) == "number") {
		// console.log(already_counted);
		return already_counted + 1
	} else {
		for (let i = 0; i < obj.length; i++) {
			// console.log(obj[i]);
			// console.log(already_counted);
			already_counted = countChildren(obj[i], already_counted);
		}
	}
	return already_counted;
}

function clear_board(ctx) {
	ctx.fillStyle = board_background;
	ctx.strokestyle = board_border;
	ctx.fillRect(0, 0, board.width, board.height);
	ctx.strokeRect(0, 0, board.width, board.height);
}

function drawPoint(context, x, y, r, color, outline = false) {
	context.beginPath();
	context.arc(x, y, r, 0, 2 * Math.PI, false);
	context.fillStyle = color;
	context.fill();
	context.lineWidth = 5;
	
	if (outline) {
		context.strokeStyle = 'black';
		context.stroke();
	}
}

function drawLine(context, x1, y1, x2, y2, color, width = 3) {
    // set line stroke and line width
    context.strokeStyle = color;
    context.lineWidth = width;

    // draw a red line
    context.beginPath();
    context.moveTo(x1, y1);
    context.lineTo(x2, y2);
    context.stroke();
}

function drawTriangle(ctx, x, y, size, color) {

	ctx.beginPath();
	ctx.fillStyle = color;
	ctx.moveTo(x, y - (size/2));
	ctx.lineTo(x - (Math.tan(0.523599) * size), y + (size/2));
	
	ctx.lineTo(x + (Math.tan(0.523599) * size), y + (size/2));
	
	ctx.fill();
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

ready();
main();