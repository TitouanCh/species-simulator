#include <vector>
#include <string>

#include <iostream>

#include "utilities.hpp"

class PunkSystem {
    public:
        PunkSystem();
        bool recording = true;
        void step(float delta);
        void process(float sigma, float interval);
        void add_PunkObject(float x, float y, float mass);
        std::string print3();
        
        // Used for recording/accessing information;
        //data[frame][category_of_object][object_id][object_propertie]
        std::vector<std::vector<std::vector<std::vector<float>>>> record = {};
        std::vector<std::vector<std::vector<std::vector<float>>>> get_record();
        std::vector<std::vector<float>> get_frame_PunkObject(int frame);

        // Properties
        bool finished = false;
        bool getFinished() const { return finished; };
        void setFinished(bool x_) { finished = x_; };

    private:
        std::vector<PunkObject> data_PunkObject;
};