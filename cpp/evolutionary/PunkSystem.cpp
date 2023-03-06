#include "PunkSystem.hpp"

PunkSystem::PunkSystem() {
    srand(time(NULL));
}

void PunkSystem::step(float delta) {
    std::vector<std::vector<std::vector<float>>> this_frame = {};
    
    // Move PunkObjects everything based on velocity
    std::vector<std::vector<float>> record_PunkObject = {};
    for (int i = 0; i < data_PunkObject.size(); i++) {
        // Save to record
        if (recording) {
            record_PunkObject.push_back(data_PunkObject[i].record());
        }
        data_PunkObject[i].process(delta);
    
    }
    this_frame.push_back(record_PunkObject);

    // Collision check (8 substep)
    std::vector<std::vector<float>> record_PunkJoint = {};

    int total_substeps = 8;
    for (int substep = 0; substep < total_substeps; substep++) {
        for (int i = 0; i < data_PunkObject.size(); i++) {
            data_PunkObject[i].solve_collisions(data_PunkObject, substep == 0);
        }
        for (int i = 0; i < data_PunkJoint.size(); i++) {
            data_PunkJoint[i].process();
            
            if (recording && substep + 1 == total_substeps) {
                record_PunkJoint.push_back(data_PunkJoint[i].record());
            }
        }
        for (int i = 0; i < data_PunkObject.size(); i++) {
            data_PunkObject[i].establish();
        }
    }
    this_frame.push_back(record_PunkJoint);
    
    record.push_back(this_frame);
}

void PunkSystem::process(float sigma, float interval) {
    for (float i = 0.0; i < sigma; i += interval) {
        step(interval);
    }
    finished = true;
}

void PunkSystem::add_Organism(std::vector<uint64_t> dna, float x, float y) {
    organisms.push_back(PunkOrganism(this, dna));
    organisms[organisms.size() - 1].build(x, y);  
}

void PunkSystem::add_random_Organism(float x, float y) {
    srand(time(NULL));
    int i_max = random(20, 1);

    std::vector<uint64_t> dna = {};

    for (int i = 0; i < i_max; i++) {
        uint64_t a;
        while (a >= 10000000000000000000)
        {
            a = random64();
        }
        
        dna.push_back(a);
    }
    add_Organism(dna, x, y);
}

void PunkSystem::add_PunkObject(float x, float y, float mass) {
    data_PunkObject.push_back(PunkObject(x, y, mass));
}

void PunkSystem::add_PunkJoint(PunkObject* a, PunkObject* b, float distance) {
    data_PunkJoint.push_back(PunkJoint(a, b, distance));
}

void PunkSystem::add_PunkJoint_by_index(int index1, int index2, float distance) {
    add_PunkJoint(&data_PunkObject[index1], &data_PunkObject[index2], distance);
}

PunkObject* PunkSystem::create_PunkObject(int type, float x, float y, float mass)
{
    PunkObject _new = PunkObject(x, y, mass);
    data_PunkObject.push_back(_new);
    return &data_PunkObject[data_PunkObject.size() - 1];
}

PunkJoint* PunkSystem::create_PunkJoint(int type, PunkObject *a, PunkObject *b, float distance) {
    std::cout << "joint created1" << std::endl;
    PunkJoint _new = PunkJoint(a, b, distance);
    std::cout << "joint created2" << std::endl;
    data_PunkJoint.push_back(_new);
    std::cout << "joint created3" << std::endl;
    return &data_PunkJoint[data_PunkJoint.size() - 1];
}

std::string PunkSystem::print3()
{
    if (data_PunkObject.size() >= 3) {
        return ("1: " + data_PunkObject[0].print_position() + " 2: " + data_PunkObject[1].print_position() + " 3: " + data_PunkObject[2].print_position());
    }

    return "Less than 3 objects...";
}

std::vector<std::vector<std::vector<std::vector<float>>>> PunkSystem::get_record() {
    return record;
}

std::vector<std::vector<std::vector<float>>> PunkSystem::get_frame(int frame) {
    if (frame < record.size()) {
        return record[frame];
    }
    return std::vector<std::vector<std::vector<float>>>();
}