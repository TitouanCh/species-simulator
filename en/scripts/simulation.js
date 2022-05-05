const board_border = 'black';
const board_background = "white";

var home;
var firstRun = true;

var longueurTableau = 500;
var hauteurTableau = 500;

var longueurCase = 10;
var hauteurCase = 10;

var FPS = 50;

var nombreIndividus;
var totalRessources = 2500;
var predationPower = 2;

var simulationType = 1; // 1: regular; 2: barebones

var parsemageType = 1; // 1: regular; 2: 2 species corner; 3: 2 species invasion;

var generationInvasion = 1000;
var invasionIndex = 0
var invasionPower = 30

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
var especesData = [ [10, 30, '#7c9ac2', 5, [false, false]], [10, 20, '#293e58', 5, [false, false]] ];
var especePopulation = []
var especesDataCached = especesData.slice();
var nextEspeceBase = []
var generation = 0



// Parseme aléatoirement quelques animaux d'espèces différentes
function parsemer() {
	if (parsemageType == 1) {
		listeCases.forEach(function(item){
			var espece = getRandomInt(0,probaParsemage);
			if (espece <= especesData.length){
				item.setupEspece(espece, especesDataCached);
			}
		})
	}
	
	if (parsemageType == 2 || parsemageType == 4) {
		listeCases[0].setupEspece(1, especesDataCached);
		listeCases[listeCases.length - 1].setupEspece(2, especesDataCached);
		
		if (parsemageType == 4){
			invasionIndex += 2;
		}
	}
}

// Fonction qui démarre/redémarre la simulation
function restart(){
	listeCases = [];
	initDatabase();
	nextEspeceBase = [];
	invasionIndex = 0;
	
	if (simulationType == 1){
		predationOn = true;
		ageMaxOn = true;
	}
	if (simulationType == 2){
		predationOn = false;
		ageMaxOn = false;
	}
	
	if (firstRun) {
		
		getRatiosRight();
		
		firstRun = false;
	}
	
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
						var b = getRandomInt(1, 100)
						if (b <= listeCases[voisin].tauxPredation) {
							item.nextEspece[listeCases[voisin].espece - 1] += predationPower;
						}
					}
				})
			}
			
			if (ageMaxOn) {
				// Viellissement
				item.age += 1;
				
				// Mort de Viellesse
				if (item.age == item.ageMax){
					item.nextEspece = [0,0];
				}
			}
		
			// Comptage Individus
			totalIndividus += 1;
			especePopulation[item.espece-1] += 1
		}
		
		
	})
	
	// Pour invasion
	if (generation % generationInvasion == 0 && (parsemageType == 3 || (parsemageType == 4 && generation != 0)) && invasionIndex < especesDataCached.length) {
		if (listeCases.length > 0) {
			for (var i = 0; i < invasionPower; i++){
				var idx = getRandomInt(0, listeCases.length - 1);

				listeCases[idx].nextEspece[invasionIndex] += 100;		
			}
			
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
		document.getElementById("gestionEspeces").innerHTML += '<label class ="hiddenLabel" for="couleurEspece' + idx + '">Sélectionner la couleur de l\'espèce ' + idx + '.</label>';
		
		document.getElementById("gestionEspeces").innerHTML += '</br> --- Taux de reproduction: ' + '<input type="number" min="1" max="100" value="' + espece[0] + '" id="tauxReproductionEspece' + idx + '">';
		document.getElementById("gestionEspeces").innerHTML += '<label class ="hiddenLabel" for="tauxReproductionEspece' + idx + '">Choisir un taux de reproduction pour l\'espèce ' + idx + '.</label>';
		
		document.getElementById("gestionEspeces").innerHTML += '</br> --- Taux de prédation: ' + '<input type="number" min="1" max="100" value="' + espece[3] + '" id="tauxPredationEspece' + idx + '">';
		document.getElementById("gestionEspeces").innerHTML += '<label class ="hiddenLabel" for="tauxPredationEspece' + idx + '">Choisir un taux de prédation pour l\'espèce ' + idx + '.</label>';
		
		document.getElementById("gestionEspeces").innerHTML += '</br> --- Régime: '
		
		var idx2 = 1
		especesData.forEach(function(espece) {
			document.getElementById("gestionEspeces").innerHTML += '<label for="regimeEspece' + idx + 'for' + idx2 + '" style ="visibility: visible; display: inline;">Espèce ' + idx2 + ' </label><input id="regimeEspece' + idx + 'for' + idx2 + '" type="checkbox"/>'
			if (idx2 != especesData.length){
				document.getElementById("gestionEspeces").innerHTML += ', '
			}
			
			document.getElementById("gestionEspeces").innerHTML += '';
			
			idx2 += 1
		})
		
		document.getElementById("gestionEspeces").innerHTML += '</br> --- Esperance de vie: ' + '<input type="number" min="1" max="500" value="' + espece[1] + '" id="ageMaxEspece' + idx + '">';
		document.getElementById("gestionEspeces").innerHTML += '<label class ="hiddenLabel" for="ageMaxEspece' + idx + '">Choisir l\' âge maximal pour l\'espèce ' + idx + '.</label>';
		document.getElementById("gestionEspeces").innerHTML += '</br>'
		
		idx += 1;
	}
	
	)
}

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