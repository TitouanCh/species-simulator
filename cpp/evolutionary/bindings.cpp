#include <emscripten/bind.h>
#include "PunkSystem.hpp"

using namespace emscripten;

EMSCRIPTEN_BINDINGS(punksystem) {
   class_<PunkSystem>("PunkSystem")
      .constructor<>()
      .property("finished", &PunkSystem::getFinished, &PunkSystem::setFinished)
      .function("step", &PunkSystem::step)
      .function("process", &PunkSystem::process)
      .function("add_PunkObject", &PunkSystem::add_PunkObject)
      .function("add_PunkJoint_by_index", &PunkSystem::add_PunkJoint_by_index)
      .function("print3", &PunkSystem::print3)
      .function("get_record", &PunkSystem::get_record)
      .function("get_frame", &PunkSystem::get_frame)
      .function("add_random_Organism", &PunkSystem::add_random_Organism)
      .function("add_Organism", &PunkSystem::add_Organism)
      ;
   
   register_vector<float>("VectorFloat");
   register_vector<std::vector<float>>("VectorVectorFloat");
   register_vector<std::vector<std::vector<float>>>("VectorVectorVectorFloat");
   register_vector<std::vector<std::vector<std::vector<float>>>>("VectorVectorVectorVectorFloat");
   register_vector<std::vector<std::vector<std::vector<std::vector<float>>>>>("VectorVectorVectorVectorVectorFloat");
   register_vector<std::uint64_t>("VectorInt64");
}