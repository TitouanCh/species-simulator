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
	var positionLocation = gl.getAttribLocation(program, "a_position");
	var texcoordLocation = gl.getAttribLocation(program, "a_texcoord");
	
	// UNIFORM - LOCATION:
	// ie: var exampleLocation = gl.getUniformLocation(program, "u_example");
	var matrixLocation = gl.getUniformLocation(program, "u_matrix");
	var textureLocation = gl.getUniformLocation(program, "u_texture");
	
	// CREATE BUFFER FOR DATA:
	// ie: var exampleBuffer = gl.createBuffer();
	//	   gl.bindBuffer(gl.ARRAY_BUFFER, exampleBuffer);
	//	   var exampleData = new Float32Array([ ... ]);
	// 	   gl.bufferData(gl.ARRAY_BUFFER, exampleData, gl.STATIC_DRAW);
	var positionBuffer = gl.createBuffer();
	gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer);
	var positionsData = new Float32Array([
	// left column front
	  0,   0,  0,
	  0, 150,  0,
	  30,   0,  0,
	  0, 150,  0,
	  30, 150,  0,
	  30,   0,  0,

	  // top rung front
	  30,   0,  0,
	  30,  30,  0,
	  100,   0,  0,
	  30,  30,  0,
	  100,  30,  0,
	  100,   0,  0,

	  // middle rung front
	  30,  60,  0,
	  30,  90,  0,
	  67,  60,  0,
	  30,  90,  0,
	  67,  90,  0,
	  67,  60,  0,

	  // left column back
		0,   0,  30,
	   30,   0,  30,
		0, 150,  30,
		0, 150,  30,
	   30,   0,  30,
	   30, 150,  30,

	  // top rung back
	   30,   0,  30,
	  100,   0,  30,
	   30,  30,  30,
	   30,  30,  30,
	  100,   0,  30,
	  100,  30,  30,

	  // middle rung back
	   30,  60,  30,
	   67,  60,  30,
	   30,  90,  30,
	   30,  90,  30,
	   67,  60,  30,
	   67,  90,  30,

	  // top
		0,   0,   0,
	  100,   0,   0,
	  100,   0,  30,
		0,   0,   0,
	  100,   0,  30,
		0,   0,  30,

	  // top rung right
	  100,   0,   0,
	  100,  30,   0,
	  100,  30,  30,
	  100,   0,   0,
	  100,  30,  30,
	  100,   0,  30,

	  // under top rung
	  30,   30,   0,
	  30,   30,  30,
	  100,  30,  30,
	  30,   30,   0,
	  100,  30,  30,
	  100,  30,   0,

	  // between top rung and middle
	  30,   30,   0,
	  30,   60,  30,
	  30,   30,  30,
	  30,   30,   0,
	  30,   60,   0,
	  30,   60,  30,

	  // top of middle rung
	  30,   60,   0,
	  67,   60,  30,
	  30,   60,  30,
	  30,   60,   0,
	  67,   60,   0,
	  67,   60,  30,

	  // right of middle rung
	  67,   60,   0,
	  67,   90,  30,
	  67,   60,  30,
	  67,   60,   0,
	  67,   90,   0,
	  67,   90,  30,

	  // bottom of middle rung.
	  30,   90,   0,
	  30,   90,  30,
	  67,   90,  30,
	  30,   90,   0,
	  67,   90,  30,
	  67,   90,   0,

	  // right of bottom
	  30,   90,   0,
	  30,  150,  30,
	  30,   90,  30,
	  30,   90,   0,
	  30,  150,   0,
	  30,  150,  30,

	  // bottom
	  0,   150,   0,
	  0,   150,  30,
	  30,  150,  30,
	  0,   150,   0,
	  30,  150,  30,
	  30,  150,   0,

	  // left side
	  0,   0,   0,
	  0,   0,  30,
	  0, 150,  30,
	  0,   0,   0,
	  0, 150,  30,
	  0, 150,   0
	]);
	gl.bufferData(gl.ARRAY_BUFFER, positionsData, gl.STATIC_DRAW);
	
	var texcoordBuffer = gl.createBuffer();
	gl.bindBuffer(gl.ARRAY_BUFFER, texcoordBuffer);
	var texcoordData = new Float32Array([
	// left column front
		0, 0,
		0, 1,
		1, 0,
		0, 1,
		1, 1,
		1, 0,

		// top rung front
		0, 0,
		0, 1,
		1, 0,
		0, 1,
		1, 1,
		1, 0,

		// middle rung front
		0, 0,
		0, 1,
		1, 0,
		0, 1,
		1, 1,
		1, 0,

		// left column back
		0, 0,
		1, 0,
		0, 1,
		0, 1,
		1, 0,
		1, 1,

		// top rung back
		0, 0,
		1, 0,
		0, 1,
		0, 1,
		1, 0,
		1, 1,

		// middle rung back
		0, 0,
		1, 0,
		0, 1,
		0, 1,
		1, 0,
		1, 1,

		// top
		0, 0,
		1, 0,
		1, 1,
		0, 0,
		1, 1,
		0, 1,

		// top rung right
		0, 0,
		1, 0,
		1, 1,
		0, 0,
		1, 1,
		0, 1,

		// under top rung
		0, 0,
		0, 1,
		1, 1,
		0, 0,
		1, 1,
		1, 0,

		// between top rung and middle
		0, 0,
		1, 1,
		0, 1,
		0, 0,
		1, 0,
		1, 1,

		// top of middle rung
		0, 0,
		1, 1,
		0, 1,
		0, 0,
		1, 0,
		1, 1,

		// right of middle rung
		0, 0,
		1, 1,
		0, 1,
		0, 0,
		1, 0,
		1, 1,

		// bottom of middle rung.
		0, 0,
		0, 1,
		1, 1,
		0, 0,
		1, 1,
		1, 0,

		// right of bottom
		0, 0,
		1, 1,
		0, 1,
		0, 0,
		1, 0,
		1, 1,

		// bottom
		0, 0,
		0, 1,
		1, 1,
		0, 0,
		1, 1,
		1, 0,

		// left side
		0, 0,
		0, 1,
		1, 1,
		0, 0,
		1, 1,
		1, 0
	]);
	gl.bufferData(gl.ARRAY_BUFFER, texcoordData, gl.STATIC_DRAW);
	
	// CREATE TEXTURE:
	var texture = gl.createTexture();
	gl.bindTexture(gl.TEXTURE_2D, texture);
	// Fill the texture with a 1x1 blue pixel.
	gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, 1, 1, 0, gl.RGBA, gl.UNSIGNED_BYTE, new Uint8Array([0, 0, 255, 255]));

	// USEFUL FCT
	function radToDeg(r) {
		return r * 180 / Math.PI;
	}

	function degToRad(d) {
		return d * Math.PI / 180;
	}

	// GLOBAL PARAM
	var fieldOfViewRadians = degToRad(60);
	var modelXRotationRadians = degToRad(0);
	var modelYRotationRadians = degToRad(0);

	var then = 0;

	// END OF SETUP
	console.log("Setup completed ---")
	
	requestAnimationFrame(draw);
	
	// CALLED EVERY FRAME
	function draw(now) {
		now *= 0.001;
		var delta = now - then;
		then = now;
		
		sizeCanvas(gl);
		
		gl.enable(gl.CULL_FACE);
		gl.enable(gl.DEPTH_TEST);
		
		modelXRotationRadians += 1.2 * delta;
		modelYRotationRadians += 0.7 * delta;
		
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
		
		gl.enableVertexAttribArray(positionLocation);
		gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer);
		var size = 3;          
		var type = gl.FLOAT;   
		var normalize = false; 
		var stride = 0;        
		var offset = 0;        
		gl.vertexAttribPointer(positionLocation, size, type, normalize, stride, offset);
		
		gl.enableVertexAttribArray(texcoordLocation);
		gl.bindBuffer(gl.ARRAY_BUFFER, texcoordBuffer);
		var size = 2;          
		var type = gl.FLOAT;   
		var normalize = false; 
		var stride = 0;        
		var offset = 0;        
		gl.vertexAttribPointer(texcoordLocation, size, type, normalize, stride, offset);
		
		// USE UNIFORM:
		// ie: gl.uniformTYPE(exampleLocation, DATA):
		gl.uniformMatrix4fv(matrixLocation, false, new Float32Array([1.0, 0.0, 0.0, 0.0, 0.0, 1.0, 0.0, 0.0, 0.0, 0.0, 1.0, 0.0, 0.0, 0.0, 0.0, 1.0]));
		gl.uniform1i(textureLocation, 0);

		// Draw the geometry.
		gl.drawArrays(gl.TRIANGLES, 0, 16 * 6);

		requestAnimationFrame(draw);
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
	gl.clearColor(0.8, 0.8, 1.0, 1.0);
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


main();