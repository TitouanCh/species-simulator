self.importScripts('case-AbeilleOnly.js');

onmessage = function(event) {
	
	var listeCases = []
	
	var compteur = 0
	
	var ratios = event.data;
		
	for (let i = 0; i < ratios[0]; i += ratios[2]) {
		for (let j = 0; j < ratios[1]; j += ratios[3]) {
			var a = new Case(i/ratios[2], j/ratios[3], 0)
			a.setupEspece(0)
			listeCases.push(a)
			compteur += 1;
		}
	}
	
	listeCases.forEach(function(item){
		item.rechercheDesVoisins(listeCases);
	});
	
	postMessage(listeCases);
	
};