const canvas = document.getElementById("simulation canvas");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const ctx = canvas.getContext("2d");
ctx.beginPath();
ctx.arc(95, 50, 40, 0, 2 * Math.PI);
ctx.stroke();


function windowResize() {
	canvas.width = window.innerWidth;
	canvas.height = window.innerHeight;
};

window.addEventListener('resize', windowResize);
