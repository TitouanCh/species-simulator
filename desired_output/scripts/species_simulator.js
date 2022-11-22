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
species_simulation.start = species_start;

startSimulation(species_simulation);

function species_ready() {
    this.start(this.species_data, this.grid);
    console.log(this.grid);
}

function species_main() {

}

// Randomly 'sprinkle' species on a grid
function species_sprinkle(grid, p, species_data) {
	grid.forEach(function(item) {
        var is_specie = Math.random();
        if (is_specie <= p) {
            item.setupEspece(getRandomInt(0, species_data.length), species_data);
        }
    })
}

// Start/restart function
function species_start(species_data, grid) {
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
	setupWorker.postMessage([this.canvas_width, this.canvas_height, this.cell_width, this.cell_height]);
	
	setupWorker.onmessage = function(event) {

		setupWorker.terminate();
		setupWorker = undefined;
		
		grid = event.data
		
	    grid.forEach(function(item){
			reattachMethods(item, Species_Cell);
		})
		
		species_sprinkle(grid, 0.01, species_data);
        console.log(grid);
		//generation = 0;
		//totalRessources = listeCases.length;
		//restartGraph();
		
		//document.getElementById('pause').checked = false;
	};

    setupWorker.onerror = function(err) {
        console.log("error " + err.message);
    }
}