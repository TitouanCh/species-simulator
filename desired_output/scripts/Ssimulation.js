function startSimulation(Simulation) {
    Simulation.ready();
    Simulation.main();
}

class Ssimulation {
    constructor(board,
        FPS,
        background_color,
        border_color,
        ready_func,
        main_func) {
            this.board = board;
            this.FPS = FPS;
            this.paused = false;
            this.board_background = background_color;
            this.board_border = border_color;
            this.ready = ready_func;
            this.main = main_func;
            this.board_ctx = this.board.getContext("2d");
            this.resize = windowResize;
            window.addEventListener('resize', () => {this.resize()});
            this.resize();
        }
}

function windowResize() {
	this.board.width = this.board.parentElement.clientWidth;
	//this.board.height = this.board.parentElement.clientHeight;

	this.board_ctx.fillStyle = "#FFFF";
	this.board_ctx.fillRect(0, 0, this.board.width, this.board.height);
};