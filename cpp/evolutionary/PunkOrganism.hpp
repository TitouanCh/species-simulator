
#pragma once
#include <vector>
#include <string>
#include <functional>
#include <cmath>

#include "Utilities.hpp"
#include "PunkSystem.hpp"

#include <iostream>

class PunkSystem;

struct PunkOrganism 
{
    std::vector<std::uint64_t> dna;
    std::vector<PunkObject*> body;
    std::vector<PunkJoint*> joints;

    PunkSystem* my_system;

    PunkOrganism(PunkSystem* _p, std::vector<std::uint64_t> _dna);

    void build(float x_offset, float y_offset);
};