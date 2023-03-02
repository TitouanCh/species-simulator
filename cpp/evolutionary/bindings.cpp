#include <emscripten/bind.h>
#include "system.hpp"

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
      ;
   
   register_vector<float>("VectorFloat");
   register_vector<std::vector<float>>("VectorVectorFloat");
   register_vector<std::vector<std::vector<float>>>("VectorVectorVectorFloat");
   register_vector<std::vector<std::vector<std::vector<float>>>>("VectorVectorVectorVectorFloat");
   register_vector<std::vector<std::vector<std::vector<std::vector<float>>>>>("VectorVectorVectorVectorVectorFloat");
}