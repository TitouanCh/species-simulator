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
uniform vec2 u_size;

varying vec2 v_size;
varying vec2 v_coord;
varying vec2 v_resolution;

void main() {
	gl_PointSize = u_size.x;
	
	vec2 pos = vec2(a_coord.x * 2.0 - 1.0, a_coord.y * 2.0 - 1.0);

	v_coord = a_coord;
	v_resolution = u_resolution;
	v_size = u_size;

	gl_Position = vec4(pos, 0, 1);
}
</script>
 
<script id="fragment-shader-2d" type="notjs">
precision mediump float;

uniform sampler2D u_texture;
uniform float u_once;

varying vec2 v_size;
varying vec2 v_coord;
varying vec2 v_resolution;

float rand(vec2 co) {
	return fract(sin(dot(co.xy ,vec2(12.9898, 78.233))) * 43758.5453);
}

vec2 normalizeVec(vec2 a) {
	vec2 result = (a + vec2(1.0, 1.0)) / vec2(2.0, 2.0);
	return result;
}

vec2 unNormalizeVec(vec2 b) {
	vec2 result = (b * vec2(2.0, 2.0)) - vec2(1.0, 1.0);
	return result;
}

int get(vec2 offset) {
	if ( (texture2D(u_texture, unNormalizeVec(((normalizeVec(v_coord) * v_resolution) + offset) / v_resolution))).b > 0.9 ) {
		return int(1);
	}
    return int(0);
}

void main() {
	if (u_once > 0.0) {
		gl_FragColor = vec4(v_coord, cos(rand(v_coord)), 1);
	} else {
		vec2 offset = vec2((v_size.x + v_size.y) / 2.0);
		int sum =
        get(vec2(-1.0, -1.0) * offset) +
        get(vec2(-1.0,  0.0) * offset) +
        get(vec2(-1.0,  1.0) * offset) +
        get(vec2( 0.0, -1.0) * offset) +
        get(vec2( 0.0,  1.0) * offset) +
        get(vec2( 1.0, -1.0) * offset) +
        get(vec2( 1.0,  0.0) * offset) +
        get(vec2( 1.0,  1.0) * offset);
		
		if (sum == 3) {
			gl_FragColor = vec4(v_coord, 1.0, 1.0);
		}
		else if (sum == 2){
			gl_FragColor = texture2D(u_texture, v_coord);
		} else {
			gl_FragColor = vec4(texture2D(u_texture, v_coord).r - 0.01, texture2D(u_texture, v_coord).g - 0.01, 0.0, 1.0);
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