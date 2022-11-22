self.importScripts('Species_Cell.js');

onmessage = function(event) {
	
	var grid = [];
	
	var counter = 0;

	var ratios = event.data;
		
	for (let i = 0; i < ratios[0]; i += ratios[2]) {
		for (let j = 0; j < ratios[1]; j += ratios[3]) {
			var a = new Species_Cell(i/ratios[2], j/ratios[3], 0)
			a.setupEspece(0);
			grid.push(a);
			counter += 1;
		}
	}
	
	grid.forEach(function(item){
		item.rechercheDesVoisins(grid);
	});
	
	postMessage(grid);
};