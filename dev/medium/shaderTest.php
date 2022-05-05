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
attribute vec4 a_position;
attribute vec2 a_texcoord;
 
uniform mat4 u_matrix;
 
varying vec2 v_texcoord;
 
void main() {
  // Multiply the position by the matrix.
  gl_Position = u_matrix * a_position;
 
  // Pass the texcoord to the fragment shader.
  v_texcoord = a_texcoord;
}
</script>
 
<script id="fragment-shader-2d" type="notjs">
precision mediump float;
 
// Passed in from the vertex shader.
varying vec2 v_texcoord;
 
// The texture.
uniform sampler2D u_texture;
 
void main() {
   gl_FragColor = texture2D(u_texture, v_texcoord);
}
</script>

<script src="shaderApp.js"></script>

</main>

</body>

</html>