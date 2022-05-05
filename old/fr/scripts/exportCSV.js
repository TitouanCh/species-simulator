var exportTable = [];

function initDatabase(){
	exportTable = [];
}

function updateDatabase(popu, generation){
	if (generation == 0){
		initDatabase();
	}
	
	var nextLine = [generation]
	
	popu.forEach(function(item){
		nextLine.push(item);
	});
	
	exportTable.push(nextLine);
}

function downloadCSV(especesData){
	download(formatData(exportTable, especesData), "table.csv");
}

function formatData(data, especesData){
	var megaString = 'Generation'
	
	for (var i = 1; i <= especesData.length; i += 1) {
		megaString += ',Espece' + i;
	}
	
	data.forEach(function(i) {
		megaString += '\n';
		
		var notFirst = false;
		i.forEach(function(j) {
			if (notFirst){
				megaString += ', ';
			}
			
			megaString += j;
			notFirst = true
		});
		
	});
	
	return megaString;
}

function download(data, filename) {
	var blob = new Blob([data], {type: 'text/csv'});
	
	if (window.navigator.msSaveOrOpenBlob){
		window.navigator.msSaveBlob(blob, filename);
	}
	else {
		var elem = window.document.createElement('a');
		elem.href = window.URL.createObjectURL(blob);
		elem.download = filename;
		document.body.appendChild(elem);
		elem.click();
		document.body.removeChild(elem);
	}
	
}