def load_data(path):
    dic = {}
    
    for sl in ["title", "pagetitle", "short_desc", "type"]:
        dic[sl] = grab(open(path, 'r'), sl)[0]

    for ml in ["long_desc", "scripts", "parameters"]:
        dic[ml] = grab(open(path, 'r'), ml)

    return dic

def grab(f, tag):
    arr = []
    grabbing = False
    
    for l in f:
        l = l.replace("\n", "")

        if l == ";":
            grabbing = False

        if grabbing:
            arr.append(l)
            
        if l == tag.upper():
            grabbing = True

    return arr
