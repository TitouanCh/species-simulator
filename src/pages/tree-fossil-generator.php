<div class="article">
    <h1>Tree and Fossil Generators</h1>
    <p class="short-intro">
        <span style="color: #df8886; font-style: normal;">Winter 2022 ~ @TitouanCh</span><br>
        Simple tool to generate tree and fossil data...
    </p>

    <canvas id="newickParser" width="800" height="800"></canvas>

    <script id="simpleSizer">
        //var sizerWidth = document.getElementById('content').clientWidth;
        document.getElementById("newickParser").width = document.getElementById("newickParser").parentElement.offsetWidth;
    </script>

    <div id='Species Simulator parameters' class='simulation_parameters'
        style="background-color: #333; color: white; padding: 20px; text-align: center; border-radius: 20px; margin-top: 18px;">


        Pause :
        <input id="pause" type="checkbox" />
        </br>
        <!-- <div id="treeString" style="font-weight: bold;">(((D:0.3, E:0.3)B:0.2, C:0.5)A:0.1)F;</div> -->

        </br>
        Ntips : <input id="ntips" type="number" value="0" /></br>
        Speciation (λ) : <input id="speciation" type="number" value="0.1" /></br>
        Extinction (µ) : <input id="extinction" type="number" value="0.05" /></br>
        Extant Sampling (ρ) : <input id="extant sampling" type="number" value="0.6" /></br>
        Fossil Recovery (Ψ) : <input id="fossil recovery" type="number" value="0.05" /></br>
        <button type="button" onclick="generateTreeFromData()">Generate Tree</button>
    </div>

    </br>

    <h2>The importance of fossils</h2>
    <p>
        The fossil record is crucial for understanding how life has evolved over time. It helps us see big patterns in
        evolution, like how species have diversified and when key events in Earth's history happened. Fossils also play
        a big role in figuring out how different species are related to each other. This has led scientists to develop
        models that can include information from fossils when studying evolutionary relationships.
    </p>
    <div class="image-div"><img src="/assets/images/Ammonite.jpg" alt="Ammonite depicted from fossil"
            style="max-width: 50%"><br>How scientists believed ammonite looked from fossil data in 1908</div>
    <h2>The challenges of working with fossil data</h2>
    <p>
        Studying fossils is tricky because they're often incomplete and not evenly spread out. This means we have to be
        careful when interpreting what fossils tell us about ancient species and how they evolved. Current models used
        in research often simplify the process of how fossils are found and how species change over time. To improve our
        understanding, scientists use computer simulations to test different distribution of fossil data under various
        conditions. These simulations help them see how well their models work and what limitations they might have.
    </p>

    <h2>My model</h2>
    <p>
        Here I've implemented one such model. Using different parameters you can simulate phylogenetic and fossil data
        and imagine what the reconstructed tree would have looked like (hint: the reconstructed tree often looks quite
        different from reality).
    </p>
    <p>
        This sort of model give us great insights into the pitfalls we can encounter when reconstructing trees.
        Implemented in javascript using a foward generating method, my fairly simple model can still highlight some
        biases.
    </p>
    <p>
        For further exploration on this topic, I recommend taking a look at the R package <a
            href="https://cran.r-project.org/web/packages/FossilSim/index.html">FossilSim</a> and its app <a
            href="https://cran.r-project.org/web/packages/FossilSimShiny/">FossilSimShiny</a>. They provide powerful
        tools for simulating and visualizing evolutionary scenarios.
    </p>
    <script src="/assets/js/macroevolution/treeGen.js"></script>
    <script src="/assets/js/macroevolution/newick.js"></script>
    <script>generateTreeFromData();</script>
</div>