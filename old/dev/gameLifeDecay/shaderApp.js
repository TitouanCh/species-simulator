function main(){
	console.log("Initializing WebGL ---");
	
	var canvas = document.getElementById("gl");
	var gl = canvas.getContext('webgl');
	
	const pointSize = 4.0
	const pointOffset = 2.0
	
	if (!gl) {
		gl = canvas.getContext('experimental-webgl');
	}
	
	if (!gl) {
		console.log("no webgl for you :(")
		return
	}
	
	var vertexShader = createShader(gl, gl.VERTEX_SHADER, document.getElementById("vertex-shader-2d").text);
	var fragmentShader = createShader(gl, gl.FRAGMENT_SHADER, document.getElementById("fragment-shader-2d").text);
	var copyShader = createShader(gl, gl.FRAGMENT_SHADER, document.getElementById("copy-shader-2d").text);
	
	var program = createProgram(gl, vertexShader, fragmentShader);
	var copyProgram = createProgram(gl, vertexShader, copyShader)
	
	console.log("DONE! Compiling Success ---")
	
	// ATTRIBUTE - LOCATION:
	// ie: var exampleLocation = gl.getAttribLocation(program, "a_example");
	var coordLocation = gl.getAttribLocation(program, "a_coord");
	
	var coordLocation_Copy = gl.getAttribLocation(copyProgram, "a_coord");
	
	// UNIFORM - LOCATION:
	// ie: var exampleLocation = gl.getUniformLocation(program, "u_example");
	var resolutionLocation = gl.getUniformLocation(program, "u_resolution");
	var sizeLocation = gl.getUniformLocation(program, "u_size");
	var textureLocation = gl.getUniformLocation(program, "u_texture");
	var onceLocation = gl.getUniformLocation(program, "u_once");
	
	var resolutionLocation_Copy = gl.getUniformLocation(copyProgram, "u_resolution");
	var sizeLocation_Copy = gl.getUniformLocation(copyProgram, "u_size");
	var textureLocation_Copy = gl.getUniformLocation(copyProgram, "u_texture");
	
	// CREATE BUFFER FOR DATA:
	// ie: var exampleBuffer = gl.createBuffer();
	//	   gl.bindBuffer(gl.ARRAY_BUFFER, exampleBuffer);
	//	   var exampleData = new Float32Array([ ... ]);
	// 	   gl.bufferData(gl.ARRAY_BUFFER, exampleData, gl.STATIC_DRAW);
	var coordBuffer = gl.createBuffer();
	gl.bindBuffer(gl.ARRAY_BUFFER, coordBuffer);
	const coordData = new Float32Array(getAllCoord(gl, (pointSize + pointOffset)/2));
	gl.bufferData(gl.ARRAY_BUFFER, coordData, gl.STATIC_DRAW);
	
	// WITCHCRAFT:

	// Create a texture to render to
	const targetTextureWidth = canvas.width;
	const targetTextureHeight = canvas.height;
	const targetTexture = gl.createTexture();
	gl.bindTexture(gl.TEXTURE_2D, targetTexture);

	{
	// define size and format of level 0
	const level = 0;
	const internalFormat = gl.RGBA;
	const border = 0;
	const format = gl.RGBA;
	const type = gl.UNSIGNED_BYTE;
	const data = null;
	gl.texImage2D(gl.TEXTURE_2D, level, internalFormat, targetTextureWidth, targetTextureHeight, border, format, type, data);

	// set the filtering so we don't need mips
	gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
	gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
	gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
    }

	// Create and bind the framebuffer
	const fb = gl.createFramebuffer();
	gl.bindFramebuffer(gl.FRAMEBUFFER, fb);
	
	console.log((gl.canvas.height * gl.canvas.width) / (pointSize + pointOffset))

	// attach the texture as the first color attachment
	const attachmentPoint = gl.COLOR_ATTACHMENT0;
	const level = 0;
	gl.framebufferTexture2D(gl.FRAMEBUFFER, attachmentPoint, gl.TEXTURE_2D, targetTexture, level);
	
	// Create a second texture to render to
	const targetTexture2 = gl.createTexture();
	gl.bindTexture(gl.TEXTURE_2D, targetTexture2);

	{
	// define size and format of level 0
	const level = 0;
	const internalFormat = gl.RGBA;
	const border = 0;
	const format = gl.RGBA;
	const type = gl.UNSIGNED_BYTE;
	const data = null;
	gl.texImage2D(gl.TEXTURE_2D, level, internalFormat, targetTextureWidth, targetTextureHeight, border, format, type, data);

	// set the filtering so we don't need mips
	gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
	gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
	gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
    }

	// Create and bind the framebuffer
	const fb2 = gl.createFramebuffer();
	gl.bindFramebuffer(gl.FRAMEBUFFER, fb2);

	// attach the texture as the first color attachment
	gl.framebufferTexture2D(gl.FRAMEBUFFER, attachmentPoint, gl.TEXTURE_2D, targetTexture2, level);

	// END OF SETUP
	console.log("Setup completed ---")
	
	var once = true;
	requestAnimationFrame(draw);
	
	function gol(PROGRAM, string) {
		gl.useProgram(PROGRAM);

		// USE ATTRIBUTE:
		// ie: gl.enableVertexAttribArray(exampleLocation);
		//	   gl.bindBuffer(gl.ARRAY_BUFFER, exampleBuffer);
		// 	   var size = number of components per iteration;
		//     var type = gl.FLOAT, 32 bit floats;
		//     var normalize = false;
		//	   var stride = 0, move forward size * sizeof(type) each iteration to get the next position;
		//	   var offset = 0 where to start in buffer;
		// 	   vertexAttribPointer(exampleLocation, size, type, normalize, stride, offset);
		
		if (string == "copy") {
			gl.enableVertexAttribArray(coordLocation_Copy);
		} else {
			gl.enableVertexAttribArray(coordLocation);
		}
		
		gl.bindBuffer(gl.ARRAY_BUFFER, coordBuffer);
		var size = 2;          
		var type = gl.FLOAT;   
		var normalize = false; 
		var stride = 0;        
		var offset = 0;        
		gl.vertexAttribPointer(coordLocation, size, type, normalize, stride, offset);
		
		// USE UNIFORM:
		// ie: gl.uniformTYPE(exampleLocation, DATA):
		if (string == "copy") {
			gl.uniform2f(resolutionLocation_Copy, gl.canvas.width, gl.canvas.height);
			gl.uniform2f(sizeLocation_Copy, pointSize, pointOffset);
			gl.uniform1i(textureLocation_Copy, 0);
		} else {
			gl.uniform2f(resolutionLocation, gl.canvas.width, gl.canvas.height);
			gl.uniform2f(sizeLocation, pointSize, pointOffset);
			gl.uniform1i(textureLocation, 0);
			if (once){
				gl.uniform1f(onceLocation, 1.0);
				once = false;
			} else {
				gl.uniform1f(onceLocation, 0.0);
			}
		}

		// Draw the geometry.
		const geomOffset = 0;
		gl.drawArrays(gl.POINTS, geomOffset, gl.canvas.height * gl.canvas.width);
	}
	
	// CALLED EVERY FRAME
	function draw(time) {
		{
		// render to our targetTexture by binding the framebuffer
		gl.bindFramebuffer(gl.FRAMEBUFFER, fb);

		gl.bindTexture(gl.TEXTURE_2D, targetTexture2);
		
		sizeCanvas(gl);
		
		clearCanvas(gl);
		gol(program, "gol");
		}
		
		{
		// 2nd buffer
		gl.bindFramebuffer(gl.FRAMEBUFFER, fb2);

		gl.bindTexture(gl.TEXTURE_2D, targetTexture);
		
		sizeCanvas(gl);
		
		clearCanvas(gl);
		gol(copyProgram, "copy");
		}
		
		{
        // render to the canvas
        gl.bindFramebuffer(gl.FRAMEBUFFER, null);

        gl.bindTexture(gl.TEXTURE_2D, targetTexture);
		
		sizeCanvas(gl);
		
		clearCanvas(gl);
		
        gol(copyProgram, "copy");
		}
		
		
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
	console.log(table)
	
	console.log(table.length)
	return table
}


main();