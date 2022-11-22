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
        }
}
