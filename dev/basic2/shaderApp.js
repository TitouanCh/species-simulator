function init(){
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
	
	console.log("DONE! Success ---")
	
	
	// CREATE UNIFORM
	var resolutionUniformLocation = gl.getUniformLocation(program, "u_resolution");
	var colorUniformLocation = gl.getUniformLocation(program, "u_color")
	
	// CREATE BUFFER
	var positionAttributeLocation = gl.getAttribLocation(program, "a_position");
	var positionBuffer = gl.createBuffer();
	gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer);
	var positions = [
	  10, 20,
	  80, 20,
	  10, 30,
	  10, 30,
	  80, 20,
	  80, 30,
	];
	gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(positions), gl.STATIC_DRAW);
	// ---
	
	sizeCanvas(gl);
	clearCanvas(gl);
	
	gl.useProgram(program);
	
	// set the resolution
	gl.uniform2f(resolutionUniformLocation, gl.canvas.width, gl.canvas.height);
	gl.uniform4f(colorUniformLocation, Math.random(), Math.random(), Math.random(), 1);
	
	// ATTRIBUTE SET UP
	gl.enableVertexAttribArray(positionAttributeLocation);
	// Tell the attribute how to get data out of positionBuffer (ARRAY_BUFFER)
	var size = 2;          // 2 components per iteration
	var type = gl.FLOAT;   // the data is 32bit floats
	var normalize = false; // don't normalize the data
	var stride = 0;        // 0 = move forward size * sizeof(type) each iteration to get the next position
	var offset = 0;        // start at the beginning of the buffer
	gl.vertexAttribPointer(positionAttributeLocation, size, type, normalize, stride, offset)
	
	// RUNNING SHADER
	var primitiveType = gl.TRIANGLES;
	var offset = 0;
	var count = 6;
	gl.drawArrays(primitiveType, offset, count);
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


init();