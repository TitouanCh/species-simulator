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

<canvas id="gl" width="1260" height="840"></canvas>
</br>
BOTTOM TEXT

<script id="vertex-shader-2d" type="notjs">
attribute vec2 a_coord;

uniform vec2 u_resolution;
uniform float u_size;

varying vec2 v_coord;
varying vec2 v_resolution;

void main() {
	gl_PointSize = 5.0;
	
	vec2 pos = vec2(a_coord.x * 2.0 - 1.0, a_coord.y * 2.0 - 1.0);

	float aspect = u_resolution.y / u_resolution.x;
	vec2 scale = vec2(aspect, 1);

	v_coord = a_coord;
	v_resolution = u_resolution;

	gl_Position = vec4(pos, 0, 1);
}
</script>
 
<script id="fragment-shader-2d" type="notjs">
precision mediump float;

uniform sampler2D u_texture;
uniform float u_once;

varying vec2 v_coord;
varying vec2 v_resolution;

float rand(vec2 co) {
	return fract(sin(dot(co.xy ,vec2(12.9898, 78.233))) * 43758.5453);
}

int get(vec2 offset) {
	if ( texture2D(u_texture, ( ( ( ( ( ( v_coord + vec2(1.0, 1.0)/ vec2(2.0, 2.0) ) * v_resolution ) + (offset * 10.0) ) / v_resolution ) * vec2(2.0, 2.0) ) + vec2(1.0, 1.0) )).r > 0.5 ) {
		return int(1);
	}
    return int(0);
}

void main() {
	if (u_once > 0.0) {
		gl_FragColor = vec4(v_coord, rand(v_coord), 1);
	} else {
		int sum = get(vec2(-1.0, -1.0)) +
        get(vec2(-1.0,  0.0)) +
        get(vec2(-1.0,  1.0)) +
        get(vec2( 0.0, -1.0)) +
        get(vec2( 0.0,  1.0)) +
        get(vec2( 1.0, -1.0)) +
        get(vec2( 1.0,  0.0)) +
        get(vec2( 1.0,  1.0));
		
		if (sum == 0) {
			gl_FragColor = vec4(v_coord, 0.6, 1);
		}
		else if (sum == 1) {
			gl_FragColor = texture2D(u_texture, v_coord);
		} else {
			gl_FragColor = vec4(0.0, 0.0, 0.0, 1);
		}
	}
	
}
</script>

<script id="copy-shader-2d" type="notjs">
precision mediump float;

uniform sampler2D u_texture;
varying vec2 v_coord;

void main() {
    gl_FragColor = texture2D(u_texture, v_coord);
}
</script>

<script src="shaderApp.js"></script>

</main>

</body>

</html>