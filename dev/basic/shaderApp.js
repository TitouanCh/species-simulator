var vertexShaderText =
[
'precision mediump float;',
'',
'attribute vec2 vertPosition;',
'attribute vec3 vertColor;',
'varying vec3 fragColor;',
'',
'void main()',
'{',
'   fragColor = vertColor;',
'	gl_Position = vec4(vertPosition, 0.0, 1.0);',
'}'
].join('\n');

var fragmentShaderText =
[
'precision mediump float;',
'',
'varying vec3 fragColor;',
'',
'void main()',
'{',
'	gl_FragColor = vec4(fragColor, 1.0);',
'}'
].join('\n');

function init(){
	console.log("Initializing WebGL ---");
	
	var canvas = document.getElementById("gl");
	var gl = canvas.getContext('webgl');
	
	if (!gl) {
		gl = canvas.getContext('experimental-webgl');
	}
	
	
	gl.clearColor(0.8, 0.8, 1.0, 1.0);
	gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);
	
	var vertexShader = gl.createShader(gl.VERTEX_SHADER);
	var fragmentShader = gl.createShader(gl.FRAGMENT_SHADER);
	
	gl.shaderSource(vertexShader, vertexShaderText);
	gl.shaderSource(fragmentShader, fragmentShaderText);
	
	gl.compileShader(vertexShader);
	if (!gl.getShaderParameter(vertexShader, gl.COMPILE_STATUS)) {
		console.error('ERROR: while compiling vertex shader', gl.getShaderInfoLog(vertexShader));
		return;
	}
	
	gl.compileShader(fragmentShader);
	if (!gl.getShaderParameter(fragmentShader, gl.COMPILE_STATUS)) {
		console.error('ERROR: while compiling fragment shader', gl.getShaderInfoLog(fragmentShader));
		return;
	}
	
	var program = gl.createProgram();
	gl.attachShader(program, vertexShader);
	gl.attachShader(program, fragmentShader);
	
	gl.linkProgram(program);
	if (!gl.getProgramParameter(program, gl.LINK_STATUS)){
		console.error('ERROR linking program!', gl.getProgramInfoLog(program));
		return;
	}
	
	console.log("DONE! Success ---")
	
	
	// CREATE BUFFER
	
	var triangleVertices =
	[
		0.0, 0.5,      1.0, 1.0, 0.0,
		-0.5, -0.5,    0.0, 0.0, 1.0,
		0.5, -0.5,     0.1, 1.0, 0.0
	];
	
	var triangleVertexBufferObject = gl.createBuffer();
	gl.bindBuffer(gl.ARRAY_BUFFER, triangleVertexBufferObject);
	gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(triangleVertices), gl.STATIC_DRAW);
	
	var positionAttribLocation = gl.getAttribLocation(program, 'vertPosition');
	var colorAttribLocation = gl.getAttribLocation(program, 'vertColor');
	
	gl.vertexAttribPointer(
		positionAttribLocation,
		2,
		gl.FLOAT,
		gl.FALSE,
		5 * Float32Array.BYTES_PER_ELEMENT,
		0
	);
	
	gl.vertexAttribPointer(
		colorAttribLocation,
		3,
		gl.FLOAT,
		gl.FALSE,
		5 * Float32Array.BYTES_PER_ELEMENT,
		2 * Float32Array.BYTES_PER_ELEMENT
	);
	
	gl.enableVertexAttribArray(positionAttribLocation);
	gl.enableVertexAttribArray(colorAttribLocation);
	
	gl.useProgram(program);
	gl.drawArrays(gl.TRIANGLES, 0, 3);

	
}

init();