<div class="article">
    <h1>iGEM: International genetically engineered machine</h1>
    <p class="short-intro">
        <span style="color: #df8886; font-style: normal;">Summer 2022 ~ @TitouanCh</span><br>
        In 2022, I took part in the iGEM competition for the <b>GO Paris-Saclay team</b>... read some details about my
        experience here or check out the team <a href="https://2022.igem.wiki/go-paris-saclay/">wiki</a>.
    </p>

    <h2>Introduction</h2>

    <p>
        In 2022, I had the opportunity to participate in the IGEM competition and represent my university, engaging in
        the exciting field of synthetic biology. Engineering the genetic material of organisms creating sorta...
        artificial life.
    </p>
    <p>
        My main roles were building the team's <a href="https://2022.igem.wiki/go-paris-saclay/">wiki</a> and, perhaps
        more interestingly, modeling the metabolism of our microorganism of interest: strains of <i>Streptmocyces</i>.
    </p>
    <p>
        More precisely, we wanted to model the impact of introducing a CO₂ fixation module into <i>Streptomyces</i>,
        possibly changing it from a heterotrophic organism into an autotrophic organism or more realisticly into a
        hemiautotrophic organism.
    </p>

    <div style="display: flex; gap: 10%; justify-content: center;">
        <div class="image-div" style="flex: 1; max-width: 250px"><img
                src="/assets/images/bottropensis_petri_streptomyces.jpg" alt="Mathematician John Horton Conway"><br>S.
            bottropensis culture inside a petri dish</div>
        <div class="image-div" style="flex: 1; max-width: 250px"><img
                src="/assets/images/bottropensis_micro_streptomyces.jpg"
                alt="S. bottropensis culture seen from a microscope"><br>S. bottropensis culture seen from a microscope
        </div>
    </div>

    <h2>Modeling a metabolic network</h2>

    <p>
        I began by filtering through the extensive dataset of metabolic reactions by <i>Streptomyces</i>, specifically
        focusing on those directly or indirectly associated with CO₂ fixation. This data was sourced from KEGG (Kyoto
        Encyclopedia of Genes and Genomes).
    </p>
    <p>
        I decided to model these enzymatic reactions of streptomyces as an array of differential equations.
        The change in the quantity of metabolite at any point being dependant on the other metabolites.
        This approach was inspired flux based analysis, a common approach when studying metabolic networks.
    </p>

    <h2>Solving the equations</h2>

    <p>
        To explore the dynamics of my model, I developed a simple simulator. This tool enabled me to simulate different
        scenarios by adjusting initial parameters and observing the resulting changes in metabolite quantities over
        time. Here is a screenshot of the software I developped:
    </p>
    <div class="image-div" style="max-width: 900px; margin: auto"><img src="/assets/images/modeling_software_igem.png"
            alt="Screenshot of the software I developed for the iGEM competition"><br>Screenshot of the simple simulator
        I developped for the competiton</div>
    <p>
        Interestingly, I developed the entire software using the Godot game engine, which, admittedly, isn't the ideal
        tool for the job. However, due to the time constraints imposed by the competition, this way of working proved to
        be a remarkably swift way to iterate while keeping our simulator very visual, an essential asset for promoting
        and communicating our project.
    </p>

    <h2>Conclusion</h2>

    <p>
        In the end the model was somewhat useful, it seemed to show that our project was at least possible in theory.
        But of course, we needed to move to bench experiments before anything more could be infered.
    </p>
    <p>
        For more details, I invite you to check out our team <a href="https://2022.igem.wiki/go-paris-saclay/">wiki</a>.
    </p>
</div>