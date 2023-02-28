function process_point(point, idx, data, force_book, mass_book, resolutionX, resolutionY, g, drag, max_distance_force, norme, force_function, delta, space_partitioning, partitions) {
    var point = point;
    
    var forceX = 0;
    var forceY = 0;
    
    // Calculate force other on self
    // No space partitioning --
    if (!space_partitioning) {
        for (var j = 0; j < data.length; j++) {
            if (j != idx) {
                force_on_me = force_output(data[j], point, g, max_distance_force, force_book, norme, force_function);
                forceX += force_on_me[0];
                forceY += force_on_me[1];
            }
        }
    // With space partitioning --
    } else {
        list = partitions[point[8]][point[7]];

        // up
        if (point[8] > 0) { list = list.concat(partitions[point[8] - 1][point[7]]); }
        // down
        if (point[8] < partitions.length - 1) { list = list.concat(partitions[point[8] + 1][point[7]]); }
        // left
        if (point[7] > 0) { list = list.concat(partitions[point[8]][point[7] - 1]); }
        // right
        if (point[7] < partitions[0].length - 1) { list = list.concat(partitions[point[8]][point[7] + 1]); }

        // up-left
        if (point[8] > 0 && point[7] > 0) { list = list.concat(partitions[point[8] - 1][point[7] - 1]); }
        // up-right
        if (point[8] > 0 && point[7] < partitions[0].length - 1) { list = list.concat(partitions[point[8] - 1][point[7] + 1]); }
        // down-left
        if (point[8] < partitions.length - 1 && point[7] > 0) { list = list.concat(partitions[point[8] + 1][point[7] - 1]); }
        // down-right
        if (point[8] < partitions.length - 1 && point[7] < partitions[0].length - 1) { list = list.concat(partitions[point[8] + 1][point[7] + 1]); }

        for (var j = 0; j < list.length; j++) {
            if (j != idx) {
                force_on_me = force_output(data[list[j]], point, g, max_distance_force, force_book, norme, force_function);
                forceX += force_on_me[0];
                forceY += force_on_me[1];
            }
        }
    }
    
    var accelX = forceX;
    var accelY = forceY;
    
    point[3] += accelX * delta; //vx
    point[4] += accelY * delta; //vy
    
    point[3] *= drag;
    point[4] *= drag;
    
    point[5] = point[1] + (point[3] * delta); //nx
    point[6] = point[2] + (point[4] * delta); //ny
    
    // Borders --
    if (point[5] < 0) {
        point[5] = 0;
        point[3] = -point[3];
    }
    if (point[5] > resolutionX) {
        point[5] = resolutionX - 1;
        point[3] = -point[3];
    }
    if (point[6] < 0) {
        point[6] = 0;
        point[4] = -point[4];
    }
    if (point[6] > resolutionY) {
        point[6] = resolutionY - 1;
        point[4] = -point[4];
    }
    
    return point;
}

function force_output(emitter, receiver, g, max_distance_force, force_book, norme, force_function) {
	var distance = self[norme](emitter[1], emitter[2], receiver[1], receiver[2]);

	if (distance > 0.0 && distance < max_distance_force) {
		var normalizedVectorX = (receiver[1] - emitter[1]) / distance;
		var normalizedVectorY = (receiver[2] - emitter[2]) / distance;
		
		var fG = self[force_function](distance, force_book[emitter[0]][receiver[0]], g, 20.0)

		return [fG * normalizedVectorX, fG * normalizedVectorY];
	}

	return [0, 0];
}

function norme2(x1, y1, x2, y2) {
	return Math.sqrt(Math.pow(x1 - x2, 2) + Math.pow(y1 - y2, 2));
}

function norme1(x1, y1, x2, y2) {
	return Math.abs(x1 - x2, 2) + Math.abs(y1 - y2, 2);
}

function exponential(x1, y1, x2, y2) {
    if (Math.sqrt(Math.pow(x1 - x2, 2) + Math.pow(y1 - y2, 2)) < 40) {
        return 16;
    }
    else {
        return 400
    }
}

function max(x1, y1, x2, y2) {
    return Math.max(Math.abs(x1 - x2), Math.abs(y1 - y2));
}

function basic_force_function(distance, mass, g, radius) {
	force = 0;

	if (distance < radius + 10.0) {
		force = Math.pow(distance - 30, 2);
	}
	else if (distance > 250) {
		force = -(distance - 400)/10;
		force *= -1 * g * mass;
	}
	else if (distance > 100) {
		fG = (distance - 100)/10;
		fG *= -1 * g * mass;
	}

	return force;
}