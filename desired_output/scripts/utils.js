// Fonction qui reattache les fonctions des objets sérialisés
function reattachMethods(serialized, originalclass) {
	serialized.__proto__ = originalclass.prototype; 
}

function getRandomInt(min, max) {
	min = Math.ceil(min);
	max = Math.floor(max);
	return Math.floor(Math.random() * (max - min)) + min;
}