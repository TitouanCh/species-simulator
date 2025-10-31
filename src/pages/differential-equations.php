<div class="article">
    <h1>Understanding Basic Differential Equations</h1>
    <p class="short-intro">
        <span style="color: #df8886; font-style: normal;">Summer 2021 ~ @TitouanCh</span><br>
        Differential equations are equations where the variable is a function. They are a powerful tool to model the
        world around us...
    </p>

    <h2>Differential equations of the first order</h2>
    <p>
        The order of a differential equation corresponds to the highest degree of derivation found in the equation.
        For example : y = y' + 1, the order is equal to 1 because y' is the highest degree of derivation found in the
        equation.
        </br>In this article, we'll only look at differential equations of the first order as they are the most simple.
    </p>

    <canvas id="differential" width="800" height="800"></canvas>

    <script id="simpleSizer">
        //var sizerWidth = document.getElementById('content').clientWidth;
        document.getElementById("differential").width = document.getElementById("differential").parentElement.offsetWidth;
    </script>

    <div id='Species Simulator parameters' class='simulation_parameters'
        style="background-color: #333; color: white; padding: 20px; text-align: center; border-radius: 20px; margin-top: 18px;">


        Pause :
        <input id="pause" type="checkbox" />
        ||
        Axes :
        <input id="axes" type="checkbox" />

        </br>
        <label for="equation">Equation : y' = </label>
        <input type="text" id="equation" name="equation" style="width:30px; text-align:center;" value="1"> y.
        <br>

        <label for="dlength">Vector Size : </label>
        <input type="number" id="dlength" name="dlength" value="10">

        </br>

        <label for="numPoints">Number of points : </label>
        <input type="number" id="numPoints" name="numPoints" value="500">
        ||
        <label for="scale">1/Scale : </label>
        <input type="number" id="scale" name="scale" value="10">

        <hr style="background-color: #292929;">
        <button type="button" onclick="ready();">Initialize</button>
    </div>

    </br>

    <h2>First order equation example : y'(t) = αy(t)</h2>
    <p>
        We graphed the equation : y'(t) = αy(t) above. With α a parameter.
        </br>
        Sur le graphique, nous observons des courbes rappelant la fonction exponentielle.
        </br></br>
        To graph the equation, we first chose random points on the graph with the y-axis representing y and the x-axis
        representing t.
        Then we draw vectors (y, y') to represent were the equation will tend to evolve to next.
        </br>
        The drawn vectors help us gain a better understanding of the equation and possibly help us find a solution.
        </br>
        We can observe curves reminding us of exponential functions. Indeed the solution to the equation is y(t) = exp(α
        + t).
    </p>

    <h2>What can differential equations be used for ?</h2>

    <p>
        Despite its simplicity, the equation we've just studied has many application.
        For example, we can use it to model population dynamics.
        </br>
        We can use it to model the growth of a population.</br>
        We'll have :</br>
        y' : correponding to the speed at which the population is growing.</br>
        y : corresponding to the population size.</br>
        α : corresponding to the population's growth factor.</br>
        With our equation : y'(t) = αy(t), our growth speed (y') will be proportional to our population size (y) and our
        growth factor (α).</br>
        </br>
        Differential equations are incredible tools to study phenomenons where the rate of change is affected by its
        parameters.
    </p>

    <script src="/scripts/differential/differential1.js"></script>

</div>
<?php include("site-side.php"); ?>
</div>
</body>

</html>