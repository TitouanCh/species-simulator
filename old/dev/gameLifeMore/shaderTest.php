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


<script id="vertex-shader-2d" type="notjs">
attribute vec2 a_coord;

uniform vec2 u_resolution;
uniform vec2 u_size;

varying vec2 v_size;
varying vec2 v_coord;
varying vec2 v_resolution;

void main() {
	gl_PointSize = u_size.x*2.0;
	
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
uniform vec3 u_mouse;
uniform float u_mouse_data;

varying vec2 v_size;
varying vec2 v_coord;
varying vec2 v_resolution;

float rand(vec2 co) {
	if (u_once < 1.0) {
		return fract(sin(dot(co.xy ,vec2(12.9898, 78.233))) * 43758.5453 * u_once);
	}
	return fract(sin(dot(co.xy ,vec2(u_once, 78.233))) * u_once);
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

float toBinary(float s) {
	float n = 0.0;
	float source = s;
	if (source >= 256.0) {
		n += 100000000.0;
		source -= 256.0;
	}
	if (source >= 128.0) {
		n += 10000000.0;
		source -= 128.0;
	}
	if (source >= 64.0) {
		n += 1000000.0;
		source -= 64.0;
	} 
	if (source >= 32.0) {
		n += 100000.0;
		source -= 32.0;
	}
	if (source >= 16.0) {
		n += 10000.0;
		source -= 16.0;
	}
	if (source >= 8.0) {
		n += 1000.0;
		source -= 8.0;
	}
	if (source >= 4.0) {
		n += 100.0;
		source -= 4.0;
	}
	if (source >= 2.0) {
		n += 10.0;
		source -= 2.0;
	}
	if (source >= 1.0) {
		n += 1.0;
		source -= 1.0;
	}

	return n;
}


void main() {
	if (u_once > 0.0) {
		gl_FragColor = vec4(v_coord, cos(rand(v_coord)), 1);
	} else {
		vec2 offset = vec2((v_size.x + v_size.y));
		int sum =
        get(vec2(-1.0, -1.0) * offset) +
        get(vec2(-1.0,  0.0) * offset) +
        get(vec2(-1.0,  1.0) * offset) +
        get(vec2( 0.0, -1.0) * offset) +
        get(vec2( 0.0,  1.0) * offset) +
        get(vec2( 1.0, -1.0) * offset) +
        get(vec2( 1.0,  0.0) * offset) +
        get(vec2( 1.0,  1.0) * offset) +
		
		get(vec2( -1.0,  2.0) * offset) +
		get(vec2( 0.0,  2.0) * offset) +
		get(vec2( 1.0,  2.0) * offset) +
		
		get(vec2( -1.0,  2.0) * offset) +
		get(vec2( 0.0,  2.0) * offset) +
		get(vec2( 1.0,  2.0) * offset) +
		
		get(vec2( 2.0,  -1.0) * offset) +
		get(vec2( 2.0,  0.0) * offset) +
		get(vec2( 2.0,  1.0) * offset) +
		
		get(vec2( 2.0,  -1.0) * offset) +
		get(vec2( 2.0,  0.0) * offset) +
		get(vec2( 2.0,  1.0) * offset);
		
		if (sum > 3 && sum < 5) {
			gl_FragColor = vec4(v_coord, 1.0, 1.0);
		}
		else if (sum < 3 || sum > 5){
			gl_FragColor = texture2D(u_texture, v_coord);
		} else {
			gl_FragColor = vec4(0.0, 0.0, 0.0, 1.0);
		}
		
		if (u_mouse.z > 0.0) {
			
			float data = u_mouse_data;
			float previous = 0.0;
			
			for (float i = 0.0; i < 3.0; i++) {
				float currentlyLooking = pow(10.0, i) * 10.0;
				float currentData = floor(mod(data, currentlyLooking));
				currentData -= previous;
				previous += currentData;
				
				currentData = currentData / currentlyLooking * 10.0;
				
				currentData = toBinary(currentData);
				
				float previous2 = 0.0;
				
				for (float j = 0.0; j < 3.0; j++) {
					float currentlyLooking2 = pow(10.0, j) * 10.0;
					float currentData2 = floor(mod(currentData, currentlyLooking2));
					currentData2 -= previous2;
					previous2 += currentData2;
					
					currentData2 = currentData2 / currentlyLooking2 * 10.0;
					
					
					if (currentData2 > 0.0) {
						vec2 nemo = vec2(j, i) * offset;
						vec2 dory = unNormalizeVec(((normalizeVec(u_mouse.xy) * v_resolution) + nemo) / v_resolution);
						
						if (abs(v_coord.y - dory.y) + abs(v_coord.x - dory.x) < 0.000001) {
							gl_FragColor = vec4(1.0, 1.0, 1.0, 1.0);
						}
						
	
					}
					
				}
				
			}
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