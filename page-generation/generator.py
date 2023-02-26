test_data = {
        "title" : "Simulation",
        "short_desc" : "This is a small description",
        "long_desc" : "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel tellus sodales, pulvinar velit sit amet, auctor est. Aenean porttitor ipsum ut neque pretium interdum. Maecenas facilisis quis nunc nec commodo. In hac habitasse platea dictumst. Curabitur libero libero, cursus sit amet purus eget, tempus vulputate metus. In sem augue, faucibus vel hendrerit a, gravida vel enim. Phasellus nec odio quam. In cursus nulla a luctus pellentesque. Cras eget ipsum eu est venenatis lobortis ac vel nulla. Aliquam et turpis interdum, eleifend purus et, consectetur lacus. Nulla efficitur accumsan augue vitae molestie. Ut vitae laoreet ante. Nullam dictum a turpis quis tempus.",
        "type" : "js",
        "scripts" : ["script1", "script2", "script3"]
        }

def read_html(path, filename):
    file = open(path + "/" + filename, 'r')
    html = []
    for line in file:
        html.append(line.replace("\n", ""))
    return html

def write_arr(f, arr):
    for line in arr:
        f.write(line + "\n")

def generate_head(data):
    arr = [
            "<!DOCTYPE html>",
            "<html>",
            "<head>",
            "<title>" + data["title"] + "</title>",
            "<link rel='stylesheet' href='style.css'>",
            "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>",
            "<meta name='viewport' content='width=device-width, initial-scale=1'>",
            "</head>"
            ]

    return arr

def generate_titlebar(data):
    arr = [
            "<div id='" + data["title"]  +"' class='simulation_title'>",
            "<h1>" + data["title"] + "</h1>",
            "<h2>" + data["title"] + " - Species-Simulator.com</h2>",
            "</div>"
            ]
    return arr

def generate_navbar():
    return read_html("html", "navbar.html")

def generate_simulationcanvas(data):
    if data["type"] == "article": return []
    arr = [
            "<div id='" + data["title"] + " online simulator' class='online_simulator' style='text-align: center;'>",
            "<canvas id='" + data["title"] + " simulation' class='simulation_canvas'  width = '900' height='1525'>",
            "</div>"
            ]
    return arr

def generate_simulationparam(data):
    if data["type"] == "article": return []
    arr = [
            "<div id='" + data["title"] + " parameters' class='simulation_parameters'>",
            "</div>"
            ]
    if data["parameters"][0].startswith("CUSTOM"):
        arr = read_html("html/" + data["pagetitle"], data["parameters"][0].replace("CUSTOM ", ""))
    return arr

# TODO : refurbish the way long_desc works
def generate_desc(data):
    arr = [
            "<div id='" + data["title"] + "' description class='simulation_description'>",
            data["long_desc"][0],
            "</div>"
            ]
    if data["long_desc"][0].startswith("CUSTOM"):
        arr = read_html("html/" + data["pagetitle"], data["long_desc"][0].replace("CUSTOM ", ""))
    return arr

def generate_imports(data):
    arr = []
    for script_import in data["scripts"]:
        arr.append("<script src=" + script_import.replace("$PAGETITLE", data["pagetitle"]) + "></script>")
    return arr

def generate_body(data):
    arr1 = ["<body>"]
    
    arr2 = generate_navbar()

    arr3 = ["<main id = '" + data["title"] + "'>", "<div class='article'>"]
    
    arr4 = generate_titlebar(data)

    arr5 = generate_simulationcanvas(data)
    
    arr6 = generate_simulationparam(data)

    arr7 = generate_desc(data)

    if (data["type"] == "gl"):
        arr7 += read_html("html/" + data["pagetitle"], "shader.html")

    arr8 = generate_imports(data)

    arr9 = [
            "</div>",
            "</main>",
            "</body>",
            "</html>"
            ]

    return arr1 + arr2 + arr3 + arr4 + arr5 + arr6 + arr7 + arr8 + arr9

def generate_page(path, filename, data):
    with open(path + filename + ".php", 'w') as f:
        write_arr(f, generate_head(data))
        write_arr(f, generate_body(data))
