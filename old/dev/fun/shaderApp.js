var then = 0;

function main(){
	console.log("Initializing WebGL ---");
	
	var canvas = document.getElementById("gl");
	var gl = canvas.getContext('webgl');
	
	if (!gl) {
		gl = canvas.getContext('experimental-webgl');
	}
	
	if (!gl) {
		console.log("no webgl for you :(")
		return
	}
	
	var vertexShader = createShader(gl, gl.VERTEX_SHADER, document.getElementById("vertex-shader-2d").text);
	var fragmentShader = createShader(gl, gl.FRAGMENT_SHADER, document.getElementById("fragment-shader-2d").text);
	
	var program = createProgram(gl, vertexShader, fragmentShader);
	
	console.log("DONE! Compiling Success ---")
	
	// ATTRIBUTE - LOCATION:
	// ie: var exampleLocation = gl.getAttribLocation(program, "a_example");
	var coordLocation = gl.getAttribLocation(program, "a_coord");
	
	// UNIFORM - LOCATION:
	// ie: var exampleLocation = gl.getUniformLocation(program, "u_example");
	var resolutionLocation = gl.getUniformLocation(program, "u_resolution");
	var sizeLocation = gl.getUniformLocation(program, "u_size");
	
	// CREATE BUFFER FOR DATA:
	// ie: var exampleBuffer = gl.createBuffer();
	//	   gl.bindBuffer(gl.ARRAY_BUFFER, exampleBuffer);
	//	   var exampleData = new Float32Array([ ... ]);
	// 	   gl.bufferData(gl.ARRAY_BUFFER, exampleData, gl.STATIC_DRAW);
	var coordBuffer = gl.createBuffer();
	gl.bindBuffer(gl.ARRAY_BUFFER, coordBuffer);
	const coordData = new Float32Array(getAllCoord(gl, 5.0));
	gl.bufferData(gl.ARRAY_BUFFER, coordData, gl.STATIC_DRAW);

	// END OF SETUP
	console.log("Setup completed ---")
	
	requestAnimationFrame(draw);
	
	// CALLED EVERY FRAME
	function draw(now) {
		
		sizeCanvas(gl);
		
		clearCanvas(gl);

		gl.useProgram(program);

		// USE ATTRIBUTE:
		// ie: gl.enableVertexAttribArray(exampleLocation);
		//	   gl.bindBuffer(gl.ARRAY_BUFFER, exampleBuffer);
		// 	   var size = number of components per iteration;
		//     var type = gl.FLOAT, 32 bit floats;
		//     var normalize = false;
		//	   var stride = 0, move forward size * sizeof(type) each iteration to get the next position;
		//	   var offset = 0 where to start in buffer;
		// 	   vertexAttribPointer(exampleLocation, size, type, normalize, stride, offset);
		
		gl.enableVertexAttribArray(coordLocation);
		gl.bindBuffer(gl.ARRAY_BUFFER, coordBuffer);
		var size = 2;          
		var type = gl.FLOAT;   
		var normalize = false; 
		var stride = 0;        
		var offset = 0;        
		gl.vertexAttribPointer(coordLocation, size, type, normalize, stride, offset);
		
		// USE UNIFORM:
		// ie: gl.uniformTYPE(exampleLocation, DATA):
		gl.uniform2f(resolutionLocation, gl.canvas.width, gl.canvas.height);
		gl.uniform1f(sizeLocation, 5.0);

		// Draw the geometry.
		const geomOffset = 0;
		gl.drawArrays(gl.POINTS, geomOffset, gl.canvas.height * gl.canvas.width);
	}
}

function createShader(gl, type, source) {
	var shader = gl.createShader(type);
	gl.shaderSource(shader, source);
	gl.compileShader(shader);
	var success = gl.getShaderParameter(shader, gl.COMPILE_STATUS);
	if (success) {
	return shader;
	}

	console.log(gl.getShaderInfoLog(shader));
	gl.deleteShader(shader);
}

function createProgram(gl, vertexShader, fragmentShader) {
  var program = gl.createProgram();
  gl.attachShader(program, vertexShader);
  gl.attachShader(program, fragmentShader);
  gl.linkProgram(program);
  var success = gl.getProgramParameter(program, gl.LINK_STATUS);
  if (success) {
    return program;
  }
 
  console.log(gl.getProgramInfoLog(program));
  gl.deleteProgram(program);
}

function sizeCanvas(gl) {
	resizeCanvasToDisplaySize(gl.canvas);
	gl.viewport(0, 0, gl.canvas.width, gl.canvas.height);
}

function clearCanvas(gl) {
	gl.clearColor(0.0, 0.0, 0.0, 1.0);
	gl.clear(gl.COLOR_BUFFER_BIT);
}

function resizeCanvasToDisplaySize(canvas, multiplier) {
	multiplier = multiplier || 1;
	const width  = canvas.clientWidth  * multiplier | 0;
	const height = canvas.clientHeight * multiplier | 0;
	if (canvas.width !== width ||  canvas.height !== height) {
	  canvas.width  = width;
	  canvas.height = height;
	  return true;
	}
	return false;
}

function getAllCoord(gl, size){
	var table = []
	
	for (var y = -gl.canvas.height / 2; y < gl.canvas.height / 2; y += size) {
		for (var x = -gl.canvas.width / 2; x < gl.canvas.width / 2; x += size) {
			table.push( (x + (size/2)) / (gl.canvas.width / 2) );
			table.push( (y + (size/2)) / (gl.canvas.height / 2) );
		}
	}
	console.log(table);
	console.log(table.length);
	console.log(gl.canvas.height);
	console.log(gl.canvas.width);
	
	return table
}


main();