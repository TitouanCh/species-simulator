const canvas = document.getElementById("simulation_canvas");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const ctx = canvas.getContext("2d");

function windowResize() {
	canvas.width = window.innerWidth;
	canvas.height = window.innerHeight + 1;
	
	ctx.fillStyle = "#333";
	ctx.fillRect(0, 0, canvas.width, canvas.height);
};

window.addEventListener('resize', windowResize);

windowResize();
