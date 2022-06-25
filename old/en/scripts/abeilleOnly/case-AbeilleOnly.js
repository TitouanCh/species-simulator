// Classe des cases
class Case {
	x = 0;
	y = 0;
	age = 0;
	espece = 0;
	nextEspece = 0;
	tauxReproduction = 10;
	tauxPredation = 5;
	mvtSpeed = 0;
	ageMax = 20;
	couleur = 'lightblue';
	voisins = [];
	taken = false;
	mode = 0; // Utile pour les drones: mode 0: Scavenge mode 1: Return to hive mode 2: Colonize
	pheromone = [0, 0, 0, 0]; // Format = [BlueBee, RedBee, BlueFrelon, RedFrelon]


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
			this.couleur = '#3ca370';
			this.tauxPredation = 0;
			this.mvtSpeed = 0;
			this.taken = false;
		
		} else {
			this.tauxReproduction = y[x-1][0];
			this.ageMax = y[x-1][1];
			if (this.espece == 2 || this.espece == 4) {
				this.couleur = y[x-1][2][this.mode];
			} else {
				this.couleur = y[x-1][2];
			}
			this.tauxPredation = y[x-1][3];
			this.mvtSpeed = y[x-1][5];
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