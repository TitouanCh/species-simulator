<div class="article">
    <h1>Newick tree parser and renderer</h1>
    <p class="short-intro">
        <span style="color: #df8886; font-style: normal;">Winter 2022 ~ @TitouanCh</span><br>
        Display trees in the Newick format using this free simple online parser...
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
        Newick Tree : </br>
        <textarea id="treeString" cols="100" rows="5"
            style="font-weight: bold; max-width: 98%;">(A:0.1,B:0.2,((E:0.1, F:0.1)C:0.3,((Z:0.02, U:0.04, I:0.2, H:0.21)X:0.2, P:0.112)D:0.05)E:0.1)F;</textarea>

        </br>
        <button type="button" onclick="ready()">Regenerate</button>
    </div>

    </br>

    <h2>Introduction</h2>
    <p>
        In early 2022, I became interested in population genetics as I had an upcoming internship in this field.
    </p>
    <p>
        To get some practice before starting the internship, I decided to work on a simple project: making my
        own Newick Tree Parser and Renderer.
    </p>

    <h2>Newick format</h2>
    <p>
        The Newick tree format, named after the restaurant is was created in, is a widely used textual
        representation for describing hierarchical relationships among biological sequences, such as genetic
        data or taxa in phylogenetic trees.
    </p>
    <p>
        It employs parentheses to denote nested groupings of sequences or nodes, with commas separating siblings
        (sequences or nodes at the same level). For example, a simple Newick tree might look like this:
        (A:0.1,B:0.2);, where A and B are leaf nodes representing sequences, and 0.1 and 0.2 are branch lengths.
    </p>
    <p>
        More complex trees can represent nested relationships, such as (A:0.1,(B:0.2,(C:0.3,D:0.4):0.5):0.6);.
        This simplicity and flexibility make Newick format very useful for storing and exchanging phylogenetic
        tree structures.
    </p>

    <h2>My implementation</h2>
    <p>
        The simple renderer above is programmed in javascript, I've utilised recursion to be able to render any
        possible structure.
    </p>

    <script src="/assets/js/macroevolution/newick.js"></script>

</div>