<!DOCTYPE html>
<html>
<head>
<title>Simulation</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>

</style>
</head>

<body>

HI!

<main id="main">

<canvas id="gl" width="1025" height="600"></canvas>
</br>
BOTTOM TEXT

<script id="vertex-shader-2d" type="notjs">
attribute vec2 a_coord;
uniform vec2 u_resolution;
uniform float u_size;

varying vec2 v_coord;

void main() {
	gl_PointSize = u_size;
	vec2 pos = vec2(a_coord.x, a_coord.y);

	float aspect = u_resolution.y / u_resolution.x;
	vec2 scale = vec2(aspect, 1);

	v_coord = a_coord;

	gl_Position = vec4(pos, 0, 1);
}
</script>
 
<script id="fragment-shader-2d" type="notjs">
precision mediump float;

varying vec2 v_coord;

float rand(vec2 co) {
	return fract(sin(dot(co.xy ,vec2(12.9898, 78.233))) * 43758.5453);
}

void main() {
	if (rand(v_coord) > 0.5){
		gl_FragColor = vec4(v_coord, rand(v_coord), 1);
	} else {
		gl_FragColor = vec4(1, 1, 1, 1);
	}
}
</script>

<script src="shaderApp.js"></script>

</main>

</body>

</html>