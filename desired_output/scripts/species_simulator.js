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
species_simulation.canvas_height = 400;
species_simulation.canvas_width = 400;
species_simulation.cell_height = 10;
species_simulation.cell_width = 10;
species_simulation.ratios = [species_simulation.canvas_width, species_simulation.canvas_height, species_simulation.cell_width, species_simulation.cell_height];
species_simulation.start = species_start;

startSimulation(species_simulation);

function species_ready() {
    this.start(this.species_data, this.ratios);
}

function species_main() {
	setTimeout(() => {
		species_draw(this.grid, this.ratios, this.board_ctx);
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
		especesData.forEach(function(espece) {
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
			
			nextEspeceBase.push(0)
		})
    */
	
	//especesDataCached = especesData.slice();
	
	setupWorker = new Worker("./scripts/species_worker.js");
	setupWorker.postMessage(ratios);
	
	setupWorker.onmessage = (event) => {

		setupWorker.terminate();
		setupWorker = undefined;
		
		this.grid = event.data
		
	    this.grid.forEach(function(item) {
			reattachMethods(item, Species_Cell);
		})
		
		this.grid = species_sprinkle(this.grid, 0.01, species_data);
		//generation = 0;
		//totalRessources = listeCases.length;
		//restartGraph();
		
		//document.getElementById('pause').checked = false;
	};

    setupWorker.onerror = function(err) {
        console.log("error " + err.message);
    }
}

// Drawing function
function species_draw(grid, ratios, ctx) {
	grid.forEach(function(item){
		ctx.fillStyle = item.couleur;
		ctx.fillRect(item.x * ratios[2], item.y * ratios[3], ratios[2], ratios[3]);
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