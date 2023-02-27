var particle_life = new Ssimulation(
	document.getElementsByClassName("simulation_canvas")[0],
    120,
    'white',
    'white',
    particle_ready,
    particle_main
);


// Format : [0: specie, 1: x, 2: y, 3: vx, 4: vy, 5: nx, 6: ny, 7: partitionx, 8: partitiony]
particle_life.data = [];
particle_life.force_book = [];
particle_life.mass_book = [];
particle_life.color_palette = ["#597d64", "#e8094a", "#315465", "#7b118b", "#02aacf", "#bfe6c7", "#6e4358", "#305557"] // DYNAMITE
particle_life.number_of_species = 6;
particle_life.g = 0.0981;
particle_life.drag = 0.98
particle_life.number_of_individuals;

// Space Partitionning
particle_life.space_partitioning = true;
particle_life.partitions = [];
particle_life.max_distance_force = 300.0;

particle_life.setup_force_book = setup_force_book;
particle_life.setup_mass_book = setup_mass_book;
particle_life.setup_space_partitioning = setup_space_partitioning;
particle_life.populate = populate;
particle_life.force_output = force_output;

particle_life.draw = particle_draw;
particle_life.process = particle_process;

startSimulation(particle_life);

function particle_ready() {
	
	this.resolutionX = document.getElementById("enviroWidth").value;
	this.resolutionY = document.getElementById("enviroHeight").value;
	
	this.board.width = this.resolutionX;
	this.board.height = this.resolutionY;
	
	this.g = parseFloat(document.getElementById("G").value);
	this.drag = parseFloat(document.getElementById("drag").value);
	
	if (document.getElementById("nbEspece").value <= 8) {
		this.number_of_species = document.getElementById("nbEspece").value;
	} else {
		this.number_of_species = 8;
		document.getElementById("nbEspece").value = 8;
	}

	this.force_book = this.setup_force_book(this.number_of_species);
	this.mass_book = this.setup_mass_book(this.number_of_species);

	this.data = this.populate(document.getElementById("nbIndividus").value, this.number_of_species);
}

function particle_main() {
	setTimeout(() => {
	this.space_partitioning = document.getElementById("partitioning").checked;
	this.pause = document.getElementById("pause").checked;

	if (!this.pause){
		this.process(0.1);
		this.draw();
	}
	FPS = document.getElementById("fpsLimit").value;
	this.main();
  }, 1000/this.FPS)
}

function clear_board(board, board_ctx, board_background, board_border) {
	board_ctx.fillStyle = "rgba(255, 255, 255, 0.3)";
	board_ctx.strokestyle = board_border;
	board_ctx.fillRect(0, 0, board.width, board.height);
	board_ctx.strokeRect(0, 0, board.width, board.height);
}

function particle_draw() {
	clear_board(this.board, this.board_ctx, this.board_background, this.board_border);
	drawPoint(this.board_ctx, 20, 20, 20, "green");
	for (var i = 0; i < this.data.length; i++) {
		//drawPoint(this.board_ctx, this.data[i][1], this.data[i][2], 10, this.color_palette[this.data[i][8] + this.data[i][7]]);
		drawPoint(this.board_ctx, this.data[i][1], this.data[i][2], 10, this.color_palette[this.data[i][0]]);
	}
}

