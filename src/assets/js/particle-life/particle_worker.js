// in => 0 worker_id, 1: data, 2: partitions, 3: which partitions to process
// in++ => 4: force_book, 5: mass_book, 6: resolutionX, 7: resolutionY, 8: g, 9: drag, 10: max_distance_force, 11: norme, 12: force_function, 13: delta, 14: space_partitioning 
// out => processed individuals

self.importScripts('particle_point.js');

onmessage = function(event) {
    var input = event.data;

    var worker_id = input[0]
	var data = input[1];
    var partitions = input[2];
    var which = input[3];

    var processed = []

    // --
    force_book = input[4];
    mass_book = input[5];
    resolutionX = input[6];
    resolutionY = input[7];
    g = input[8];
    drag = input[9];
    max_distance_force = input[10];
    norme = input[11];
    force_function = input[12];
    delta = input[13];
    space_partitioning = input[14];
    // --

    for (let k = 0; k < which.length; k++) {
        list_idx = partitions[which[k][0]][which[k][1]];

        var useful_data = list_idx.map(i => data[i])

        for (let i = 0; i < useful_data.length; i++) {
            processed.push(
                process_point(useful_data[i], i, useful_data, force_book, mass_book, resolutionX, resolutionY,
                    g, drag, max_distance_force, norme, force_function, delta, false, partitions) 
            );
        }
    }
	
	postMessage([worker_id, processed]);
};