#pragma once
#include <vector>
#include <string>

#include <iostream>

#include "Utilities.hpp"
#include "PunkOrganism.hpp"

struct PunkOrganism;

class PunkSystem {
    public:
        PunkSystem();
        bool recording = true;
        void step(float delta);
        void process(float sigma, float interval);

        void add_Organism(std::vector<uint64_t> dna, float x, float y);
        void add_random_Organism(float x, float y);

        void add_PunkObject(float x, float y, float mass);
        PunkObject* create_PunkObject(int type, float x, float y, float mass);
        PunkJoint* create_PunkJoint(int type,PunkObject* a, PunkObject* b, float distance);
        std::string print3();

        void add_PunkJoint_by_index(int index1, int index2, float distance);
        
        // Used for recording/accessing information;
        //data[frame][category_of_object][object_id][object_propertie]
        std::vector<std::vector<std::vector<std::vector<float>>>> record = {};
        std::vector<std::vector<std::vector<std::vector<float>>>> get_record();
        std::vector<std::vector<std::vector<float>>> get_frame(int frame);

        // Properties
        bool finished = false;
        bool getFinished() const { return finished; };
        void setFinished(bool x_) { finished = x_; };

    private:
        std::vector<PunkObject> data_PunkObject;
        std::vector<PunkJoint> data_PunkJoint;
        std::vector<PunkOrganism> organisms;
        void add_PunkJoint(PunkObject* a, PunkObject* b, float distance);
};