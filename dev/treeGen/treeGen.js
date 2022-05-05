
var possibleBranchNames = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K']
var possibleTreeNames = ['E', 'F']

function bizzaro(a) {
	return randomFloat()/4 + 0.1;
}

function uniform(a) {
	return a;
}

function poisson(lambda) {
	return Math.log(1 - randomFloat())/ -lambda
}

function generateTree(ntips, speciationLaw, exctinctionLaw, lambda = 2, mu = 1) {
	
	// N: total number of species
    var N = 1; 
	
	
	var raw_tree = [[], [pickRandomList(possibleBranchNames), speciationLaw(lambda)]];
	
	while (N != ntips) {
		
		//console.log(N, JSON.stringify(raw_tree));
		var lowest_tip = getLowestTip(raw_tree)[0];
		
		for (let u = 0; u < 2; u++) {
			var v = createBranch(speciationLaw, exctinctionLaw, lambda, mu);
			
			if (v[0] == 0) {
				lowest_tip.push([]);
				lowest_tip.push(v[1]);
				N += 0.5;
			}
			
			if (v[0] == 1) {
				lowest_tip.push(v[1]);
				N -= 0.5;
			}
			
		}

		N = Math.floor(N);
		
		if (N == 0 || N > ntips) {
			raw_tree = [[], [pickRandomList(possibleBranchNames), speciationLaw(lambda)]];
			N = 1;
			//console.log("reset", [...raw_tree]);
		}
		
		
	}
	
	//console.log([...raw_tree]);
	
	var max_width = getHighTree(raw_tree) + 0.5;
	//console.log(max_width + 10);
	// = getLowestTip(raw_tree)[1];
	closeTree(raw_tree, max_width);
	
	generateFossilData(ntips, raw_tree, uniform, poisson);
	
	normalizeWidthTree(raw_tree, max_width * 1.05);
	
	//console.log(raw_tree);
	
	return raw_tree;
}

function generateFossilData(ntips, raw_tree, samplingLaw, recoveryLaw, rho =  0.6, psi = 0.05) {
	var sampling = [];
	
	for (let i = 0; i < ntips; i++) {
		sampling.push(samplingLaw(rho) >= randomFloat());
	}
	
	raw_tree = generateRecovery(raw_tree, recoveryLaw, psi);
	
	return [raw_tree, sampling];
}

function generateRecovery(branch, recoveryLaw, psi) {
	for (let i = 0; i < branch.length; i++) {
		if (Array.isArray(branch[i][0])) {
			generateRecovery(branch[i], recoveryLaw, psi);
		} else {
			var fossilData = [];
			var delta = 0;
			
			while (delta < branch[i][1]) {
				var a = recoveryLaw(psi);
				delta += a;
				if (delta < branch[i][1]) {
					fossilData.push(delta);
				}
			}
			
			branch[i].push(fossilData);
		}
	}
}

function createBranch(speciationLaw, exctinctionLaw, lambda, mu) {
	var speciation = speciationLaw(lambda);
	var exctinction = exctinctionLaw(mu);
	var l = 0.1;
	var m = -1;
	
	if (speciation <= exctinction) {
		l = speciation;
		m = 0;
	} else {
		l = exctinction;
		m = 1;
	}
	
	return [m, [pickRandomList(possibleBranchNames), l]];
}

function exploreTree(branch, explored = [], distance = 0) {
	for (let i = 0; i < branch.length; i++) {
		if (branch[i].length == 0) {
			explored.push([branch[i], distance + branch[i + 1][1]]);
		}
		
		else if (Array.isArray(branch[i][0])) {
			explored = exploreTree(branch[i], explored, distance + branch[i + 1][1]);
		}
	}
	
	return explored;
}

function getLowestTip(tree) {
	var a = exploreTree(tree);
	var prevLowest = 9999;
	var prevLowestIdx = 0;
	
	for (let i = 0; i < a.length; i++) {
		if (prevLowest > a[i][1]) {
			prevLowest = a[i][1];
			prevLowestIdx = i;
		}
	}
	
	return a[prevLowestIdx];
}

function getHighTree(branch, high = 0, distance = 0) {
	for (let i = 0; i < branch.length; i++) {
		if (Array.isArray(branch[i][0])) {
			high = getHighTree(branch[i], high, distance + branch[i + 1][1]);
		}
		else {
			if (high < branch[i][1] + distance) {
				high = branch[i][1] + distance;
			}
		}
	}
	
	return high;
}

function closeTree(branch, maxDistance, distance = 0) {
	for (let i = 0; i < branch.length; i++) {
		if (branch[i].length == 0) {
			branch[i + 1][1] = maxDistance - distance;
			branch.splice(i, 1);
		}
		
		else if (Array.isArray(branch[i][0])) {
			closeTree(branch[i], maxDistance, distance + branch[i + 1][1]);
		}
	}
}

function normalizeWidthTree(branch, maxDistance) {
	for (let i = 0; i < branch.length; i++) {
		if (Array.isArray(branch[i][0])) {
			normalizeWidthTree(branch[i], maxDistance);
		} else {
			branch[i][1] = branch[i][1]/maxDistance;
			
			// FOSSIL
			if (branch[i].length == 3) {
				for (let a = 0; a < branch[i][2].length; a++) {
					branch[i][2][a] = branch[i][2][a]/maxDistance;
				}	
			}
		}
	}
}

function pickRandomList(list) {
	return list[getRandomInt(0, list.length - 1)];
}

function randomFloat() {
	return Math.random();
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}