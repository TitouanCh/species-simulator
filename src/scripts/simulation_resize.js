const canvas = document.getElementsByClassName("simulation_canvas")[0];

canvas.width = canvas.parentElement.clientWidth;
canvas.height = canvas.parentElement.clientHeight;

const ctx = canvas.getContext("2d");

function windowResize() {
	/*
	var x = window.innerWidth;
	var y = window.innerHeight - 100;
	if (x > 1000) {
		var a = 0.8 * Math.pow((1800/(x)), 0.5);
		x = a * x;
	}
	if (y > 1000) {
		var b = 0.8 * Math.pow((1800/(y)), 0.5);
		y = y * b;
	}
	canvas.width = x;
	canvas.height = y;
	*/
	canvas.width = canvas.parentElement.clientWidth;
	canvas.height = canvas.parentElement.clientHeight;

	ctx.fillStyle = "#333";
	ctx.fillRect(0, 0, canvas.width, canvas.height);
};

window.addEventListener('resize', windowResize);

windowResize();
