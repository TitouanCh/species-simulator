const board_border = 'black';
const board_background = "white";

// pallette! https://lospec.com/palette-list/pear36

var home;

var longueurTableau = 1000;
var hauteurTableau = 1000;

var longueurCase = 10;
var hauteurCase = 10;

var viewMode = 1;

var FPS = 50;

var nombreIndividus;
var totalRessources = 2500;
var predationPower = 2;

var generationInvasion = 500;
var invasionIndex = 0;
var invasionPower = 3;

var predationOn = true;
var ageMaxOn = true;

// Get the canvas element
const board = document.getElementById("board");
// Return a two dimensional drawing context
const board_ctx = board.getContext("2d");

var workerPath = "../scripts/abeilleOnly/setupworker-AbeilleOnly.js";

var listeCases = [];
var probaParsemage = 1000;

// Données des espèces, format: [tauxReproduction, ageMax, couleur, tauxPredation, [régime], moveChance]
// Pour les abeilles espece 1: AbeilleRuche, espece 2: AbeilleDrone ; 
// espece 3 : FrelonRuche, espece 4 : FrelonDrone ;
// espece 5 : Fleur, espece 6 : Graine ;
var especesData = [ 
[8, 2000, '#ffe478', 0, [false, false, false, false, false, false], 0], //AbeilleRuche
[0, 500, ['#ffb570', '#f2a65e', '#ba6156'], 0, [false, false, false, false, false, false], 50], // AbeilleDrone
[4, 3000, '#ff6b97', 0, [false, false, false, false, false, false], 0], //FrelonRuche
[0, 500, ['#66ffe3', '#4da6ff', '#4b5bab'], 10, [false, true, false, false, false, false], 50], // FrelonDrone
[1, 450, '#3d6e70', 0, [false, false, false, false, false, false], 0], // Fleur
[0, 100, '#8c3f5d', 0, [false, false, false, false, false, false], 10], // Graine
[0, 1, '#7e7e8f', 0, [false, false, false, false, false, false], 0] // DEAD
];

var especePopulation = []
var especesDataCached = especesData.slice();
var nextEspeceBase = []
var generation = 0



// Parseme aléatoirement quelques animaux d'espèces différentes
function parsemer() {
	
	var idx;
	
	// Ajout de graines
	for (let i = 0; i < invasionPower*5; i += 1) {
		idx = getRandomInt(0, listeCases.length - 1);
		listeCases[idx].setupEspece(6, especesDataCached);
	}
}

// Fonction qui démarre/redémarre la simulation
function restart(){
	listeCases = [];
	initDatabase();
	nextEspeceBase = [];
	invasionIndex = 0;
	
	especesData.forEach(function(espece) {
		nextEspeceBase.push(0);
	})
	
	especesDataCached = especesData.slice();
	
	setupWorker = new Worker(workerPath);
	setupWorker.postMessage([longueurTableau, hauteurTableau, longueurCase, hauteurCase]);
	
	setupWorker.onmessage = function(event){

		setupWorker.terminate();
		setupWorker = undefined;
		
		listeCases = event.data
		
		listeCases.forEach(function(item){
			reattachMethods(item, Case);
			item.nextEspece = nextEspeceBase.slice(0);
		})
		
		parsemer();
		generation = 0;
		totalRessources = listeCases.length;
		restartGraph();
		
		document.getElementById('pause').checked = false;
	};
	
	document.getElementById("board").width = longueurTableau;
	document.getElementById("board").height = hauteurTableau;
}

function main() {
	setTimeout(function onTick() {
	if (!(document.getElementById('pause').checked)){
		clear_board();
		calcul();
		updateDatabase(especePopulation, generation);
		draw();
		
		if (document.getElementById('pauseGeneration').checked && generation == document.getElementById('pauseGenerationNumber').value) {
			document.getElementById('pause').checked = true;
		}
		
		if (document.getElementById('pheroView').checked) {
			viewMode = 1;
		} else {
			viewMode = 0;
		}
		
		generation += 1;
	}
	main();
  }, 1000/FPS)
}

