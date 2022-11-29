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

startSimulation(species_simulation);

function species_ready() {
    this.start(this.species_data, this.ratios);
}

function species_main() {
	setTimeout(() => {
		this.draw();
		this.step();
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
function species_start(species_data, ratios) {
    //initDatabase();

    /*
	if (home) {
		longueurTableau = parseInt(document.getElementById("longueurTableau").value);
		hauteurTableau = parseInt(document.getElementById("hauteurTableau").value);
		
		longueurCase = parseInt(document.getElementById("longueurCase").value);
		hauteurCase = parseInt(document.getElementById("hauteurCase").value);
		
		
		probaParsemage = parseInt(document.getElementById("probaParsemage").value);
		
		FPS = parseInt(document.getElementById("FPS").value);
		
		var idx = 1;
	*/
	this.next_basis = [];
	species_data.forEach((espece) => {
		/*
		espece[2] = document.getElementById("couleurEspece" + idx).value;
		espece[0] = parseInt(document.getElementById("tauxReproductionEspece" + idx).value);
		espece[3] = parseInt(document.getElementById("tauxPredationEspece" + idx).value);
		espece[1] = parseInt(document.getElementById("ageMaxEspece" + idx).value);
		
		espece[4] = []
		
		for (a = 1; a <= especesData.length; a++) {
			if (document.getElementById('regimeEspece' + idx + 'for' + a).checked){
				espece[4].push(true)
			} else {
				espece[4].push(false)
			}
		}
		
		idx += 1;
		*/
		this.next_basis.push(0)
	})
	
	//especesDataCached = especesData.slice();
	
	setupWorker = new Worker("./scripts/species_worker.js");
	setupWorker.postMessage(ratios);
	
	setupWorker.onmessage = (event) => {

		setupWorker.terminate();
		setupWorker = undefined;
		
		this.grid = event.data;
		
	    this.grid.forEach(function(item) {
			reattachMethods(item, Species_Cell);
		})
		
		this.grid = species_sprinkle(this.grid, 0.01, species_data);
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
					if (this.grid[voisin].espece > 0 && this.species_data[this.grid[voisin].espece - 1][4][item.espece - 1]) {
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
		
		//console.log(this.species_data)
		item.setupEspece(nextEspeceIdx + 1, this.species_data);
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