function particle_process(delta) {
	//console.log(this.data)
	if (this.space_partitioning) {
		// Clear partitions
		this.partitions = this.setup_space_partitioning(this.max_distance_force, this.resolutionX, this.resolutionY);
		
		// Place all the individuals in their respective partition
		for (let i = 0; i < this.data.length; i++) {
			let x = parseInt(Math.floor(this.data[i][1]/this.max_distance_force))
			let y = parseInt(Math.floor(this.data[i][2]/this.max_distance_force))
			this.data[i][7] = x;
			this.data[i][8] = y;
			this.partitions[y][x].push(i);
		}
	}

	for (var i = 0; i < this.data.length; i++) {
		var forceX = 0;
		var forceY = 0;
		
		// Calculate force other on self
		if (!this.space_partitioning) {
			for (var j = 0; j < this.data.length; j++) {
				if (j != i) {
					force_on_me = this.force_output(this.data[j], this.data[i]);
					forceX += force_on_me[0];
					forceY += force_on_me[1];
				}
			}
		} else {
			list = this.partitions[this.data[i][8]][this.data[i][7]];

			// up
			if (this.data[i][8] > 0) { list = list.concat(this.partitions[this.data[i][8] - 1][this.data[i][7]]); }
			// down
			if (this.data[i][8] < this.partitions.length - 1) { list = list.concat(this.partitions[this.data[i][8] + 1][this.data[i][7]]); }
			// left
			if (this.data[i][7] > 0) { list = list.concat(this.partitions[this.data[i][8]][this.data[i][7] - 1]); }
			// right
			if (this.data[i][7] < this.partitions[0].length - 1) { list = list.concat(this.partitions[this.data[i][8]][this.data[i][7] + 1]); }

			// up-left
			if (this.data[i][8] > 0 && this.data[i][7] > 0) { list = list.concat(this.partitions[this.data[i][8] - 1][this.data[i][7] - 1]); }
			// up-right
			if (this.data[i][8] > 0 && this.data[i][7] < this.partitions[0].length - 1) { list = list.concat(this.partitions[this.data[i][8] - 1][this.data[i][7] + 1]); }
			// down-left
			if (this.data[i][8] < this.partitions.length - 1 && this.data[i][7] > 0) { list = list.concat(this.partitions[this.data[i][8] + 1][this.data[i][7] - 1]); }
			// down-right
			if (this.data[i][8] < this.partitions.length - 1 && this.data[i][7] < this.partitions[0].length - 1) { list = list.concat(this.partitions[this.data[i][8] + 1][this.data[i][7] + 1]); }

			for (var j = 0; j < list.length; j++) {
				if (j != i) {
					force_on_me = this.force_output(this.data[list[j]], this.data[i]);
					forceX += force_on_me[0];
					forceY += force_on_me[1];
				}
			}
		}
		
		var accelX = forceX;
		var accelY = forceY;
		
		this.data[i][3] += accelX * delta; //vx
		this.data[i][4] += accelY * delta; //vy
		
		this.data[i][3] *= this.drag;
		this.data[i][4] *= this.drag;
		
		this.data[i][5] = this.data[i][1] + (d[i][3] * delta); //nx
		this.data[i][6] = this.data[i][2] + (this.data[i][4] * delta); //ny
		
		if (this.data[i][5] < 0) {
			this.data[i][5] = 0;
			this.data[i][3] = -this.data[i][3];
		}
		if (this.data[i][5] > this.resolutionX) {
			this.data[i][5] = this.resolutionX - 1;
			this.data[i][3] = -this.data[i][3];
		}
		if (this.data[i][6] < 0) {
			this.data[i][6] = 0;
			this.data[i][4] = -this.data[i][4];
		}
		if (this.data[i][6] > this.resolutionY) {
			this.data[i][6] = this.resolutionY - 1;
			this.data[i][4] = -this.data[i][4];
		}
		
	}
	
	for (var i = 0; i < this.data.length; i++) {
		this.data[i][1] = this.data[i][5]; //x
		this.data[i][2] = this.data[i][6]; //y
	}
}

function force_output(emitter, receiver) {
	var distance = norme2(emitter[1], emitter[2], receiver[1], receiver[2]);

	if (distance > 0.0 && distance < this.max_distance_force) {
		var normalizedVectorX = (receiver[1] - emitter[1]) / distance;
		var normalizedVectorY = (receiver[2] - emitter[2]) / distance;
		
		var fG = force_function(distance, this.force_book[emitter[0]][receiver[0]], this.g, 20.0)

		return [fG * normalizedVectorX, fG * normalizedVectorY];
	}

	return [0, 0];
}

function norme2(x1, y1, x2, y2) {
	return Math.sqrt(Math.pow(x1 - x2, 2) + Math.pow(y1 - y2, 2));
}

function force_function(distance, mass, g, radius) {
	force = 0;

	if (distance < radius + 10.0) {
		force = Math.pow(distance - 30, 2);
	}
	else if (distance > 250) {
		force = -(distance - 400)/10;
		force *= -1 * g * mass;
	}
	else if (distance > 100) {
		fG = (distance - 100)/10;
		fG *= -1 * g * mass;
	}

	return force;
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

function setup_force_book(num) {
	book = [];
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

	return book;
}

function setup_mass_book(book, num) {
	book = [];
	for (var i = 0; i < num; i++) {
		book.push(getRandomInt(1, 5))
	}

	return book
}

function setup_space_partitioning(max_distance_force, board_width, board_height) {
	let partition = [];
	//console.log(max_distance_force, board_width, board_height);
	for (let i = 0; i < board_height; i += max_distance_force) {
		row = [];
		for (let j = 0; j < board_width; j += max_distance_force) {
			row.push([]);
		}
		partition.push(row);
	}
	//console.log(partitions);
	return partition;
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min)) + min;
}

function populate(n, num) {
	d = [];
	for (var i = 0; i < n; i++) {
		d.push([i%num, getRandomInt(0, this.resolutionX), getRandomInt(0, this.resolutionY), 0, 0, 0, 0, 0, 0])
	}
	return d;
}

function restart() {
	particle_life.data = [] // [specie, x, y, vx, vy, nx, ny]
	particle_life.force_book = []
	particle_life.mass_book = []
	particle_life.color_palette = ["#597d64", "#e8094a", "#315465", "#7b118b", "#02aacf", "#bfe6c7", "#6e4358", "#305557"] // DYNAMITE

	particle_life.number_of_species = 6
	particle_life.g = 0.0981
	particle_life.ready();
}

