var species_simulation = new Ssimulation(
    document.getElementsByClassName("simulation_canvas")[0],
    60,
    'white',
    'white',
    species_ready,
    species_main
);

// Specie format: [Reproduction Rate, Max Age, Color, Predation Rate, [Diet]]
species_simulation.species_data = [ [10, 30, '#7c9ac2', 5, [false, false]], [10, 20, '#293e58', 5, [false, false]] ];
species_simulation.species_data_cached = species_simulation.species_data.slice();
species_simulation.grid = [];
species_simulation.canvas_height = species_simulation.board.height;
species_simulation.canvas_width = species_simulation.board.width;
species_simulation.cell_height = 10;
species_simulation.cell_width = 10;
species_simulation.grid_height = 0;
species_simulation.grid_width = 0;
species_simulation.offset_height = (species_simulation.board.height % species_simulation.cell_height)/2;
species_simulation.offset_width = (species_simulation.board.width % species_simulation.cell_width)/2;
species_simulation.predation = 2;
species_simulation.ageMax = true;
species_simulation.ratios = [species_simulation.canvas_width, species_simulation.canvas_height, species_simulation.cell_width, species_simulation.cell_height];
species_simulation.start = species_start;
species_simulation.next_basis = [];
species_simulation.step = species_step;
species_simulation.draw = species_draw;
species_simulation.once = true;
species_simulation.add_species = addSpecies;
species_simulation.delete_species = deleteSpecies;
species_simulation.show_species = showSpecies;
species_simulation.resize = species_resize;

startSimulation(species_simulation);

function species_ready() {
	this.start();
}

function species_main() {
	setTimeout(() => {
		if (!this.pause) {
			this.draw();
			this.step();
		}
		this.main();
	}, 1000/this.FPS);
}

// Randomly 'sprinkle' species on a grid
function species_sprinkle(grid, p, species_data) {
	grid.forEach(function(item) {
        var is_specie = Math.random();
        if (is_specie <= p) {
            item.setupEspece(getRandomInt(0, species_data.length + 1), species_data);
        }
    })
	return grid;
}

// Start/restart function
function species_start() {
    //initDatabase();
	this.grid = [];

	if (!this.once) {
		this.canvas_width = parseInt(document.getElementById("tableWidth").value);
		this.canvas_height = parseInt(document.getElementById("tableHeight").value);
		
		this.cell_width = parseInt(document.getElementById("cellWidth").value);
		this.cell_height = parseInt(document.getElementById("cellHeight").value);

		this.ratios = [species_simulation.canvas_width, species_simulation.canvas_height, species_simulation.cell_width, species_simulation.cell_height];
		species_simulation.board.height = this.canvas_height;
		species_simulation.board.width = this.canvas_width;
		// console.log(species_simulation.board.width);
		
		
		// probaParsemage = parseInt(document.getElementById("probaParsemage").value);
		
		this.FPS = parseInt(document.getElementById("FPS").value);

	} else {
		document.getElementById("tableWidth").value = this.canvas_width;
		document.getElementById("tableHeight").value = this.canvas_height;
				
		document.getElementById("cellWidth").value = this.cell_width;
		document.getElementById("cellHeight").value = this.cell_height;

		this.show_species()
	}

	this.next_basis = [];
	var idx = 1;
	this.species_data.forEach((species) => {
		if (!this.once) {
			console.log(document.getElementById("couleurEspece" + idx))
			species[2] = document.getElementById("couleurEspece" + idx).value;
			species[0] = parseInt(document.getElementById("tauxReproductionEspece" + idx).value);
			species[3] = parseInt(document.getElementById("tauxPredationEspece" + idx).value);
			species[1] = parseInt(document.getElementById("ageMaxEspece" + idx).value);
			
			species[4] = []
			
			for (a = 1; a <= this.species_data.length; a++) {
				if (document.getElementById('regimeEspece' + idx + 'for' + a).checked){
					species[4].push(true)
				} else {
					species[4].push(false)
				}
			}
			
			idx += 1;
		}
		this.next_basis.push(0)
	})
	
	this.species_data_cached = this.species_data.slice();
	
	setupWorker = new Worker("./scripts/species-simulator/species_worker.js");
	setupWorker.postMessage(this.ratios);
	
	setupWorker.onmessage = (event) => {

		setupWorker.terminate();
		setupWorker = undefined;
		
		this.grid = event.data;
		
	    this.grid.forEach(function(item) {
			reattachMethods(item, Species_Cell);
		})
		
		this.grid = species_sprinkle(this.grid, 0.01, this.species_data_cached);
		//generation = 0;
		//totalRessources = this.grid.length;
		//restartGraph();
		
		//document.getElementById('pause').checked = false;*

		this.grid_height = (this.ratios[1] - (this.offset_height * 2)) / this.ratios[3];
		this.grid_width = (this.ratios[0] - (this.offset_width * 2)) / this.ratios[2];
	};

    setupWorker.onerror = function(err) {
        console.log("error " + err.message);
    }

	this.pause = false;
	this.once = false;
}