// Fonction qui efface le canvas
function clear_board() {
	//  Select the colour to fill the drawing
	board_ctx.fillStyle = board_background;
	//  Select the colour for the border of the canvas
	board_ctx.strokestyle = board_border;
	// Draw a "filled" rectangle to cover the entire canvas
	board_ctx.fillRect(0, 0, board.width, board.height);
	// Draw a "border" around the entire canvas
	board_ctx.strokeRect(0, 0, board.width, board.height);
}

// Fonction qui dessine les carrés et met à jour les compteur
function draw(){
	listeCases.forEach(function(item){
		if (viewMode == 0) {
			board_ctx.fillStyle = item.couleur;
		} else if (viewMode == 1) {
			board_ctx.fillStyle = "rgb(" + item.pheromone[0] + "," + item.pheromone[1] + "," + item.pheromone[2] + ")";
			console.log
		}
		board_ctx.fillRect(item.x*longueurCase, item.y*hauteurCase, longueurCase, hauteurCase);
	})
	
	document.getElementById("compteur").innerHTML = "Nombre d'individus: " + totalIndividus + "</br> Nombre de ressources: " + totalRessources;
	
	var passGraph = []
	for (let i = 0; i < especePopulation.length; i += 1){
		passGraph.push([(especePopulation[i]/totalRessources)*(graphHauteur - (graphScaleOffset*2)), especesDataCached[i][2]]);
	}
	
	if (especePopulation.length > 1){
		passGraph.push([(totalIndividus/totalRessources)*(graphHauteur - (graphScaleOffset*2)), 'pink']);
	}
	
	graphCalc(passGraph, generation);
}

