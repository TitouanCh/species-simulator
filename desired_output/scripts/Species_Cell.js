// Classe des cases
class Species_Cell {
	x = 0;
	y = 0;
	age = 0;
	espece = 0;
	nextEspece = 0;
	tauxReproduction = 10;
	tauxPredation = 5;
	ageMax = 20;
	couleur = 'lightblue';
	voisins = [];


	constructor(x, y, espece) {
		this.x = x;
		this.y = y;
	
	}
	
	setupEspece(x, y = 0) {
		this.espece = x
		
		// Espece 0 correspond à une case vide
		if (this.espece == 0){
			this.tauxReproduction = 0;
			this.ageMax = 0;
			this.couleur = '#edf2f8';
			this.tauxPredation = 0;
		
		} else {
			this.tauxReproduction = y[x-1][0];
			this.ageMax = y[x-1][1];
			this.couleur = y[x-1][2];
			this.tauxPredation = y[x-1][3];
		}
		
	}
	
	rechercheDesVoisins(listeDeCases){
		var xi = this.x
		var yi = this.y
		var liste = []
		
		var idx = 0
		listeDeCases.forEach(function(item){
			if (Math.abs(item.x-xi)+ Math.abs(item.y-yi) <= 1) {
				liste.push(idx)
			}
			
			idx += 1
		})
		
		this.voisins = liste
	}
}