// Drawing function
function species_draw() {

	var xoffset = [0, 0];

	xoffset[1] = this.offset_height + 5;
	xoffset[0] = (this.board.width - (this.grid_width * this.ratios[3]))/2;

	this.grid.forEach((item) => {
		this.board_ctx.fillStyle = item.couleur;
		this.board_ctx.fillRect(xoffset[0] + item.x * this.ratios[2], xoffset[1] + item.y * this.ratios[3], this.ratios[2], this.ratios[3]);
	})
	
	// document.getElementById("compteur").innerHTML = "Nombre d'individus: " + totalIndividus + "</br> Nombre de ressources: " + totalRessources;
	
	/*
	var passGraph = []
	for (let i = 0; i < especePopulation.length; i += 1){
		passGraph.push([(especePopulation[i]/totalRessources)*(graphHauteur - (graphScaleOffset*2)), especesDataCached[i][2]]);
	}
	
	if (especePopulation.length > 1){
		passGraph.push([(totalIndividus/totalRessources)*(graphHauteur - (graphScaleOffset*2)), 'pink']);
	}
	
	graphCalc(passGraph, generation);
	*/
}

// Steps through simulation
function species_step() {
	
	//totalIndividus = 0;
	//especePopulation = nextEspeceBase.slice(0);

	this.grid.forEach(item => {
	
		item.nextEspece = this.next_basis.slice(0);
		
		// Reproduction (seulement sur case vide)
		if (item.espece == 0) {
			item.voisins.forEach((voisin) => {
				var b = getRandomInt(1, 100);
				if (b <= this.grid[voisin].tauxReproduction) {
					item.nextEspece[this.grid[voisin].espece - 1] += 1;
				}
			})
		}
		
		if (item.espece > 0) {
			
			// Sauvegarde de l'espece précédente
			item.nextEspece[item.espece - 1] += 1;
			
			// Prédation
			if (this.predation) {
				item.voisins.forEach((voisin) => {
					// Cannibalisme = NON enfait si :)
					if (this.grid[voisin].espece > 0 && this.species_data_cached[this.grid[voisin].espece - 1][4][item.espece - 1]) {
						var b = getRandomInt(1, 100)
						if (b <= this.grid[voisin].tauxPredation) {
							item.nextEspece[this.grid[voisin].espece - 1] += this.predation;
						}
					}
				})
			}
			
			if (this.ageMax) {
				// Viellissement
				item.age += 1;
				
				// Mort de Viellesse
				if (item.age == item.ageMax){
					item.nextEspece = [0,0];
				}
			}
		
			// Comptage Individus
			//totalIndividus += 1;
			//especePopulation[item.espece-1] += 1
		}
		
		
	})
		
	// Changement des cases
	this.grid.forEach((item) => {
		var nextEspeceIdx = calculNextEspece(item.nextEspece);
		
		if (item.espece != nextEspeceIdx + 1) {
			item.age = 0;
		}
		
		item.setupEspece(nextEspeceIdx + 1, this.species_data_cached);
	})
}

