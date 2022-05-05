const board_border = 'black';
const board_background = "white";

var home;

var longueurTableau = 500;
var hauteurTableau = 500;

var longueurCase = 10;
var hauteurCase = 10;

var FPS = 50;

var nombreIndividus;
var totalRessources = 2500;
var predationPower = 2;

var generationInvasion = 500;
var invasionIndex = 0
var invasionPower = 3

var predationOn = true;
var ageMaxOn = true;

// Get the canvas element
const board = document.getElementById("board");
// Return a two dimensional drawing context
const board_ctx = board.getContext("2d");

var workerPath = "scripts/setupworker.js";

var listeCases = [];
var probaParsemage = 1000;

// Données des espèces, format: [tauxReproduction, ageMax, couleur, tauxPredation, [régime]]
var especesData = [ [0, null, '#7c9992', 0, [false, false, false, false]], [0, null, '#293e58', 0, [false, false, false, false]], [0, 1000, '#7190a2', 5, [true, true, false, false]], [0, null, '#99aeea', 0, [false, false, false, false]], [0, 5, '#aeaeaa', 70, [true, true, false, false, false]] ];
// Espece 1: Land/Human
// Espece 2: Ocean
// Espece 3: Covid
// Espece 4: DEAD
// Espece 5: WaterBorn

var especePopulation = []
var especesDataCached = especesData.slice();
var nextEspeceBase = []
var generation = 0


var mapOfTheWorld = [
"1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111",
"1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111",
"1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111",
"1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111",
"1111111111111111111111111100000111100000011111111111111111111111111111111111111111111111111111111111",
"1111111111111111111111100000001000000000001101111111111111111111111111111111111111111111111111111111",
"1111111111111111111100000000010000000000000111111111110011111111111111111111111111111111111111111111",
"1111111111111111101000100001000000000000000111111111101111111111111111111111011111111111111111111111",
"1111111111111110111110110011100000000000000111111111111111111111111111111111001111111111111111111111",
"1111111111111111000001100011111100000000001111111111111111111111011111111000000111111111111111111111",
"1111111111111100111101000011111110000000011111111111111111111110111111100000000001111110111111111111",
"1111111111111100000111100000111110000000001111111111111111111110111111000000000000001111001111111111",
"1110000001111111000010011110001110000000001111111111100011111111111010000000000000000000000001111111",
"1100000000000000110000000111001110000001111111111111000000011100000000000000000000000000000000000001",
"1100000000000000000000000111000110000011111011111111000000110000000000000000000000000000000000000000",
"1111000000000000000000000011001111000111110011111110001000100000000000000000000000000000000000000011",
"1100000000000000000000011110111111101111111111111100010000000000000000000000000000000000000011001111",
"1110001111000000000000111110011111111111111111111100011000000000000000000000000000000000000110111111",
"1111001111100000000000001110000111111111111111101111010000000000000000000000000000000001111101111111",
"1111111111110000000000000100000011111111111111001110110000000000000000000000000000000011111001111111",
"1111111111111000000000000000000001111111111110100100000000000000000000000000000000000001111011111111",
"1111111111111000000000000000001101111111111111110000000000000000000000000000000000000001111111111111",
"1111111111111100000000011000001110111111111111100000000000000000000000000000000000000001110111111111",
"1111111111111100000000000100011111111111111111110000000011100110000000000000000000000011111111111111",
"1111111111111100000000000000111111111111111111000111010010110010000000000000000000001111111111111111",
"1111111111111100000000000001111111111111111111001111111100000011000000000000000000101111111111111111",
"1111111111111110000000000001111111111111111111110001111111000000000000000000000000101101111111111111",
"1111111111111111000000000011111111111111111111000000111111000000000000000000000001110111111111111111",
"1111111111111111000000110011111111111111111110000000000000000100000000000000000001111111111111111111",
"1111111111111111110001111001111111111111111110000000000000000011000000000000000001111111111111111111",
"1111111111111111111000111110111111111111111100000000000000100000000000000000000011111111111111111111",
"1111111111111111111000001111111111111111111100000000000000010000111000000100000111111111111111111111",
"1111111111111111111100001111111111111111111100000000000000010001111100001110000111111111111111111111",
"1111111111111111111111100111111111111111111100000000000000000111111100001111000111011111111111111111",
"1111111111111111111111110010000111111111111110000000000000000011111100011111101111011111111111111111",
"1111111111111111111111111100000001111111111111000000000000000011111110111111111111111111111111111111",
"1111111111111111111111111100000000111111111111111110000000000111111111111110111101111111111111111111",
"1111111111111111111111111100000000000111111111111110000000001111111111111111011001110111111111111111",
"1111111111111111111111111100000000000001111111111110000000011111111111111111011100111001110111111111",
"1111111111111111111111111100000000000000111111111111000000011111111111111111111111111110111111111111",
"1111111111111111111111111110000000000001111111111111000000011111111111111111111111111111101111111111",
"1111111111111111111111111110000000000011111111111111000000011111111111111111111111110011111111111111",
"1111111111111111111111111111000000000011111111111111000000011011111111111111111111000000011111111111",
"1111111111111111111111111111100000000011111111111111000000111011111111111111111110000000001111111111",
"1111111111111111111111111111100000000111111111111111000000110111111111111111111100000000001111111111",
"1111111111111111111111111111100000001111111111111111000001111111111111111111111100000000000111111111",
"1111111111111111111111111111000000011111111111111111100001111111111111111111111100000000000111111111",
"1111111111111111111111111111000001111111111111111111110011111111111111111111111100011000000111111111",
"1111111111111111111111111111000011111111111111111111111111111111111111111111111111111100001111110111",
"1111111111111111111111111111000111111111111111111111111111111111111111111111111111111111111111111011",
"1111111111111111111111111111001111111111111111111111111111111111111111111111111111111111011111111111",
"1111111111111111111111111111001111111111111111111111111111111111111111111111111111111111111111101111",
"1111111111111111111111111111001111111111111111111111111111111111111111111111111111111111111111111111",
"1111111111111111111111111111001111111111111111111111111111111111111111111111111111111111111111111111",
"1111111111111111111111111111011111111111111111111111111111111111111111111111111111111111111111111111",
"1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111",
"1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111",
"1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111",
"1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111",
"1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111"
]





