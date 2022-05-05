<!DOCTYPE html>
<html>
<head>
<title>Simulation</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>

HI!

<main id="main">

<canvas id="gl" width="1024" height="600"></canvas>
</br>
BOTTOM TEXT

<script id="vertex-shader-2d" type="notjs">
attribute float a_vertexId;
uniform float u_numVerts;
uniform vec2 u_resolution;

#define PI radians(180.0)

void main() {
  float u = a_vertexId / u_numVerts;      // goes from 0 to 1
  float angle = u * PI * 2.0;         // goes from 0 to 2PI
  float radius = 0.8;

  vec2 pos = vec2(cos(angle), sin(angle)) * radius;
  
  float aspect = u_resolution.y / u_resolution.x;
  vec2 scale = vec2(aspect, 1);
  
  gl_Position = vec4(pos * scale, 0, 1);
  gl_PointSize = 5.0;
}
</script>
 
<script id="fragment-shader-2d" type="notjs">
precision mediump float;

void main() {
  gl_FragColor = vec4(1, 0, 0, 1);
}
</script>

<script src="shaderApp.js"></script>

</main>

</body>

</html>