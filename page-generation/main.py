import os

from generator import *
from loader import *

directory = 'data'

for filename in os.listdir(directory):
    f = os.path.join(directory, filename)
    if os.path.isfile(f):
        extracted_data = load_data(f)
        generate_page("../", extracted_data["pagetitle"], extracted_data)