// Fonction qui effectue les calculs pour la nouvelle génération
function calcul() {
	
	totalIndividus = 0;
	especePopulation = nextEspeceBase.slice(0);
	
	listeCases.forEach(function(item){
		
		// Reproduction (seulement sur case vide)
		if (item.espece == 0 && item.taken == false) {
			item.voisins.forEach(function(voisin){
				var b = getRandomInt(1, 1000)
				if (b <= listeCases[voisin].tauxReproduction) {
					item.nextEspece[listeCases[voisin].espece] += 1;
					item.taken = true;
					item.age = -1;
					item.mode = 0;
					
					if (listeCases[voisin].espece == 1) {
						if (listeCases[voisin].mode >= 20) {
							item.mode = 2;
							listeCases[voisin].mode = 0;
						}
					}
					
					if (listeCases[voisin].espece == 3) {
						if (listeCases[voisin].mode >= 10) {
							item.mode = 2;
							listeCases[voisin].mode = 0;
						}
					}
				}
			})
		}
		
		if (item.espece > 0){
			// Abeille Drone Logic
			if (item.espece == 2) {
				//Check fleur autour
				item.voisins.forEach(function(voisin){
					if (listeCases[voisin].espece == 5 && item.mode == 0) {
						item.mode = 1;
						if (listeCases[voisin].ageMax - listeCases[voisin].age > 50){
							listeCases[voisin].age += 50;
						}
					}
					if (listeCases[voisin].espece == 1 && item.mode == 1) {
						item.mode = 0;
						listeCases[voisin].mode += 1;
					}
				})
			}
			
			// Frelon Drone Logic
			if (item.espece == 4) {
				item.voisins.forEach(function(voisin){
					if (listeCases[voisin].espece == 3 && item.mode == 1) {
						item.mode = 0;
						listeCases[voisin].mode += 1;
					}
				})
			}
			
			
			
			// Movement
			var hasMoved = false;
			if (item.mvtSpeed > 0) {
				
				var b = getRandomInt(1, 100);
				if (b <= item.mvtSpeed) {
					
					var possibleNextCase = undefined;
					
					// Pheromone Logic Abeille
					if (item.espece == 2) {
						var pheroHigh = -256*2;
						item.voisins.forEach(function(voisin){
							if (listeCases[voisin].taken == false && listeCases[voisin].espece == 0) {
								var currentInvestigate = listeCases[voisin];
								var currentScore = currentInvestigate.pheromone[1] - currentInvestigate.pheromone[0];
								
								if (item.mode == 1) {
									currentScore = -currentScore;
								}
								
								if (currentScore > pheroHigh) {
									pheroHigh = currentScore;
									possibleNextCase = currentInvestigate;
								} else if (currentScore == pheroHigh) {
									b = getRandomInt(1, 100);
									if (b > 50) {
										pheroHigh = currentScore;
										possibleNextCase = currentInvestigate;
									}
								}
							}
						})
					
					// Pheromone Logic Frelon
					} else if (item.espece == 4) {
						var pheroHigh = -256*2;
						item.voisins.forEach(function(voisin){
							if (listeCases[voisin].taken == false && listeCases[voisin].espece == 0) {
								var currentInvestigate = listeCases[voisin];
								var currentScore = currentInvestigate.pheromone[3] - currentInvestigate.pheromone[2];
								
								if (item.mode == 1) {
									currentScore = -currentScore;
								}
								
								console.log(currentInvestigate.pheromone);
								
								if (currentScore > pheroHigh) {
									pheroHigh = currentScore;
									possibleNextCase = currentInvestigate;
								} else if (currentScore == pheroHigh) {
									b = getRandomInt(1, 100);
									if (b > 50) {
										pheroHigh = currentScore;
										possibleNextCase = currentInvestigate;
									}
								}
							}
						})
					
					// Sinon mvt aléatoire	
					} else {
						b = getRandomInt(0, item.voisins.length);
						var possibleNextCase = listeCases[item.voisins[b]];
						if (!(possibleNextCase.taken == false && possibleNextCase.espece == 0)) {
							possibleNextCase = undefined;
						}
					}
					
					if (possibleNextCase != undefined) {
						possibleNextCase.nextEspece[item.espece - 1] += 1;
						possibleNextCase.mode = item.mode;
						possibleNextCase.taken = true;
						hasMoved = true;
						possibleNextCase.age = item.age;
					}
				}
			}
			
			// Sauvegarde de l'espece précédente
			if (!hasMoved) {
				item.nextEspece[item.espece - 1] += 1;
			}
			
			// Prédation
			if (predationOn) {
				item.voisins.forEach(function(voisin){
					// Cannibalisme = NON enfait si :)
					if (listeCases[voisin].espece > 0 && especesDataCached[listeCases[voisin].espece - 1][4][item.espece - 1] && listeCases[voisin].mode == 0) {
						var b = getRandomInt(1, 100)
						if (b <= listeCases[voisin].tauxPredation) {
							item.nextEspece[6] += predationPower;
							listeCases[voisin].mode = 1;
							item.age = -1;
						}
					}
				})
			}
			
			if (ageMaxOn) {
				// Viellissement
				item.age += 1;
				
				// Mort de Viellesse Ou Maturation des Graines
				if (item.age == item.ageMax && item.espece == 6) {
					item.nextEspece[4] += 5;
					item.age = 0;
				} else if (item.age == item.ageMax && item.espece == 2 && item.mode == 2) {
					item.nextEspece[0] += 5;
					item.age = 0;
					item.mode = 0;
				} else if (item.age == item.ageMax && item.espece == 4 && item.mode == 2) {
					item.nextEspece[2] += 5;
					item.age = 0;
					item.mode = 0;
				} else if (item.age == item.ageMax){
					item.nextEspece = [0,0];
				}
			}
			
			// Spreading Pheromones
			if (item.espece == 2 || item.espece == 4) {
				item.pheromone[item.mode + item.espece - 2] += parseInt((item.ageMax/(item.age + 1))*20);
				if (item.pheromone[item.mode + item.espece - 2] > 255) {
					item.pheromone[item.mode + item.espece - 2] = 255;
				}
			}
				
		
			// Comptage Individus
			totalIndividus += 1;
			especePopulation[item.espece-1] += 1
		}
		
		// Pheromones Decay
		for (var i = 0; i < item.pheromone.length; i += 1) {
			if (item.pheromone[i] > 0) {
				item.pheromone[i] -= 1;
			}
		}
	})
	
	// Pour invasion
	if (generation % generationInvasion == 0 && invasionIndex < 5 && generation > 0) {
		
		if (listeCases.length > 0) {
			for (var i = 0; i < invasionPower; i++){
				var idx = getRandomInt(0, listeCases.length - 1);

				listeCases[idx].nextEspece[invasionIndex] += 100;		
			}
			
			invasionIndex += 2;
		}
	}
		
	// Changement des cases
	listeCases.forEach(function(item){
		var nextEspeceIdx = calculNextEspece(item.nextEspece);
		
		// if (item.espece != nextEspeceIdx + 1){
			// item.age = 0;
		// }
		
		item.setupEspece(nextEspeceIdx + 1, especesDataCached);
		
		item.nextEspece = nextEspeceBase.slice(0);
	})
}