// Parseme aléatoirement quelques animaux d'espèces différentes
function parsemer() {	
	listeCases.forEach(function(item){
		if (mapOfTheWorld[item.y][item.x] == "0") {
			item.setupEspece(1, especesDataCached);
		} else {
			item.setupEspece(2, especesDataCached);
		}
	}
	);
}

// Fonction qui démarre/redémarre la simulation
function restart(){
	listeCases = [];
	initDatabase();
	nextEspeceBase = [];
	invasionIndex = 0;
	
	
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
		console.log(especesData)
		
		
	} else {
		especesData.forEach(function(espece) {
			nextEspeceBase.push(0);
		})
	}
	
	especesDataCached = especesData.slice();
	
	setupWorker = new Worker(workerPath);
	setupWorker.postMessage([longueurTableau, hauteurTableau, longueurCase, hauteurCase]);
	
	setupWorker.onmessage = function(event){

		setupWorker.terminate();
		setupWorker = undefined;
		
		listeCases = event.data
		
		listeCases.forEach(function(item){
			reattachMethods(item, Case);
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
		board_ctx.fillStyle = item.couleur;
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
	
		item.nextEspece = nextEspeceBase.slice(0);
		
		// Reproduction (seulement sur case vide)
		if (item.espece == 0) {
			item.voisins.forEach(function(voisin){
				var b = getRandomInt(1, 100)
				if (b <= listeCases[voisin].tauxReproduction) {
					item.nextEspece[listeCases[voisin].espece - 1] += 1;
				}
			})
		}
		
		if (item.espece > 0){
			
			// Sauvegarde de l'espece précédente
			item.nextEspece[item.espece - 1] += 1;
			
			// Prédation
			if (predationOn) {
				item.voisins.forEach(function(voisin){
					// Cannibalisme = NON enfait si :)
					if (listeCases[voisin].espece > 0 && especesDataCached[listeCases[voisin].espece - 1][4][item.espece - 1]) {
						var b = getRandomInt(1, 1000)
						if (b <= listeCases[voisin].tauxPredation) {
							item.nextEspece[listeCases[voisin].espece - 1] += predationPower;
						
							
							
							if (item.espece == 1 && listeCases[voisin].espece == 5) {
								item.nextEspece[2] += predationPower * 2
							}
						}
						
						if (item.espece == 2 && listeCases[voisin].espece == 3 && b < 500) { 
							item.nextEspece[4] += predationPower * 2
						}
					}
				})
			}
			
			if (ageMaxOn) {
				// Viellissement
				item.age += 1;
				
				// Mort de Viellesse
				if (item.age == item.ageMax){
					if (item.espece == 3) {
						item.nextEspece[3] += 100;
					}
					
					if (item.espece == 5) {
						item.nextEspece[1] += 100;
					}
				}
			}
		
			// Comptage Individus
			totalIndividus += 1;
			especePopulation[item.espece-1] += 1
		}
		
		
	})
	
	// Pour invasion
	if (generation % generationInvasion == 0 && invasionIndex < especesDataCached.length) {
		if (listeCases.length > 0) {
			
			listeCases[listeCases.length - 998].nextEspece[2] += 100;		
			
			
			invasionIndex += 1;
		}
	}
		
	// Changement des cases
	listeCases.forEach(function(item){
		var nextEspeceIdx = calculNextEspece(item.nextEspece);
		
		if (item.espece != nextEspeceIdx + 1){
			item.age = 0;
		}
		
		item.setupEspece(nextEspeceIdx + 1, especesDataCached);
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
function afficheEspece() {
	document.getElementById("gestionEspeces").innerHTML = ""
	var idx = 1
	especesData.forEach(function(espece) {
		document.getElementById("gestionEspeces").innerHTML += '</br>'
		document.getElementById("gestionEspeces").innerHTML += 'Espèce ' + idx + ':';
		document.getElementById("gestionEspeces").innerHTML += '</br> --- Couleur: ' + '<input type="color" value="' + espece[2] + '" id="couleurEspece' + idx + '">';
		document.getElementById("gestionEspeces").innerHTML += '</br> --- Taux de reproduction: ' + '<input type="number" min="1" max="100" value="' + espece[0] + '" id="tauxReproductionEspece' + idx + '">';
		document.getElementById("gestionEspeces").innerHTML += '</br> --- Taux de prédation: ' + '<input type="number" min="1" max="100" value="' + espece[3] + '" id="tauxPredationEspece' + idx + '">';
		document.getElementById("gestionEspeces").innerHTML += '</br> --- Régime: '
		
		var idx2 = 1
		especesData.forEach(function(espece) {
			document.getElementById("gestionEspeces").innerHTML += 'Espèce ' + idx2 + '<input id="regimeEspece' + idx + 'for' + idx2 + '" type="checkbox"/>'
			if (idx2 != especesData.length){
				document.getElementById("gestionEspeces").innerHTML += ', '
			}
			
			idx2 += 1
		})
		
		document.getElementById("gestionEspeces").innerHTML += '</br> --- Esperance de vie: ' + '<input type="number" min="1" max="500" value="' + espece[1] + '" id="ageMaxEspece' + idx + '">';
		document.getElementById("gestionEspeces").innerHTML += '</br>'
		idx += 1;
	}
	
	)
}