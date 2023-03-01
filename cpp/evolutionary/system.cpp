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

    // Collision check (5 substep)
    for (int substep = 0; substep < 5; substep++) {
        for (int i = 0; i < data_PunkObject.size(); i++) {
            data_PunkObject[i].solve_collisions(data_PunkObject, substep == 0);
        }
        for (int i = 0; i < data_PunkObject.size(); i++) {
            data_PunkObject[i].establish();
        }
    }

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

std::string PunkSystem::print3() {
    if (data_PunkObject.size() >= 3) {
        return ("1: " + data_PunkObject[0].print_position() + " 2: " + data_PunkObject[1].print_position() + " 3: " + data_PunkObject[2].print_position());
    }

    return "Less than 3 objects...";
}

std::vector<std::vector<std::vector<std::vector<float>>>> PunkSystem::get_record() {
    return record;
}

std::vector<std::vector<float>> PunkSystem::get_frame_PunkObject(int frame) {
    if (frame < record.size()) {
        return record[frame][0];
    }
    return std::vector<std::vector<float>>();
}