// Fonction qui check nextEspece
function calculNextEspece(arr) {
    var max = arr[0];
    var maxIndex = 0;
	
    for (var i = 1; i < arr.length; i++) {
		
		if (arr[i] == max) {
			maxIndex = -1;
		}
	
        if (arr[i] > max) {
            maxIndex = i;
            max = arr[i];
        }
		
    }
	
	if (max == 0) {
		maxIndex = -1;
	}

    return maxIndex;
}

// Displaying functions ---

// Add species to display
function addSpecies() {
	var predationMatrix = [false]
	
	for (idx = 0; idx < this.species_data.length; idx++) {
		this.species_data[idx][4].push(false)
		predationMatrix.push(false)
	}
	
	this.species_data.push([10, 30, '#3b6584', 5, predationMatrix]);
	this.show_species();
}

// Delete species from display
function deleteSpecies() {
	this.species_data.pop();
	this.show_species();
}

// Show the different species
function showSpecies() {
	// Duplicated to window resize
	if (this.board.parentElement.clientWidth > 705) {
		document.getElementById("speciesPanel").style.display = "grid";
	} else {
		document.getElementById("speciesPanel").style.display = "auto";
	}

	var idx = 1
	var string = '';
	this.species_data.forEach((ispecies) => {
		string += '<div style="margin-top: 29px; grid-column: ' + (idx % 3) + '; grid-row: ' + (Math.floor((idx-1) / 3) + 1) + ';">'
		string += '<div style="font-style: italic;">Specie ' + idx + ' --</div style="font-style: italic;">';
		
		string += 'Color: ' + '<input type="color" value="' + ispecies[2] + '" id="couleurEspece' + idx + '">';
		string += '<label class ="hiddenLabel" for="couleurEspece' + idx + '">Sélectionner la couleur de l\'espèce ' + idx + '.</label>';
		
		string += '</br>Probability of Reproduction: ' + '<input type="number" min="1" max="100" value="' + ispecies[0] + '" id="tauxReproductionEspece' + idx + '">%';
		string += '<label class ="hiddenLabel" for="tauxReproductionEspece' + idx + '">Choose a reproduction percentage for the specie ' + idx + '.</label>';
		
		string += '</br>Probability of Predation: ' + '<input type="number" min="1" max="100" value="' + ispecies[3] + '" id="tauxPredationEspece' + idx + '">%';
		string += '<label class ="hiddenLabel" for="tauxPredationEspece' + idx + '">Choose a predation percentage for the specie ' + idx + '.</label>';
		
		string += '</br>Preys on: '
		
		var idx2 = 1
		this.species_data.forEach((jspecies) => {
			string += '<label for="regimeEspece' + idx + 'for' + idx2 + '" style ="visibility: visible; display: inline;">Specie ' + idx2 + ' </label><input id="regimeEspece' + idx + 'for' + idx2 + '" type="checkbox"/>'
			if (idx2 != this.species_data.length){
				string += ', '
			}
			
			string += '';
			
			idx2 += 1
		})
		
		string += '</br>Life expectancy: ' + '<input type="number" min="1" max="500" value="' + ispecies[1] + '" id="ageMaxEspece' + idx + '">';
		string += '<label class ="hiddenLabel" for="ageMaxEspece' + idx + '">Maximum age for specie ' + idx + '.</label>';
		string += '</div>'
		
		idx += 1;
	})

	document.getElementById("speciesPanel").innerHTML = string;
}

function species_resize() {
	this.board.width = this.board.parentElement.clientWidth;
	this.board_ctx.fillStyle = "white";
	this.board_ctx.fillRect(0, 0, this.board.width, this.board.height);

	if (this.board.parentElement.clientWidth > 705) {
		document.getElementById("speciesPanel").style.display = "grid";
	} else {
		document.getElementById("speciesPanel").style.display = "block";
	}
}