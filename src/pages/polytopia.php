<div class="article">
    <h1>Multiplayer strategy game built with Godot, Rust & Tokio</h1>
    <p class="short-intro">
        <span style="color: #df8886; font-style: normal;">Summer 2023 ~ @TitouanCh</span><br>
        In the summer of 2023, I tried my hand at making a "sequel" to the game Polytopia to learn how
        multiplayer games worked. I created server code in rust and built the client in godot.
    </p>

    <h2>Introduction</h2>

    <p>
        In the summer of 2023, me and my friends spent a great deal of time on a turn based strategy game called
        "Polytopia".
    </p>

    <div class="image-div" style="max-width: 900px; margin: auto"><img src="/assets/images/polytopia.jpg"
            alt="Picture of the game polytopia"><br>Marketing image of the game Polytopia that inspired me</div>

    <p>
        Spending all that time on this game gave me the motivation to have some fun and try to create my own
        online game in hopes of learning some things along the way. Emboldened by a bit of hubris, I named my
        project "Polytopia II" and dived headfirst into development.
    </p>

    <h2>Tool choice</h2>

    <p>
        I decided to use the Godot game engine to build the client. It's a game engine I'm intimately familiar
        with, having used it extensively for game jams and various unfinished projects over the years.
    </p>
    <p>
        As for the backend, I decided to do all the server code in Rust using the async library tokio. When I
        started the project, I didn't have a lot of experience with the Rust programming langage but I knew it
        was something I wanted to try out at some point. It didn't take long for me to get acustomed to the way
        Rust is written but it did take me some time to understand the intricacies of async & tokio: I rewrote
        the entire server code several times.
    </p>

    <h2>Building the client</h2>

    <p>Building the client and rendering portion of the project was the more creative part of the project. I
        fully utilized my knowledge of shaders and my experience of the Godot engine to create a performant yet
        beautiful (at least in my opinion) game world.</p>

    <div class="image-div" style="max-width: 900px; margin: auto"><img src="/assets/images/simple_landscape.png"
            alt="Simple terrain rendered by the godot client"><br>Simple terrain rendered by the godot client
    </div>

    <p>I worked on a terrain and water renderer, and a way to efficiently render lots of units and towns on the
        map. I also built some UI to login and connect to lobbies.</p>

    <h2>Server-side</h2>

    <p>
        Building the server code was a lot more challenging. Believe it or not, I initially started building it
        in NodeJS but quickly switched to Rust as I found it more lightweight and easier to prototype in
        considering my machine wasn't very powerful. After a lot of effort, I managed to build a functional
        server, that let's user choose a username, chat with others, join lobbies and create villages in the
        game. The server keeps tracks of all the games and is able to have many games going on at once thanks to
        the power of async.
    </p>

    <div class="image-div" style="max-width: 900px; margin: auto"><iframe height="315"
            src="https://www.youtube.com/embed/bJgXUPp1C1k?si=U60CFvyd7J0zopiF" title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe><br>Showcase of the chat
        system</div>
    <br>
    <div class="image-div" style="max-width: 900px; margin: auto"><iframe height="315"
            src="https://www.youtube.com/embed/LFandM3q5I4?si=DuRDHbH55l5bKaaj" title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe><br>Showcase of the lobby
        system</div>

    <h2>Lessons learned</h2>

    <p>As the project expanded, I realized the scope of what I was trying to achieve. With just myself working
        on the game, it became clear that bringing the full vision to life would take years. Eventually, I
        decided to put the project on hold as I wanted to pursue other interests.</p>
    <p>There was also a lot disputable decisions and mistakes made when building the interface between the
        server and client. Client and server would exclusively talk using the tcp protocol, which could be slow
        if I wanted some more realtime actions in the game. I also manually encoded different types of packets
        and wrote custom code to serialize data, when in hindsight, using a JSON serializer would have been far
        more efficient.</p>

    <h2>Conclusion</h2>

    <p>Building "Polytopia II" was a deeply rewarding journey. Although the project remains unfinished, it was
        an incredible learning opportunity, I walked away with lots of new skills, and had greater appreciation
        for async programming.</p>

    <p>You can find a link to the project on github <a href="https://github.com/TitouanCh/poly">here</a>.</p>


</div>