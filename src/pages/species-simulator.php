<div class="article">
    <h1>Species simulator</h1>

    <p class="short-intro">
        <span style="color: #df8886; font-style: normal;">Winter 2020 ~ @TitouanCh</span><br>
        Species Simulator - Species-Simulator.com
        An online stochastic species simulator, useful for studying interactions between invasive and endemic species.
    </p>
    <div id='Species Simulator online simulator' class='online_simulator' style='text-align: center;'>
        <canvas id='Species Simulator simulation' class='simulation_canvas' width='900' height='525'>
    </div>
    <div id='Species Simulator parameters' class='simulation_parameters'
        style="background-color: #333; color: white; padding: 20px; text-align: center; border-radius: 20px; margin-top: 18px; font-weight: 500;">
        <label class="hiddenLabel" for="restartSim">Restart Simulation: </label>
        <button id="restartSpeciesSim" onclick="species_simulation.start();"><object data="/assets/svg/arrow_circle.svg"
                width="32" style="pointer-events: none;"></object></button>
        <label class="hiddenLabel" for="pauseSim">Pause: </label>
        <button id="restartSpeciesSim"
            onclick="species_simulation.pause = !species_simulation.pause; if (species_simulation.pause) {document.getElementById('restartSpeciesSimIcon').data = '/assets/svg/play.svg';} else {document.getElementById('restartSpeciesSimIcon').data = '/assets/svg/pause.svg';}"><object
                id="restartSpeciesSimIcon" data="/assets/svg/pause.svg" width="32"
                style="pointer-events: none;"></object></button>

        <hr style="background-color: black; border: none; height: 1px;">

        <div style="margin-top: 25px; margin-bottom: 35px">
            <div style="font-style: italic; margin-top: 10px; margin-bottom: 10px">Parameters --</div>
            <label for="tableWidth">Table width: </label>
            <input type="number" min="0" value="100" id="tableWidth"><br>
            <label for="tableHeight">Table height: </label>
            <input type="number" min="0" value="100" id="tableHeight"><br>
            <label for="cellWidth">Cell width: </label>
            <input type="number" min="0" value="100" id="cellWidth"><br>
            <label for="cellHeight">Cell height: </label>
            <input type="number" min="0" value="100" id="cellHeight"><br>
            <label for="FPS">Generation per second: </label>
            <input type="number" min="0" value="60" id="FPS"><br>
        </div>

        <hr style="background-color: black; border: none; height: 1px;">

        <input id="addSpecies" type="button" value="Add a new species" onclick="species_simulation.add_species();">
        <input id="deleteSpecies" type="button" value="Delete species" onclick="species_simulation.delete_species();">
        <div id="speciesPanel" style="gap: 4px;"></div>

        <br>
    </div>

    <script src=/assets/js/utils.js></script>
    <script src=/assets/js/Ssimulation.js></script>
    <script src=/assets/js/species-simulator/Species_Cell.js></script>
    <script src=/assets/js/species-simulator/species_simulator.js></script>

    <h2>Introduction</h2>

    <p>Species simulator is the initial inspiration behind my website. It began as a stochastic simulator developed with
        some classmates, aiming to creatively simulate interactions between endemic and invasive species.</p>

    <p>However, it soon became apparent that the simulator possessed far greater versatility. Different configurations
        proved capable of simulating a wide array of ecological relationships.</p>

    <p>One limitation of the model is that many of the depicted relationships can also be replicated using differential
        equations and some Brownian motion techniques.</p>

    <h2>The rules</h2>

    <p>The program operates akin to a cellular automata with a grid of cells, where each cell can either be unoccupied
        or inhabited by a species.</p>

    <p>To allow the reproduction of our little critters, we introduce the concept of generations: in each cycle, our
        program determines if individuals reproduce. Initially, a reproduction rate is assigned to each species. Each
        cycle, for every empty cell, the program executes the following steps:</p>

    <ol>
        <li>First, it identifies adjacent cells to the empty one.</li>
        <li>For each adjacent cell occupied by a species, the program randomly selects a number from 1 to 100. If this
            number is below the species' reproduction rate, the species gains 1 point for that cell; otherwise, it gains
            nothing.</li>
        <li>Finally, the program tallies these points. If there's a tie or no species scores points, the cell remains
            empty. Otherwise, a new individual of the winning species emerges in that cell.</li>
    </ol>

    <p>This algorithm proves highly effective for modeling autotrophic species like plants. However, for heterotrophic
        species such as animals, an additional feature is necessary.</p>

    <p>Hence, we introduce the concept of predation: each cycle, for every cell occupied by a species, neighboring cells
        housing predators of that species have a chance to prey upon it, based on a predefined predation rate.</p>

    <p>Lastly, each species is assigned a maximum lifespan. When an individual of a species reaches this age, it
        disappears, freeing its cell for reuse.</p>

    <h2>Interesting configurations</h2>

    <p>Initially designed to model simple interactions between two species, the versatility of this model has made
        exploring other configurations quite enjoyable. Here are a few intriguing examples:</p>

    <h3>Endemic vs Invasive</h3>
    <div class="image-div"><img src="/assets/images/species_simulator_regular.gif" alt="GIF of a regular simulation"
            style="image-rendering: pixelated"><br>Simple endemic vs invasive simulation</div>

    <p>This setup involves just two species, where one species has a higher reproduction rate than the other. Over time,
        it becomes evident that the less competitive species tends to become extinct.</p>

    <h3>Rock Paper Scissors</h3>
    <div class="image-div"><img src="/assets/images/species_simulator_rock_paper_scissors.gif"
            alt="GIF of a rock paper scissors simulation" style="image-rendering: pixelated"><br>Rock paper scissors
        simulation</div>

    <p>In this configuration, three species are involved in a cyclic predation pattern: the first species preys on the
        second, the second preys on the third, and the third preys on the first. With carefully chosen colors for each
        species, the visual representation of this simulation proves to be captivating.</p>

    <h3>Virus</h3>
    <div class="image-div"><img src="/assets/images/species_simulator_virus.gif" alt="GIF of a virus simulation"
            style="image-rendering: pixelated"><br>Virus simulation</div>

    <p>A fascinating scenario involves one species capable of regular reproduction and another species unable to
        reproduce but preying upon the first. This configuration mimics a virus-host relationship, resulting in visually
        striking dynamics.</p>

    <h2>Implementation</h2>

    <p>The implementation is simple, everything was written in javascript. I utilized workers to avoid browser hanging.
    </p>
</div>