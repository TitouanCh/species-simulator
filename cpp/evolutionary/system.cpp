#include "system.hpp"

PunkSystem::PunkSystem() {
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

void PunkSystem::add_PunkObject(float x, float y, float mass) {
    data_PunkObject.push_back(PunkObject(x, y, mass));
}

void PunkSystem::add_PunkJoint(PunkObject* a, PunkObject* b, float distance) {
    data_PunkJoint.push_back(PunkJoint(a, b, distance));
}

void PunkSystem::add_PunkJoint_by_index(int index1, int index2, float distance) {
    add_PunkJoint(&data_PunkObject[index1], &data_PunkObject[index2], distance);
}


std::string PunkSystem::print3() {
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