// Fonction qui check nextEspece
function calculNextEspece(arr) {
    var max = arr[0];
    var maxIndex = 0;
	
	var compteur = 0
    for (var i = 1; i < arr.length; i++) {
		
		if (arr[i] == max) {
			maxIndex = -1;
		}
	
        if (arr[i] > max) {
            maxIndex = i;
            max = arr[i];
			compteur = 0;
        }
		
    }
	
	if (max == 0) {
		maxIndex = -1;
	}

    return maxIndex;
}


// Fonction qui permet de générer des entiers aléatoires
function getRandomInt(min, max) {
	min = Math.ceil(min);
	max = Math.floor(max);
	return Math.floor(Math.random() * (max - min)) + min;
}

// Fonction qui reattache les fonctions des objets sérialisés
function reattachMethods(serialized,originalclass) {
	serialized.__proto__ = originalclass.prototype; 
}

// Fonction qui ajoute une espèce
function ajouterEspece() {
	var matricePredation = [false]
	
	for (idx = 0; idx < especesData.length; idx++) {
		especesData[idx][4].push(false)
		matricePredation.push(false)
	}
	
	especesData.push([10, 30, '#3b6584', 5, matricePredation]);
	console.log(especesData)
	afficheEspece();
}

// Fonction qui supprime une espèce
function supprimerEspece() {
	especesData.pop();
	afficheEspece();
}

// Fonction qui affiche les especes differentes
function getRatiosRight() {
	if (home) {
		
		longueurTableau = parseInt(document.getElementById("longueurTableau").value);
		hauteurTableau = parseInt(document.getElementById("hauteurTableau").value);
		
		longueurCase = parseInt(document.getElementById("longueurCase").value);
		hauteurCase = parseInt(document.getElementById("hauteurCase").value);
		
	}
	
	var modifier = longueurTableau/longueurCase
	
	while (longueurTableau > screen.width - 175) {
		longueurTableau = longueurTableau - modifier;
		hauteurTableau = hauteurTableau - modifier;
		
		longueurCase = longueurTableau/modifier;
		hauteurCase = hauteurTableau/modifier;
		
		if (home) {
			document.getElementById("longueurTableau").value = longueurTableau;
			document.getElementById("hauteurTableau").value = hauteurTableau
			
			document.getElementById("longueurCase").value = longueurCase
			document.getElementById("hauteurCase").value = hauteurCase
		}
		
	}
}


  window.onbeforeunload = function() {};

  window.onbeforeunload = null;