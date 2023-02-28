var particle_life = new Ssimulation(
	document.getElementsByClassName("simulation_canvas")[0],
    60,
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
particle_life.number_of_individuals = 200;
particle_life.norme = "norme1";

// Space Partitionning
particle_life.space_partitioning = true;
particle_life.partitions = [];
particle_life.max_distance_force = 400.0;

// Multithreading
particle_life.multithread = true;
particle_life.worker_number = 4;
particle_life.threads_active = 0;
particle_life.worker_list = [];

particle_life.setup_force_book = setup_force_book;
particle_life.setup_mass_book = setup_mass_book;
particle_life.setup_space_partitioning = setup_space_partitioning;
particle_life.setup_multithreading = setup_multithreading;
particle_life.populate = populate;
particle_life.force_output = force_output;

particle_life.draw = particle_draw;
particle_life.process = particle_process;

startSimulation(particle_life);

function particle_ready() {
	
	this.resolutionX = document.getElementById("enviroWidth").value;
	this.resolutionY = document.getElementById("enviroHeight").value;

	this.multithread = document.getElementById("multithreading").checked;

	if (this.multithread) {
		this.setup_multithreading();
	}
	
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

	this.number_of_individuals = document.getElementById("nbIndividus").value;

	this.data = this.populate(document.getElementById("nbIndividus").value, this.number_of_species);
}

function particle_main() {
	setTimeout(() => {
	this.space_partitioning = document.getElementById("partitioning").checked;
	this.pause = document.getElementById("pause").checked;
	this.norme = document.getElementById("norme").value;

	if (!this.pause && (!this.multithread || this.threads_active == 0)){
		this.process(0.1);
	}
	
	this.main();
  }, 1000/this.FPS)
}

function clear_board(board, board_ctx, board_background, board_border) {
	board_ctx.fillStyle = "rgba(255, 255, 255, " + document.getElementById("trail").value.toString() + ")";
	board_ctx.strokestyle = board_border;
	board_ctx.fillRect(0, 0, board.width, board.height);
	board_ctx.strokeRect(0, 0, board.width, board.height);
}

function particle_draw() {
	clear_board(this.board, this.board_ctx, this.board_background, this.board_border);
	for (var i = 0; i < this.data.length; i++) {
		//drawPoint(this.board_ctx, this.data[i][1], this.data[i][2], 10, this.color_palette[this.data[i][8] + this.data[i][7]]);
		drawPoint(this.board_ctx, this.data[i][1], this.data[i][2], 10, this.color_palette[this.data[i][0]]);
	}
}

function particle_process(delta) {
	if (this.space_partitioning || this.multithread) {
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

	if (!this.multithread) {
		this.timenow = new Timer().start();
		for (var i = 0; i < this.data.length; i++) {

			this.data[i] = process_point(this.data[i], i, this.data, this.force_book, this.mass_book, this.resolutionX, this.resolutionY,
				this.g, this.drag, this.max_distance_force, particle_life.norme, "basic_force_function", delta, this.space_partitioning, this.partitions);
			
		}

		for (var i = 0; i < this.data.length; i++) {
			this.data[i][1] = this.data[i][5]; //x
			this.data[i][2] = this.data[i][6]; //y
		}
		
		this.draw()
	} else {
		this.timenow = new Timer().start();
		for (let i = 0; i < this.worker_list.length; i++) {
			worker_input = [
				i, this.data, this.partitions, this.worker_list[i].assigned_partitions,
				this.force_book, this.mass_book, this.resolutionX, this.resolutionY, this.g, this.drag, this.max_distance_force, particle_life.norme, "basic_force_function", delta, this.space_partitioning
			];

			this.worker_list[i].postMessage(worker_input);
			this.threads_active++;
			
		}

		multithread = false;
		
		this.data = [];
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

function setup_multithreading() {
	this.partitions = this.setup_space_partitioning(this.max_distance_force, this.resolutionX, this.resolutionY);

	for (let i = 0; i < this.worker_number; i++) {
		this.worker_list.push(new Worker("./scripts/particle-life/particle_worker.js"));
	}

	partitions_x = this.partitions[0].length;
	partitions_y = this.partitions.length;
	total_partitions = partitions_x * partitions_y;
	partition_per_worker = Math.ceil(total_partitions/this.worker_number);

	for (let i = 0; i < total_partitions; i += partition_per_worker) {
		assigned_partitions = [];
		for (let j = 0; j < partition_per_worker; j++) {
			if (i + j < total_partitions) {
				x = parseInt((i + j) % partitions_x);
				y = parseInt(Math.floor((i + j) / partitions_x));
				assigned_partitions.push([y, x]);
			}
		}

		worker_id = Math.floor(i/partition_per_worker);
		this.worker_list[worker_id].worker_id = worker_id;
		this.worker_list[worker_id].assigned_partitions = assigned_partitions;

		this.worker_list[worker_id].onmessage = (event) => {
			this.threads_active--;

			this.data = this.data.concat(event.data[1]);

			if (this.data.length == this.number_of_individuals) {
				for (var i = 0; i < this.data.length; i++) {
					this.data[i][1] = this.data[i][5]; //x
					this.data[i][2] = this.data[i][6]; //y
				}
				
				this.draw();
				
			}
		}
	}
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
	
	for (let j = 0; j < particle_life.worker_list.length; j++) {
		particle_life.worker_list[j].terminate();
	}
	particle_life.worker_list = []
	particle_life.threads_active = 0;

	particle_life.ready();
}

