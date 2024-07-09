// Wait for module to initialize,
createModule().then(({PunkSystem}) => {
    // Perform computation
    evolutionary.punksystem = new PunkSystem();
    for (let i = 0; i < 100; i++) {
        evolutionary.punksystem.add_PunkObject(getRandomFloat(0, 900), getRandomFloat(0, 900), getRandomFloat(5, 18));
    }
    evolutionary.punksystem.process(16, 0.1);
    evolutionary.data = evolutionary.punksystem.finished;
 });

var evolutionary = new Ssimulation(
	document.getElementsByClassName("simulation_canvas")[0],
    60,
    'blue',
    'blue',
    evolutionary_ready,
    evolutionary_main
);


/* Format [
    [ Frame
        [ Regular
            [[x, y, m], etc...],
        ]
    ]
]

data[frame][category_of_object][object_id][object_propertie]
except it's a C++ array
*/
evolutionary.data = undefined;
evolutionary.frame = -1;
evolutionary.draw = evolutionary_draw;
evolutionary.process = evolutionary_process;

evolutionary.palette = ["#55607d", "#41de95", "#c4651c", "#3b77a6", "#ea619d", "#b54131", "#3e415f", "#c1e5ea"]
evolutionary.mouse_x = 0;
evolutionary.mouse_y = 0;


startSimulation(evolutionary);

function evolutionary_ready() {
	this.resolutionX = document.getElementById("enviroWidth").value;
	this.resolutionY = document.getElementById("enviroHeight").value;
}

function evolutionary_main() {
	setTimeout(() => {
	if (!this.pause) {
		this.process();
        this.draw();
	}
	this.main();
  }, 1000/this.FPS)
}

function clear_board(board, board_ctx, board_background, board_border) {
	board_ctx.fillStyle = "rgba(25, 24, 42, " + document.getElementById("trail").value.toString() + ")";
	board_ctx.strokestyle = board_border;
	board_ctx.fillRect(0, 0, board.width, board.height);
	board_ctx.strokeRect(0, 0, board.width, board.height);
}

function evolutionary_draw() {
	clear_board(this.board, this.board_ctx, this.board_background, this.board_border);
	
    /*
    // Body Test
    for (var i = 0; i < this.palette.length; i++) {
        drawPoint(this.board_ctx, 20 + i*30, 20, 12 + i, this.palette[i]);
    } 

    // Muscle Test
    var x1 = 120;
    var x2 = this.mouse_x;
    var y1 = 70;
    var y2 = this.mouse_y;
    var mass1 = 16;
    var mass2 = 14;
    
    drawMuscle(this.board_ctx, x1, y1, x2, y2, 20, 30, this.palette[5], norme2);
    drawPoint(this.board_ctx, x1, y1, mass1, this.palette[0]);
    drawPoint(this.board_ctx, x2, y2, mass2, this.palette[0]);
    drawEllipseByCenter(this.board_ctx, 40, 60, 20, 30);
    */

    if (this.frame >= 0) {
        frame_data = evolutionary.punksystem.get_frame_PunkObject(this.frame);
        for (let i = 0; i < frame_data.size(); i++) {
            datapoint = frame_data.get(i);
            drawPoint(this.board_ctx, datapoint.get(0), datapoint.get(1), datapoint.get(2), this.palette[0]);
        }
    }
    
}

function evolutionary_process(delta) {
	if (this.data) {
        this.frame = (this.frame + 1) % 200;
    } else {
        this.frame = -1;
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

function drawEllipseByCenter(ctx, cx, cy, w, h, color) {
    drawEllipse(ctx, cx - w/2.0, cy - h/2.0, w, h, color);
}

function drawMuscle(context, x1, y1, x2, y2, mass1, mass2, color, norme) {
    // Vector : (x1, y1) --> (x2, y2)
    var vec_x = x2 - x1;
    var vec_y = y2 - y1;

    // Middle point between (x1, y2), (y1, y2)
    var xm = ((x1 * mass1) + (x2 * mass2))/(mass1 + mass2);
    var ym = ((y1 * mass1) + (y2 * mass2))/(mass1 + mass2);

    // Point so that <(x1, y2) --> (y1, y2), (xm, ym) --> (xprime, yprime)> = 0
    var xprime = xm + 10;
    var yprime = ((ym * vec_y) + (xm * vec_x) - (xprime * vec_x))/vec_y;

    var ortho_distance = norme(xm, ym, xprime, yprime);
    var ortho_vec_norm_x = (xprime - xm) / ortho_distance;
    var ortho_vec_norm_y = (yprime - ym) / ortho_distance;

    var xfinal1 = xm + ortho_vec_norm_x * (mass1 + mass2)/2;
    var yfinal1 = ym + ortho_vec_norm_y * (mass1 + mass2)/2;

    var xfinal2 = xm - ortho_vec_norm_x * (mass1 + mass2)/2;
    var yfinal2 = ym - ortho_vec_norm_y * (mass1 + mass2)/2;

    // Debug --
    drawPoint(context, x1, y1, 4, "green");
    drawPoint(context, x2, y2, 4, "green");
    drawPoint(context, xm, ym, 4, "red");
    drawPoint(context, xprime, yprime, 4, "purple");
    drawPoint(context, xfinal1, yfinal1, 8, "orange");

    context.fillStyle = color;
    context.beginPath();
    context.moveTo(x1, y1);
    context.quadraticCurveTo(xfinal1, yfinal1, x2, y2);
    context.quadraticCurveTo(xfinal2, yfinal2, x1, y1);
    context.fill();
}


function drawEllipse(ctx, x, y, w, h, color) {
    var kappa = .5522848,
        ox = (w / 2) * kappa, // control point offset horizontal
        oy = (h / 2) * kappa, // control point offset vertical
        xe = x + w,           // x-end
        ye = y + h,           // y-end
        xm = x + w / 2,       // x-middle
        ym = y + h / 2;       // y-middle
    
    ctx.fillStyle = color;

    ctx.beginPath();
    ctx.moveTo(x, ym);
    ctx.bezierCurveTo(x, ym - oy, xm - ox, y, xm, y);
    ctx.bezierCurveTo(xm + ox, y, xe, ym - oy, xe, ym);
    ctx.bezierCurveTo(xe, ym + oy, xm + ox, ye, xm, ye);
    ctx.bezierCurveTo(xm - ox, ye, x, ym + oy, x, ym);
    //ctx.closePath(); // not used correctly, see comments (use to close off open path)
    ctx.fill();
  }

function restart() {
	evolutionary.ready();
}

function norme2(x1, y1, x2, y2) {
	return Math.sqrt(Math.pow(x1 - x2, 2) + Math.pow(y1 - y2, 2));
}

function getRandomFloat(min, max) {
    return Math.random() * (max - min);
}

window.addEventListener("mousemove", e => {
    evolutionary.mouse_x = e.clientX;
    evolutionary.mouse_y = e.clientY;
});
