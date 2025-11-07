<header class="phone-menu" style="position: sticky; top: 0; width: 100%">
    <ul style="background: linear-gradient(0.25turn, #333 35%, #000); list-style: none; height: 50px; margin-bottom: 0">
        <li><a href="/home" style="font-weight: bold; top: 11; position: relative; color: white;">titouan.ch</a>
        </li>
        <li>
            <div class="phone-button" width="16" style="position: absolute; top: 16px; right: 16px;"
                onclick="toggle_phone_menu()">
                <object data="/assets/svg/menu.svg" width="16"
                    style="pointer-events: none; filter: invert(100%);"></object>
            </div>
        </li>
    </ul>
    <?php include("site-guide.php"); ?>
    <script>
        var site_guide = document.getElementsByClassName("site-guide")[0];
        site_guide.style.visibility = "hidden";
        site_guide.style.opacity = 0;
        function toggle_phone_menu() {
            if (site_guide.style.visibility == "visible") {
                setTimeout(() => {
                    site_guide.style.visibility = "hidden";
                }, "250");
                site_guide.style.opacity = 0;
            } else {
                site_guide.style.visibility = "visible";
                site_guide.style.opacity = 1;
            }
        }
    </script>
</header>