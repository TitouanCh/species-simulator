// Fonction qui reattache les fonctions des objets sérialisés
function reattachMethods(serialized, originalclass) {
	serialized.__proto__ = originalclass.prototype; 
}

function getRandomInt(min, max) {
	min = Math.ceil(min);
	max = Math.floor(max);
	return Math.floor(Math.random() * (max - min)) + min;
}

function Timer(){
	var start = new Date
		,ended = 'running ...';
	return {
		start: function(){
				start = new Date; 
				return this
		},
		stop:  function(mssg) {
				var stoppedAt = (new Date - start);
			 ended = [(mssg ? mssg+': ' : '')
							 ,(stoppedAt/1000)+' sec (+/- 15ms)'].join('')
				return ended;
		}
		,toString: function(){
				  return ended;
		}
	};
	/*
	  //usage:
	  var timenow = new Timer().start();
	  // run a function
	  console.log(timenow.stop('this took '));
	*/
}